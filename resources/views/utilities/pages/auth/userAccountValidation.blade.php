@extends('layouts.authLayout')
@section('title', 'Verify Email')
@section('content')

    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-heading">Verify Your Email</h2>
            <p class="auth-subtitle">
                Enter the code sent to your email address to confirm it
                and continue setting up your account.
            </p>

            @if ($errors->any())
                <div class="auth-error visible" role="alert" aria-live="polite">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="form" id="loginForm registrationForm" method="POST"
            action="{{ route('verifyUserEmailSubmit') }}"
            >
                @csrf

                <div class="field">
                    <label for="email">Verification Code</label>

                    <input class="input" id="email_verification_code" name="email_verification_code" type="number"
                        value="{{ old('email_verification_code') }}" placeholder="******" required>
                    <p style="color: red">{{ $errors->first('email_verification_code') }}</p>
                </div>
                <button class="btn btn-primary" id="submitButton" type="submit">
                    <span class="spinner" aria-hidden="true"></span>
                    <span class="button-label">Submit</span>
                </button>

            </form>


            <div class="d-flex gap-2 mt-5">
                <a href="{{ route('verifyUserEmailResendOtp') }}" class="btn btn-primary flex-fill py-2">
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
