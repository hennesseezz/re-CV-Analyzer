<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobDescription;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function jobDescManagement()
    {
        $jobDescriptions = JobDescription::with('creator')->latest()->get();
        return view('admin.job-desc-management', compact('jobDescriptions'));
    }

    public function createJobDesc()
    {
        return view('admin.job-desc-create');
    }

    public function storeJobDesc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'skills_required' => 'nullable|string',
            'experience_level' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        JobDescription::create([
            'job_title' => $request->job_title,
            'department' => $request->department,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'responsibilities' => $request->responsibilities,
            'skills_required' => $request->skills_required,
            'experience_level' => $request->experience_level,
            'education_level' => $request->education_level,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.job-desc')->with('success', 'Job description created successfully!');
    }

    public function editJobDesc($id)
    {
        $jobDescription = JobDescription::findOrFail($id);
        return view('admin.job-desc-edit', compact('jobDescription'));
    }

    public function updateJobDesc(Request $request, $id)
    {
        $jobDescription = JobDescription::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'job_title' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'skills_required' => 'nullable|string',
            'experience_level' => 'nullable|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $jobDescription->update($request->all());

        return redirect()->route('admin.job-desc')->with('success', 'Job description updated successfully!');
    }

    public function deleteJobDesc($id)
    {
        $jobDescription = JobDescription::findOrFail($id);
        $jobDescription->delete();

        return redirect()->route('admin.job-desc')->with('success', 'Job description deleted successfully!');
    }

    public function monitoring()
    {
        return view('admin.monitoring');
    }

    public function analytics()
    {
        return view('admin.analytics');
    }
}
