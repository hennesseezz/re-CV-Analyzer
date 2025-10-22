<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Analysis Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">CV Analysis Results</h1>
            <p class="text-gray-600">AI-powered insights for your career development</p>
            <a href="{{ route('cv.history') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800 underline">← Back to History</a>
        </div>

        @if(isset($analysis['error']))
            <div class="max-w-4xl mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <h3 class="font-bold">Analysis Error:</h3>
                <p>{{ $analysis['error'] }}</p>
                @if(isset($analysis['raw_response']))
                    <details class="mt-4">
                        <summary class="cursor-pointer font-semibold">Raw Response (for debugging)</summary>
                        <pre class="mt-2 p-2 bg-gray-100 rounded text-sm overflow-x-auto">{{ $analysis['raw_response'] }}</pre>
                    </details>
                @endif
            </div>
        @endif

        <!-- Score Overview -->
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Overall Score</h2>
                <div class="flex items-center justify-center">
                    <canvas id="scoreChart" width="200" height="200"></canvas>
                </div>
                <div class="text-center mt-4">
                    <span class="text-3xl font-bold text-blue-600">{{ $analysis['overall_score'] ?? 0 }}/100</span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Job Match</h2>
                <div class="flex items-center justify-center">
                    <canvas id="matchChart" width="200" height="200"></canvas>
                </div>
                <div class="text-center mt-4">
                    <span class="text-3xl font-bold text-green-600">{{ $analysis['match_percentage'] ?? 0 }}%</span>
                </div>
            </div>
        </div>

        <!-- Summary -->
        @if(isset($analysis['summary']))
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Summary</h2>
            <p class="text-gray-700">{{ $analysis['summary'] }}</p>
        </div>
        @endif

        <!-- Strengths & Weaknesses -->
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-6 mb-8">
            @if(isset($analysis['strengths']))
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-green-800 mb-4">✅ Strengths</h2>
                <ul class="space-y-2">
                    @foreach($analysis['strengths'] as $strength)
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2">•</span>
                            <span class="text-gray-700">{{ $strength }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(isset($analysis['weaknesses']))
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-red-800 mb-4">⚠️ Areas to Improve</h2>
                <ul class="space-y-2">
                    @foreach($analysis['weaknesses'] as $weakness)
                        <li class="flex items-start">
                            <span class="text-red-500 mr-2">•</span>
                            <span class="text-gray-700">{{ $weakness }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <!-- Missing Skills -->
        @if(isset($analysis['missing_skills']) && !empty($analysis['missing_skills']))
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-orange-800 mb-4">🎯 Missing Key Skills</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($analysis['missing_skills'] as $skill)
                    <div class="bg-orange-100 px-3 py-2 rounded-lg text-center">
                        <span class="text-orange-800 font-medium">{{ $skill }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Detailed Analysis -->
        @if(isset($analysis['detailed_analysis']))
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">📊 Detailed Analysis</h2>
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($analysis['detailed_analysis'] as $category => $details)
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h3 class="font-semibold text-gray-800 capitalize mb-2">{{ str_replace('_', ' ', $category) }}</h3>
                        <p class="text-gray-600 text-sm">{{ $details }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recommendations -->
        @if(isset($analysis['recommendations']))
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- Immediate Improvements -->
            @if(isset($analysis['recommendations']['immediate_improvements']))
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-blue-800 mb-4">🚀 Immediate CV Improvements</h2>
                <ul class="space-y-3">
                    @foreach($analysis['recommendations']['immediate_improvements'] as $improvement)
                        <li class="flex items-start">
                            <span class="bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-xs font-medium mr-3 mt-1 flex-shrink-0">{{ $loop->iteration }}</span>
                            <span class="text-gray-700">{{ $improvement }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Courses & Bootcamps -->
            @if(isset($analysis['recommendations']['courses_bootcamps']) && !empty($analysis['recommendations']['courses_bootcamps']))
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-purple-800 mb-4">🎓 Recommended Courses & Bootcamps</h2>
                <div class="grid gap-4">
                    @foreach($analysis['recommendations']['courses_bootcamps'] as $course)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-800">{{ $course['name'] ?? 'Course' }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ ($course['priority'] ?? 'Medium') === 'High' ? 'bg-red-100 text-red-800' :
                                       (($course['priority'] ?? 'Medium') === 'Low' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $course['priority'] ?? 'Medium' }} Priority
                                </span>
                            </div>
                            @if(isset($course['provider']))
                                <p class="text-sm text-gray-600 mb-1"><strong>Provider:</strong> {{ $course['provider'] }}</p>
                            @endif
                            @if(isset($course['focus']))
                                <p class="text-sm text-gray-600 mb-1"><strong>Focus:</strong> {{ $course['focus'] }}</p>
                            @endif
                            @if(isset($course['duration']))
                                <p class="text-sm text-gray-600"><strong>Duration:</strong> {{ $course['duration'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Project Recommendations -->
            @if(isset($analysis['recommendations']['projects']) && !empty($analysis['recommendations']['projects']))
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-green-800 mb-4">💻 Suggested Projects</h2>
                <div class="space-y-4">
                    @foreach($analysis['recommendations']['projects'] as $project)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-800">{{ $project['title'] ?? 'Project' }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ ($project['difficulty'] ?? 'Intermediate') === 'Beginner' ? 'bg-green-100 text-green-800' :
                                       (($project['difficulty'] ?? 'Intermediate') === 'Advanced' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ $project['difficulty'] ?? 'Intermediate' }}
                                </span>
                            </div>
                            @if(isset($project['description']))
                                <p class="text-gray-600 mb-3">{{ $project['description'] }}</p>
                            @endif
                            @if(isset($project['technologies']) && !empty($project['technologies']))
                                <div class="mb-2">
                                    <span class="text-sm font-medium text-gray-700">Technologies: </span>
                                    @foreach($project['technologies'] as $tech)
                                        <span class="inline-block bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs mr-1 mb-1">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                            @if(isset($project['impact']))
                                <p class="text-sm text-blue-600"><strong>Impact:</strong> {{ $project['impact'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Certifications -->
            @if(isset($analysis['recommendations']['certifications']) && !empty($analysis['recommendations']['certifications']))
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-indigo-800 mb-4">🏆 Recommended Certifications</h2>
                <div class="grid md:grid-cols-2 gap-3">
                    @foreach($analysis['recommendations']['certifications'] as $cert)
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3 text-center">
                            <span class="text-indigo-800 font-medium">{{ $cert }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Skill Development -->
            @if(isset($analysis['recommendations']['skill_development']) && !empty($analysis['recommendations']['skill_development']))
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-orange-800 mb-4">📚 Skills to Develop</h2>
                <ul class="space-y-2">
                    @foreach($analysis['recommendations']['skill_development'] as $skill)
                        <li class="flex items-start">
                            <span class="text-orange-500 mr-2">•</span>
                            <span class="text-gray-700">{{ $skill }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        @endif

        <!-- Interview Preparation -->
        @if(isset($analysis['interview_preparation']) && !empty($analysis['interview_preparation']))
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 mt-8">
            <h2 class="text-xl font-bold text-purple-800 mb-4">🎤 Likely Interview Questions</h2>
            <div class="space-y-3">
                @foreach($analysis['interview_preparation'] as $question)
                    <div class="bg-purple-50 border-l-4 border-purple-400 p-3 rounded">
                        <p class="text-purple-800">{{ $question }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Action Plan -->
        @if(isset($analysis['action_plan']))
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">📅 Your Action Plan</h2>
            <div class="space-y-6">
                @if(isset($analysis['action_plan']['week_1']))
                <div class="border-l-4 border-green-500 pl-4">
                    <h3 class="font-semibold text-green-800 mb-2">Week 1 Focus</h3>
                    <p class="text-gray-600">{{ $analysis['action_plan']['week_1'] }}</p>
                </div>
                @endif

                @if(isset($analysis['action_plan']['month_1']))
                <div class="border-l-4 border-blue-500 pl-4">
                    <h3 class="font-semibold text-blue-800 mb-2">Month 1 Goals</h3>
                    <p class="text-gray-600">{{ $analysis['action_plan']['month_1'] }}</p>
                </div>
                @endif

                @if(isset($analysis['action_plan']['month_3']))
                <div class="border-l-4 border-purple-500 pl-4">
                    <h3 class="font-semibold text-purple-800 mb-2">3-Month Target</h3>
                    <p class="text-gray-600">{{ $analysis['action_plan']['month_3'] }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

         <!-- User Notes -->
        @if(!empty($cvAnalysis->user_notes))
            <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">📝 User Feedback</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $cvAnalysis->user_notes }}</p>
            </div>
        @endif


        <!-- Back to Top -->
        <div class="text-center mt-12">
            <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                Home
            </a>
        </div>
    </div>

    <script>
        // Create score chart
        const scoreCtx = document.getElementById('scoreChart').getContext('2d');
        const score = {{ $analysis['overall_score'] ?? 0 }};

        new Chart(scoreCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [score, 100 - score],
                    backgroundColor: ['#3B82F6', '#E5E7EB'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const matchCtx = document.getElementById('matchChart').getContext('2d');
        const matchPercentage = {{ $analysis['match_percentage'] ?? 0 }};

        new Chart(matchCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [matchPercentage, 100 - matchPercentage],
                    backgroundColor: ['#10B981', '#E5E7EB'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>
