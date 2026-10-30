@extends('layouts.authLayout')
@section('title', 'Forgot your password?')
@section('content')

    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-heading">Forgot your password?</h2>
            <p class="auth-subtitle">
                Enter your registered email address below, and we'll send you instructions to reset your password.
            </p>

            @if ($errors->any())
                <div class="auth-error visible" role="alert" aria-live="polite">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="form" id="loginForm" method="POST" action="{{ route('requestPasswordResetLink') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>

                    <input class="input" id="email" name="email" type="email" value="{{ old('email') }}"
                        placeholder="you@example.com" required>
                    <p style="color: red">{{ $errors->first('email') }}</p>
                </div>


                <button class="btn btn-primary" id="submitButton" type="submit">
                    <span class="spinner" aria-hidden="true"></span>
                    <span class="button-label">Get Password Reset Link</span>
                </button>


                <p class="auth-footer">
                    <span class="">
                        Remember your password?
                        <a href="{{ route('loginPage') }}">Create an account</a>
                    </span>
                </p>

            </form>
        </div>
    </section>



@endsection
