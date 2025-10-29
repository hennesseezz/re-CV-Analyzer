<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CV Analyzer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center py-8">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h1>
            <p class="text-gray-600">Register to get started</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Popup for Duplicate -->
        @if(session('error_type') == 'validation')
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                @if($errors->has('name'))
                    <p>Username telah digunakan</p>
                @elseif($errors->has('email'))
                    <p>Email telah digunakan</p>
                @else
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <!-- Regular Error Messages -->
        @if($errors->any() && !session('error_type'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" id="registerForm">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       placeholder="John Doe">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       placeholder="your@email.com">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <div class="relative">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition pr-10"
                           placeholder="••••••••">
                    <button type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            onclick="togglePassword('password')">
                        <svg id="passwordEye" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <div id="passwordRequirements" class="mt-2 space-y-1">
                    <p class="text-sm text-gray-500">Password must contain:</p>
                    <div class="flex items-center text-xs">
                        <span id="lengthReq" class="text-red-500">●</span>
                        <span class="ml-1">Minimum 8 characters</span>
                    </div>
                    <div class="flex items-center text-xs">
                        <span id="lowercaseReq" class="text-red-500">●</span>
                        <span class="ml-1">At least one lowercase letter</span>
                    </div>
                    <div class="flex items-center text-xs">
                        <span id="uppercaseReq" class="text-red-500">●</span>
                        <span class="ml-1">At least one uppercase letter</span>
                    </div>
                    <div class="flex items-center text-xs">
                        <span id="numberReq" class="text-red-500">●</span>
                        <span class="ml-1">At least one number</span>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirm Password</label>
                <div class="relative">
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition pr-10"
                           placeholder="••••••••">
                    <button type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center"
                            onclick="togglePassword('password_confirmation')">
                        <svg id="confirmPasswordEye" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <div id="passwordMatch" class="hidden mt-2 text-sm text-red-500">
                    Passwords do not match
                </div>
            </div>

            <button type="submit" 
                    id="submitBtn"
                    class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold py-3 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                Register
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Login here</a>
            </p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId === 'password' ? 'passwordEye' : 'confirmPasswordEye');
            
            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                field.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        // Password validation
        function validatePassword(password) {
            const requirements = {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password),
                number: /[0-9]/.test(password)
            };

            // Update requirement indicators
            document.getElementById('lengthReq').style.color = requirements.length ? 'green' : 'red';
            document.getElementById('lowercaseReq').style.color = requirements.lowercase ? 'green' : 'red';
            document.getElementById('uppercaseReq').style.color = requirements.uppercase ? 'green' : 'red';
            document.getElementById('numberReq').style.color = requirements.number ? 'green' : 'red';

            return requirements.length && requirements.lowercase && requirements.uppercase && requirements.number;
        }

        // Check password match
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchElement = document.getElementById('passwordMatch');

            if (confirmPassword && password !== confirmPassword) {
                matchElement.classList.remove('hidden');
                return false;
            } else {
                matchElement.classList.add('hidden');
                return true;
            }
        }

        // Update submit button state
        function updateSubmitButton() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;

            const isPasswordValid = validatePassword(password);
            const isPasswordMatch = checkPasswordMatch();
            const isFormValid = name && email && password && confirmPassword && isPasswordValid && isPasswordMatch;

            document.getElementById('submitBtn').disabled = !isFormValid;
        }

        // Event listeners
        document.getElementById('password').addEventListener('input', updateSubmitButton);
        document.getElementById('password_confirmation').addEventListener('input', updateSubmitButton);
        document.getElementById('name').addEventListener('input', updateSubmitButton);
        document.getElementById('email').addEventListener('input', updateSubmitButton);

        // Initialize submit button state
        updateSubmitButton();
    </script>
</body>
</html>