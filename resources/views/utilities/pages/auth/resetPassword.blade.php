@extends('layouts.authLayout')
@section('title', 'Reset your password')
@section('content')

    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-heading">Reset your password</h2>
            <p class="auth-subtitle">
                Please enter your new password below. Make sure it's secure.
            </p>

            @if ($errors->any())
                <div class="auth-error visible" role="alert" aria-live="polite">
                    {{ $errors->first() }}
                </div>
            @endif

            <form class="form" id="loginForm registrationForm" method="POST"
                action="{{ route('submitPasswordResetRequest', ['token' => $user->remember_token]) }}">
                @csrf

                <div class="field">
                    <label for="password">Password</label>

                    <div class="input-wrap">
                        <input class="input password-input" id="password" name="password" type="password"
                            placeholder="Enter your password" autocomplete="new-password" required>

                        <button class="password-toggle" type="button" aria-label="Show password">
                            Show
                        </button>
                    </div>

                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirm Password</label>

                    <div class="input-wrap">
                        <input class="input password-input" id="password_confirmation" name="password_confirmation"
                            type="password" placeholder="Confirm your password" autocomplete="new-password" required>

                        <button class="password-toggle" type="button" aria-label="Show password">
                            Show
                        </button>
                    </div>

                    @error('password_confirmation')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div id="password-rules" class="password-rules">
                    <p class="password-rules-title">Password rules</p>

                    <ul>
                        <li id="length-rule" class="rule">
                            <i class="rule-icon fa-solid fa-circle-xmark"></i>
                            Minimum 8 characters
                        </li>

                        <li id="lowercase-rule" class="rule">
                            <i class="rule-icon fa-solid fa-circle-xmark"></i>
                            At least one lowercase letter
                        </li>

                        <li id="uppercase-rule" class="rule">
                            <i class="fa-solid fa-circle-xmark rule-icon"></i>
                            At least one uppercase letter
                        </li>

                        <li id="number-rule" class="rule">
                            <i class="fa-solid fa-circle-xmark rule-icon"></i>
                            At least one number
                        </li>

                        <li id="special-char-rule" class="rule">
                            <i class="fa-solid fa-circle-xmark rule-icon"></i>
                            At least one special character or symbol
                        </li>

                        <li id="match-rule" class="rule">
                            <i class="fa-solid fa-circle-xmark rule-icon"></i>
                            Passwords must match
                        </li>
                    </ul>
                </div>


                <p class="auth-footer">
                    <span class="">
                        Remember your password?
                        <a href="{{ route('loginPage') }}">Create an account</a>
                    </span>
                </p>

                <button class="btn btn-primary" id="submitButton" type="submit">
                    <span class="spinner" aria-hidden="true"></span>
                    <span class="button-label">Submit</span>
                </button>

            </form>
        </div>
    </section>



@endsection
