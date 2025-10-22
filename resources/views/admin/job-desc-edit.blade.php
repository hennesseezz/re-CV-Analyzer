<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job Description - CV Analyzer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold">CV Analyzer - Admin</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm">Welcome, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white min-h-screen shadow-lg">
            <div class="p-6">
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-gray-700 hover:bg-gray-100 px-4 py-3 rounded-lg font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.job-desc') }}" class="flex items-center space-x-3 bg-blue-50 text-blue-700 px-4 py-3 rounded-lg font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Job Desc Management</span>
                    </a>
                    <a href="{{ route('admin.monitoring') }}" class="flex items-center space-x-3 text-gray-700 hover:bg-gray-100 px-4 py-3 rounded-lg font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span>Monitoring</span>
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="flex items-center space-x-3 text-gray-700 hover:bg-gray-100 px-4 py-3 rounded-lg font-semibold transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Analytics</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Edit Job Description</h2>
                        <p class="text-gray-600">Update job description for CV matching</p>
                    </div>
                    <a href="{{ route('admin.job-desc') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                        ← Back to List
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-md p-8">
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.job-desc.update', $jobDescription->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Job Title -->
                        <div>
                            <label for="job_title" class="block text-sm font-semibold text-gray-700 mb-2">Job Title *</label>
                            <input type="text" 
                                   id="job_title" 
                                   name="job_title" 
                                   value="{{ old('job_title', $jobDescription->job_title) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="e.g., Senior Software Engineer">
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department" class="block text-sm font-semibold text-gray-700 mb-2">Department *</label>
                            <input type="text" 
                                   id="department" 
                                   name="department" 
                                   value="{{ old('department', $jobDescription->department) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                   placeholder="e.g., Engineering">
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Job Description *</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                  placeholder="Describe the job position...">{{ old('description', $jobDescription->description) }}</textarea>
                    </div>

                    <!-- Requirements -->
                    <div class="mb-6">
                        <label for="requirements" class="block text-sm font-semibold text-gray-700 mb-2">Requirements</label>
                        <textarea id="requirements" 
                                  name="requirements" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                  placeholder="List the job requirements...">{{ old('requirements', $jobDescription->requirements) }}</textarea>
                    </div>

                    <!-- Responsibilities -->
                    <div class="mb-6">
                        <label for="responsibilities" class="block text-sm font-semibold text-gray-700 mb-2">Responsibilities</label>
                        <textarea id="responsibilities" 
                                  name="responsibilities" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                  placeholder="List the job responsibilities...">{{ old('responsibilities', $jobDescription->responsibilities) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Experience Level -->
                        <div>
                            <label for="experience_level" class="block text-sm font-semibold text-gray-700 mb-2">Experience Level</label>
                            <select id="experience_level" 
                                    name="experience_level"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Select Level</option>
                                <option value="Entry Level" {{ old('experience_level', $jobDescription->experience_level) == 'Entry Level' ? 'selected' : '' }}>Entry Level</option>
                                <option value="Junior" {{ old('experience_level', $jobDescription->experience_level) == 'Junior' ? 'selected' : '' }}>Junior (1-3 years)</option>
                                <option value="Mid-Level" {{ old('experience_level', $jobDescription->experience_level) == 'Mid-Level' ? 'selected' : '' }}>Mid-Level (3-5 years)</option>
                                <option value="Senior" {{ old('experience_level', $jobDescription->experience_level) == 'Senior' ? 'selected' : '' }}>Senior (5+ years)</option>
                                <option value="Lead" {{ old('experience_level', $jobDescription->experience_level) == 'Lead' ? 'selected' : '' }}>Lead/Principal</option>
                            </select>
                        </div>

                        <!-- Education Level -->
                        <div>
                            <label for="education_level" class="block text-sm font-semibold text-gray-700 mb-2">Education Level</label>
                            <select id="education_level" 
                                    name="education_level"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Select Level</option>
                                <option value="High School" {{ old('education_level', $jobDescription->education_level) == 'High School' ? 'selected' : '' }}>High School</option>
                                <option value="Associate Degree" {{ old('education_level', $jobDescription->education_level) == 'Associate Degree' ? 'selected' : '' }}>Associate Degree</option>
                                <option value="Bachelor's Degree" {{ old('education_level', $jobDescription->education_level) == "Bachelor's Degree" ? 'selected' : '' }}>Bachelor's Degree</option>
                                <option value="Master's Degree" {{ old('education_level', $jobDescription->education_level) == "Master's Degree" ? 'selected' : '' }}>Master's Degree</option>
                                <option value="PhD" {{ old('education_level', $jobDescription->education_level) == 'PhD' ? 'selected' : '' }}>PhD</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                            <select id="status" 
                                    name="status"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="active" {{ old('status', $jobDescription->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $jobDescription->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.job-desc') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold transition">
                            Cancel
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-indigo-700 transition shadow-lg">
                            Update Job Description
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
