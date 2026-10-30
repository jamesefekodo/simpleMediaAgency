@extends('layouts.authLayout')
@section('title', 'Register')
@section('content')

    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-heading">Create your account</h2>
            {{-- <p class="auth-subtitle">
                Get started with {{ basicSystemInfo()->app_name ?? config('app.name') }} today.
            </p> --}}

            @if ($errors->any())
                <div class="auth-error visible" role="alert" aria-live="polite">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="form" id="loginForm" method="POST" action="{{ route('submitUserRegistrationRequest') }}">
                @csrf

                <div class="field">
                    <label for="username">Username</label>
                    <input class="input" id="username" name="username" type="text" value="{{ old('username') }}"
                        placeholder="emekaBello" required>
                    <p style="color: red">{{ $errors->first('username') }}</p>
                </div>


                <div class="field">
                    <label for="email">Email</label>
                    <input class="input" id="email" name="email" type="email" value="{{ old('email') }}"
                        placeholder="emekabello@example.com" required>
                    <p style="color: red">{{ $errors->first('email') }}</p>
                </div>

                <div class="field">
                    <label for="phone">Phone</label>
                    <input class="input" id="phone" name="phone" type="text" value="{{ old('phone') }}"
                        placeholder="+2349123456789" required>
                    <p style="color: red">{{ $errors->first('phone') }}</p>
                </div>

                <div class="field">
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <input class="input password-input" id="password" name="password" type="password"
                            placeholder="Enter your password" autocomplete="new-password" required>

                        <button class="password-toggle" type="button" aria-label="Show password">
                            Show
                        </button>
                    </div>
                </div>
                <p style="color: red">{{ $errors->first('password') }}</p>

                <div class="field">
                    <label for="password_confirmation">Confirm Password</label>

                    <div class="input-wrap">
                        <input class="input password-input" id="password_confirmation" name="password_confirmation"
                            type="password" placeholder="Confirm your password" autocomplete="new-password" required>

                        <button class="password-toggle" type="button" aria-label="Show password">
                            Show
                        </button>
                    </div>
                </div>
                <p style="color: red">{{ $errors->first('password_confirmation') }}</p>


                <div class="form-meta">
                    <a class="forgot-link" {{-- href="{{ route('password.request') }}" --}}>
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
                        Already have an account?
                        <a href="{{ route('registrationPage') }}">Log in</a>
                    </span>
                </p>

            </form>

        </div>
    </section>



@endsection
