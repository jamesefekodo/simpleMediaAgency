@extends('layouts.authLayout')
@section('title', 'Login')
@section('content')

    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-heading">Welcome back</h2>
            <p class="auth-subtitle">
                Sign in to continue with {{ basicSystemInfo()->app_name ?? config('app.name') }}.
            </p>

            @if ($errors->any())
                <div class="auth-error visible" role="alert" aria-live="polite">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="form" id="loginForm" method="POST" action="{{ route('submitLoginRequest') }}">
                @csrf

                <div class="field">
                    <label for="login_id">Username/Email</label>

                    <input class="input" id="login_id" name="login_id" type="text" value="{{ old('login_id') }}"
                        placeholder="you@example.com" required>
                    <p style="color: red">{{ $errors->first('login_id') }}</p>
                </div>

                <div class="field">
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <input class="input password-input" id="password" name="password" type="password"
                            placeholder="Enter your password" autocomplete="none" required>

                        <button class="password-toggle" type="button" id="togglePassword" aria-label="Show password">
                            Show
                        </button>
                    </div>
                    <p style="color: red">{{ $errors->first('password') }}</p>
                </div>

                <div class="form-meta">
                    {{-- <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        Remember me
                    </label> --}}

                    <a class="forgot-link" href="{{ route('forgotPassword') }}">
                        Forgot password?
                    </a>
                </div>

                <button class="btn btn-primary" id="submitButton" type="submit">
                    <span class="spinner" aria-hidden="true"></span>
                    <span class="button-label">Sign in</span>
                </button>

                <div class="divider">or continue with</div>

                <a class="btn btn-google" href="{{ url('/auth/google/redirect') }}"> <i
                        class="fa-brands fa-google me-1"></i>
                    Continue with Google
                </a>

                <p class="auth-footer">
                    <span class="">
                        New to {{ basicSystemInfo()->app_name ?? config('app.name') }}?
                        <a href="{{ route('registrationPage') }}">Create an account</a>
                    </span> <br>
                    {{-- <span class="">
                        Forgot Password
                        <a href="{{ route('forgotPassword') }}">Click here</a>
                    </span> --}}
                </p>

            </form>

            <p class="legal">
                By continuing, you agree to {{ basicSystemInfo()->app_name ?? config('app.name') }}'s
                <a href="{{ url('/terms') }}">Terms</a>
                and
                <a href="{{ url('/privacy') }}">Privacy Policy</a>.
            </p>
        </div>
    </section>



@endsection
