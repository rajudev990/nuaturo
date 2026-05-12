@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="py-12" style="background: #f1eef5;">
    <div class="container mx-auto px-4 text-left">
        <div class="flex justify-center">
            <div class="w-full lg:w-5/12 md:w-2/3">
                <div class="bg-white p-8 md:p-10 shadow-sm rounded-2xl">
                    <h2 class="text-2xl font-bold text-green-600 text-center mb-6 pb-4 border-b border-gray-200">
                        Create Your Account
                    </h2>

                    @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                            <span class="text-green-500">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul class="mb-0 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                            <span class="text-red-500">&times;</span>
                        </button>
                    </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" id="registerForm">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name
                            </label>
                            <input
                                type="text"
                                name="name"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                id="name"
                                placeholder="John Doe"
                                value="{{ old('name') }}"
                                required>
                            @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                id="email"
                                placeholder="john@example.com"
                                value="{{ old('email') }}"
                                required>
                            @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 relative">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    name="password"
                                    class="w-full px-4 py-2 pr-12 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                    id="password"
                                    placeholder="Enter your password"
                                    required>
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer" id="togglePassword">
                                    <i class="fas fa-eye text-gray-500" id="eyeIcon"></i>
                                </span>
                            </div>
                            @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 relative">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="w-full px-4 py-2 pr-12 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    id="password_confirmation"
                                    placeholder="Confirm your password"
                                    required>
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer" id="toggleConfirmPassword">
                                    <i class="fas fa-eye text-gray-500" id="confirmEyeIcon"></i>
                                </span>
                            </div>
                            <div id="passwordMatchMsg" class="text-red-500 text-sm mt-1 hidden">Passwords do not match!</div>
                            @error('password_confirmation')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 flex items-center">
                            <input 
                                type="checkbox" 
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" 
                                id="terms" 
                                required>
                            <label class="ml-2 text-sm text-gray-700" for="terms">
                                I agree to the <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Terms & Conditions</a>
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i> Register
                        </button>

                        <p class="text-center mt-4 text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login Now</a>
                        </p>
                    </form>

                    {{-- Password Toggle & Match Check --}}
                    <script>
                        const passwordInput = document.getElementById('password');
                        const confirmInput = document.getElementById('password_confirmation');
                        const eyeIcon = document.getElementById('eyeIcon');
                        const confirmEyeIcon = document.getElementById('confirmEyeIcon');
                        const passwordMsg = document.getElementById('passwordMatchMsg');

                        // Toggle main password
                        document.getElementById('togglePassword').addEventListener('click', function() {
                            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordInput.setAttribute('type', type);
                            eyeIcon.classList.toggle('fa-eye-slash');
                        });

                        // Toggle confirm password
                        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                            const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                            confirmInput.setAttribute('type', type);
                            confirmEyeIcon.classList.toggle('fa-eye-slash');
                        });

                        // Check password match (live)
                        confirmInput.addEventListener('input', function() {
                            if (confirmInput.value !== passwordInput.value) {
                                passwordMsg.classList.remove('hidden');
                            } else {
                                passwordMsg.classList.add('hidden');
                            }
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection