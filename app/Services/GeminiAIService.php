<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GeminiAIService
{
    private $apiKey;
    private $model;
    private $temperature;
    private $maxOutputTokens;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model', 'gemini-2.0-flash-exp');
        $this->temperature = config('services.gemini.temperature', 0.3);
        $this->maxOutputTokens = config('services.gemini.max_output_tokens', 4000);
        
        if (!$this->apiKey) {
            throw new Exception('Gemini API key is not configured');
        }
    }

    /**
     * Main method to analyze CV against job requirements
     */
    public function analyzeCV(string $pdfBase64Content, string $jobRequirements): array
    {
        $prompt = $this->buildAnalysisPrompt($jobRequirements);
        $response = $this->callGeminiAPI($pdfBase64Content, $prompt);
        return $this->parseResponse($response);
    }

    /**
     * Call Gemini API with PDF and prompt
     */
    private function callGeminiAPI(string $pdfContent, string $prompt): string
    {
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        [
                            'inline_data' => [
                                'mime_type' => 'application/pdf',
                                'data' => $pdfContent
                            ]
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => $this->temperature,
                'maxOutputTokens' => $this->maxOutputTokens,
            ]
        ];

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
        
        $response = Http::timeout(60)
            ->post("{$url}?key={$this->apiKey}", $payload);

        if (!$response->successful()) {
            throw new Exception('Gemini API request failed: ' . $response->body());
        }

        $data = $response->json();

        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            throw new Exception('Invalid response format from Gemini API');
        }

        return $data['candidates'][0]['content']['parts'][0]['text'];
    }

    /**
     * Build the comprehensive analysis prompt
     * EDIT THIS METHOD to customize AI behavior
     */
    private function buildAnalysisPrompt(string $jobRequirements): string
    {
        return "
You are an expert CV/Resume analyzer and career advisor. Analyze the provided CV/Resume PDF against the given job requirements and provide a comprehensive evaluation.

**JOB REQUIREMENTS:**
{$jobRequirements}

**ANALYSIS INSTRUCTIONS:**
Please analyze the CV and provide your response in the following JSON format:

```json
{
    \"overall_score\": [0-100 integer score],
    \"match_percentage\": [0-100 percentage of how well the CV matches job requirements],
    \"summary\": \"Brief 2-3 sentence summary of the analysis\",
    \"strengths\": [
        \"List of 3-5 key strengths found in the CV\"
    ],
    \"weaknesses\": [
        \"List of 3-5 areas that need improvement\"
    ],
    \"missing_skills\": [
        \"List of important skills/qualifications missing from CV\"
    ],
    \"detailed_analysis\": {
        \"technical_skills\": \"Analysis of technical skills alignment\",
        \"experience\": \"Analysis of work experience relevance\",
        \"education\": \"Analysis of educational background\",
        \"soft_skills\": \"Analysis of soft skills demonstration\"
    },
    \"recommendations\": {
        \"immediate_improvements\": [
            \"List of 3-5 immediate changes to make to the CV\"
        ],
        \"skill_development\": [
            \"List of 3-5 skills to develop with specific resources\"
        ],
        \"courses_bootcamps\": [
            {
                \"name\": \"Course/Bootcamp name\",
                \"provider\": \"Provider name\",
                \"focus\": \"What it addresses\",
                \"duration\": \"Estimated duration\",
                \"priority\": \"High/Medium/Low\"
            }
        ],
        \"projects\": [
            {
                \"title\": \"Suggested project title\",
                \"description\": \"What to build and why\",
                \"technologies\": [\"List of technologies to use\"],
                \"difficulty\": \"Beginner/Intermediate/Advanced\",
                \"impact\": \"How it helps the application\"
            }
        ],
        \"certifications\": [
            \"List of relevant certifications to pursue\"
        ]
    },
    \"interview_preparation\": [
        \"List of 5-7 likely interview questions based on job requirements\"
    ],
    \"action_plan\": {
        \"week_1\": \"What to focus on in the first week\",
        \"month_1\": \"Goals for the first month\",
        \"month_3\": \"3-month improvement goals\"
    }
}
```

**IMPORTANT GUIDELINES:**
1. Be honest and constructive in your feedback
2. Provide specific, actionable recommendations
3. Consider both technical and soft skills
4. Suggest real courses, bootcamps, and certifications when possible
5. Tailor project suggestions to the specific role
6. Make recommendations practical and achievable
7. Consider the candidate's current level when suggesting improvements

Analyze the CV thoroughly and provide the detailed JSON response above.
        ";
    }

    /**
     * Parse the AI response into structured array
     */
    private function parseResponse(string $rawResponse): array
    {
        // Extract JSON from response
        $jsonStart = strpos($rawResponse, '{');
        $jsonEnd = strrpos($rawResponse, '}');
        
        if ($jsonStart === false || $jsonEnd === false) {
            return $this->createErrorResponse('Invalid response format', $rawResponse);
        }
        
        $jsonString = substr($rawResponse, $jsonStart, $jsonEnd - $jsonStart + 1);
        $analysis = json_decode($jsonString, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->createErrorResponse('JSON parsing failed: ' . json_last_error_msg(), $rawResponse);
        }
        
        return $this->validateAndNormalizeResponse($analysis);
    }

    /**
     * Validate and normalize the response structure
     */
    private function validateAndNormalizeResponse(array $analysis): array
    {
        // Ensure all required fields exist with defaults
        $defaults = [
            'overall_score' => 0,
            'match_percentage' => 0,
            'summary' => 'Analysis completed.',
            'strengths' => [],
            'weaknesses' => [],
            'missing_skills' => [],
            'detailed_analysis' => [],
            'recommendations' => [],
            'interview_preparation' => [],
            'action_plan' => []
        ];

        return array_merge($defaults, $analysis);
    }

    /**
     * Create error response when parsing fails
     */
    private function createErrorResponse(string $error, string $rawResponse): array
    {
        return [
            'overall_score' => 0,
            'match_percentage' => 0,
            'summary' => 'Analysis completed but response format needs adjustment.',
            'error' => $error,
            'raw_response' => $rawResponse,
            'strengths' => [],
            'weaknesses' => [],
            'missing_skills' => [],
        ];
    }

    /**
     * Update API configuration on the fly if needed
     */
    public function configure(array $config): self
    {
        if (isset($config['temperature'])) {
            $this->temperature = $config['temperature'];
        }
        
        if (isset($config['max_output_tokens'])) {
            $this->maxOutputTokens = $config['max_output_tokens'];
        }
        
        if (isset($config['model'])) {
            $this->model = $config['model'];
        }
        
        return $this;
    }
}