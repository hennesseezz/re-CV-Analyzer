<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Analyzer - AI-Powered CV Analysis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm mb-8">
    <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="text-xl font-bold text-gray-800">CV Analyzer</div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">
                        Selamat datang, <span class="font-semibold text-gray-800">{{ auth()->user()->name }}</span>
                    </span>

                    <a href="{{ route('cv.history') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        📜 Riwayat Analisis
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>


    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">CV Analyzer</h1>
            <p class="text-gray-600 text-lg">AI-Powered CV Analysis & Career Recommendations</p>
        </div>

        <!-- Main Form -->
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('analyze.cv') }}" method="POST" enctype="multipart/form-data" id="cvForm">
                @csrf

                <!-- CV Upload -->
                <div class="mb-6">
                    <label for="cv_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Your CV (PDF only)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="cv_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload your CV</span>
                                    <input id="cv_file" name="cv_file" type="file" accept=".pdf" class="sr-only" required>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF up to 10MB</p>
                        </div>
                    </div>
                    <div id="fileName" class="mt-2 text-sm text-gray-600"></div>
                </div>

                <!-- Job Requirements -->
                <div class="mb-6">
                    <label for="job_requirements" class="block text-sm font-medium text-gray-700 mb-2">
                        Job Requirements
                    </label>
                    <textarea
                        id="job_requirements"
                        name="job_requirements"
                        rows="8"
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-3"
                        placeholder="Paste the complete job description or requirements here. Include required skills, experience level, education requirements, and any specific qualifications..."
                        required
                    >{{ old('job_requirements') }}</textarea>
                    <p class="mt-2 text-sm text-gray-500">Min 50 characters, max 5000 characters</p>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button
                        type="submit"
                        id="analyzeBtn"
                        class="w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                    >
                        <svg id="loadingIcon" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="btnText">Analyze CV with AI</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Features Section -->
        <div class="max-w-4xl mx-auto mt-12">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">What You'll Get</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-white rounded-lg shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">CV Score & Match %</h3>
                    <p class="text-gray-600 text-sm">Get an overall score and see how well your CV matches the job requirements</p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Personalized Recommendations</h3>
                    <p class="text-gray-600 text-sm">Get specific courses, projects, and skills to improve your chances</p>
                </div>

                <div class="text-center p-6 bg-white rounded-lg shadow">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-2">Action Plan</h3>
                    <p class="text-gray-600 text-sm">Receive a timeline-based plan to improve your profile step by step</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File upload handling
        document.getElementById('cv_file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            document.getElementById('fileName').textContent = fileName ? `Selected: ${fileName}` : '';
        });

        // Form submission handling
        document.getElementById('cvForm').addEventListener('submit', function() {
            const btn = document.getElementById('analyzeBtn');
            const loadingIcon = document.getElementById('loadingIcon');
            const btnText = document.getElementById('btnText');

            btn.disabled = true;
            loadingIcon.classList.remove('hidden');
            btnText.textContent = 'Analyzing with AI...';

            // Re-enable after timeout (in case of error)
            setTimeout(() => {
                btn.disabled = false;
                loadingIcon.classList.add('hidden');
                btnText.textContent = 'Analyze CV with AI';
            }, 60000);
        });
    </script>
</body>
</html>
