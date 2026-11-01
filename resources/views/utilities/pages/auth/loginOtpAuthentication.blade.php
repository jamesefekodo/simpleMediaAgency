@extends('layouts.authLayout')
@section('title', 'Confirm Your Sign-In')
@section('content')

    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-heading">Confirm Your Sign-In</h2>
            <p class="auth-subtitle">
                Enter the verification code sent to your email address to securely complete your sign-in.
            </p>

            @if ($errors->any())
                <div class="auth-error visible" role="alert" aria-live="polite">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="form" id="loginForm registrationForm" method="POST" action="{{ route('verifyLoginOtpSubmit') }}">
                @csrf

                <div class="field">
                    <label for="email">Verification Code</label>

                    <input class="input" id="login_otp" name="login_otp" type="number" value="{{ old('login_otp') }}"
                        placeholder="******" autocomplete="none" required>
                    <p style="color: red">{{ $errors->first('login_otp') }}</p>
                </div>
                <button class="btn btn-primary" id="submitButton" type="submit">
                    <span class="spinner" aria-hidden="true"></span>
                    <span class="button-label">Submit</span>
                </button>

            </form>


            <div class="d-flex gap-2 mt-5">
                <a href="{{ route('resendLoginOtp') }}" class="btn btn-primary flex-fill py-2">
                    <i class="fas fa-rotate-right me-2"></i>
                    Resend OTP
                </a>

                <a href="{{ route('logoutRequest') }}" class="btn btn-outline-danger flex-fill py-2">
                    <i class="fas fa-right-from-bracket me-2"></i>
                    Logout
                </a>

            </div>
        </div>
    </section>



@endsection
