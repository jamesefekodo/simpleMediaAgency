@extends('layouts.emailLayout')
@section('content')
    <p>
        Hi {{ $user->first_name ?? '' }},
    </p>

    <p>
        Your One-Time Password (OTP) for login-session authentication is:
    </p>
    <div class="otp">
        <div class="otp-button">
            {{ $otp }}
        </div>
    </div>
    <br>

    <p>
        Please use this OTP within the next 10 minutes to complete your login process.
    </p>

    <p>
        If you did not initiate this request, please call or email us immediately so that we can investigate a
        possible attempt to breach your account.
    </p>
@endsection
