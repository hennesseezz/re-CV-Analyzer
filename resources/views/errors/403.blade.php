<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Unauthorized</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-orange-100 min-h-screen flex items-center justify-center">
    <div class="text-center">
        <div class="mb-8">
            <svg class="w-32 h-32 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h1 class="text-6xl font-bold text-gray-800 mb-4">403</h1>
        <p class="text-2xl text-gray-600 mb-8">Unauthorized Access</p>
        <p class="text-gray-500 mb-8">You don't have permission to access this page.</p>
        
        @if(auth()->check())
            @if(auth()->user()->role === 'admin')
                <a href="/admin/dashboard" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
                    Go to Admin Dashboard
                </a>
            @else
                <a href="/home" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
                    Go to Home
                </a>
            @endif
        @else
            <a href="/login" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition inline-block">
                Go to Login
            </a>
        @endif
    </div>
</body>
</html>
