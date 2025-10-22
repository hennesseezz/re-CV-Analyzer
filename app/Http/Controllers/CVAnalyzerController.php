<?php

namespace App\Http\Controllers;

use App\Models\CvAnalysis;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiAIService;
use App\Services\PDFProcessingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;

class CVAnalyzerController extends Controller
{
    private $aiService;
    private $pdfService;

    public function __construct(GeminiAIService $aiService, PDFProcessingService $pdfService)
    {
        $this->aiService = $aiService;
        $this->pdfService = $pdfService;
    }

    public function index()
    {
        return view('cv-analyzer');
    }

    public function showDetail($id)
    {
        $cvAnalysis = CvAnalysis::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $parsedData = json_decode($cvAnalysis->parsed_data, true) ?? [];
        $summary = json_decode($cvAnalysis->ai_summary, true) ?? $cvAnalysis->ai_summary;
        $recommendations = json_decode($cvAnalysis->career_recommendations, true) ?? [];

        if (is_array($summary)) {
            $summary = implode(" ", $summary);
        }

        $analysis = [
            'overall_score'         => $parsedData['overall_score'] ?? 0,
            'match_percentage'      => $parsedData['match_percentage'] ?? 0,
            'summary'               => $summary,
            'strengths'             => $parsedData['strengths'] ?? [],
            'weaknesses'            => $parsedData['weaknesses'] ?? [],
            'missing_skills'        => $parsedData['missing_skills'] ?? [],
            'detailed_analysis'     => $parsedData['detailed_analysis'] ?? [],
            'recommendations'       => $recommendations ?? [],
            'interview_preparation' => $parsedData['interview_preparation'] ?? [],
            'action_plan'           => $parsedData['action_plan'] ?? [],
        ];

        return view('cv-detail', compact('analysis', 'cvAnalysis'));
    }

    public function analyze(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cv_file' => 'required|file|mimes:pdf|max:10240',
            'job_requirements' => 'required|string|min:50|max:5000'
        ]);

        if ($validator->fails()) {
            Log::warning('CV Analysis validation failed', [
                'errors' => $validator->errors()->toArray(),
                'user_id' => Auth::id()
            ]);
            return back()->withErrors($validator)->withInput();
        }

        try {
            $file = $request->file('cv_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Don't store file on Vercel - process directly
            Log::info('Starting CV analysis', [
                'filename' => $filename,
                'user_id' => Auth::id(),
                'file_size' => $file->getSize()
            ]);

            // Process PDF without storing
            $pdfBase64 = $this->pdfService->convertToBase64($file);
            $jobRequirements = $request->input('job_requirements');

            Log::info('PDF converted to base64, calling AI service');

            // Analyze with AI
            $analysis = $this->aiService->analyzeCV($pdfBase64, $jobRequirements);

            Log::info('AI analysis completed successfully');

            // Process analysis data
            $parsedData = $analysis['parsed_data'] ?? [];

            $parsedData = [
                'overall_score'        => $parsedData['overall_score'] ?? ($analysis['overall_score'] ?? 0),
                'match_percentage'     => $parsedData['match_percentage'] ?? ($analysis['match_percentage'] ?? 0),
                'strengths'            => $parsedData['strengths'] ?? ($analysis['strengths'] ?? []),
                'weaknesses'           => $parsedData['weaknesses'] ?? ($analysis['weaknesses'] ?? []),
                'missing_skills'       => $parsedData['missing_skills'] ?? ($analysis['missing_skills'] ?? []),
                'detailed_analysis'    => $parsedData['detailed_analysis'] ?? ($analysis['detailed_analysis'] ?? []),
                'action_plan'          => $parsedData['action_plan'] ?? ($analysis['action_plan'] ?? []),
                'interview_preparation'=> $parsedData['interview_preparation'] ?? ($analysis['interview_preparation'] ?? []),
            ];

            $summary = $analysis['summary'] ?? '';
            if (is_array($summary)) {
                $summary = implode(" ", $summary);
            }

            $recommendations = $analysis['recommendations'] ?? [];
            if (!is_array($recommendations)) {
                $recommendations = [$recommendations];
            }

            // Save to database (without file path since we don't store files on Vercel)
            $cvAnalysis = CvAnalysis::create([
                'user_id' => Auth::id(),
                'cv_filename' => $filename,
                'cv_file_path' => null, // Don't store file on Vercel
                'extracted_text' => is_array($analysis['extracted_text'] ?? null)
                    ? json_encode($analysis['extracted_text'])
                    : ($analysis['extracted_text'] ?? null),
                'parsed_data' => json_encode($parsedData),
                'ai_summary' => $summary,
                'career_recommendations' => json_encode($recommendations),
                'status' => 'completed',
            ]);

            Log::info('CV analysis saved to database', [
                'cv_analysis_id' => $cvAnalysis->id,
                'user_id' => Auth::id()
            ]);

            return view('cv-results', [
                'analysis' => array_merge($parsedData, [
                    'summary' => $summary,
                    'recommendations' => $recommendations
                ]),
                'cvAnalysis' => $cvAnalysis,
                'saved' => true
            ]);

        } catch (Exception $e) {
            Log::error('CV Analysis failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);
            
            return back()
                ->with('error', 'Analysis failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function history()
    {
        $analyses = CvAnalysis::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('cv-history', compact('analyses'));
    }

    public function saveNotes(Request $request, $cv)
    {
        try {
            $cvAnalysis = CvAnalysis::where('id', $cv)
                ->where('user_id', Auth::id())
                ->firstOrFail();
                
            $cvAnalysis->user_notes = $request->input('user_notes');
            $cvAnalysis->save();

            Log::info('Notes saved successfully', [
                'cv_analysis_id' => $cv,
                'user_id' => Auth::id()
            ]);

            return response()->json(['message' => 'Notes saved successfully!']);
            
        } catch (Exception $e) {
            Log::error('Failed to save notes', [
                'error' => $e->getMessage(),
                'cv_analysis_id' => $cv,
                'user_id' => Auth::id()
            ]);
            
            return response()->json([
                'message' => 'Failed to save notes: ' . $e->getMessage()
            ], 500);
        }
    }
}