@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('Login'))

@section('content')

<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-white p-8 md:p-10 shadow-lg rounded-2xl border border-gray-100">

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">
                            {{ \App\Helpers\TranslateHelper::translate('Welcome Back') }}
                        </h2>
                        <p class="text-gray-500 text-sm">
                            {{ \App\Helpers\TranslateHelper::translate('Login to your account to continue') }}
                        </p>
                    </div>

                    <!-- Error Messages -->
                    @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 relative" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="absolute top-2 right-2 text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ \App\Helpers\TranslateHelper::translate('Email Address') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('email') border-red-500 ring-2 ring-red-200 @enderror"
                                    id="email" name="email"
                                    placeholder="john@example.com"
                                    value="{{ old('email') }}"
                                    required>
                            </div>
                            @error('email')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ \App\Helpers\TranslateHelper::translate('Password') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password"
                                    class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('password') border-red-500 ring-2 ring-red-200 @enderror"
                                    id="password" name="password"
                                    placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter your password') }}"
                                    required>
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" id="togglePassword">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox"
                                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 cursor-pointer"
                                    id="remember" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900">
                                    {{ \App\Helpers\TranslateHelper::translate('Remember Me') }}
                                </span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-red-700 font-medium transition-colors">
                                {{ \App\Helpers\TranslateHelper::translate('Forgot Password?') }}
                            </a>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full bg-primary hover:bg-red-700 text-white py-3 px-4 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ \App\Helpers\TranslateHelper::translate('Login to Account') }}</span>
                        </button>

                        <!-- Register Link -->
                        <p class="text-center text-sm text-gray-600 mt-6">
                            {{ \App\Helpers\TranslateHelper::translate("Don't have an account?") }}
                            <a href="{{ route('register') }}" class="text-primary hover:text-red-700 font-semibold transition-colors">
                                {{ \App\Helpers\TranslateHelper::translate('Register Now') }}
                            </a>
                        </p>
                    </form>
                </div>

                <!-- Additional Info -->
                <div class="text-center mt-6">
                    <p class="text-xs text-gray-500">
                        {{ \App\Helpers\TranslateHelper::translate('By continuing, you agree to our') }}
                        <a href="#" class="text-primary hover:underline">{{ \App\Helpers\TranslateHelper::translate('Terms of Service') }}</a>
                        {{ \App\Helpers\TranslateHelper::translate('and') }}
                        <a href="#" class="text-primary hover:underline">{{ \App\Helpers\TranslateHelper::translate('Privacy Policy') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function(e) {
            e.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    }

    setTimeout(function() {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>
@endsection