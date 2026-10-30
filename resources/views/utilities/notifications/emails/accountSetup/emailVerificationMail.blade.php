@extends('layouts.emailLayout')
@section('content')
    <p>
        Hi {{ $user->first_name ?? '' }},
    </p>


    <p>
        Use the digits below to verify your email and activate your account:
    </p>
    <div class="otp">
        <div class="otp-button">
            {{ $otp }}
        </div>
    </div>
    <br>
    <p>
        The 8-digit is only valid for 10 minutes.
    </p>
@endsection
