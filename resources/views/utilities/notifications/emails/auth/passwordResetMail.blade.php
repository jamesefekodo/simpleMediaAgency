@extends('layouts.emailLayout')
@section('content')
    <p>
        Hi {{ $user->first_name ?? '' }},
    </p>

    <p>
        You have requested us to send a link to reset the password of your account. Please click the link below to continue.
    </p>
    <p class="mailLink">
        <a href="{{ route('passwordResetLink', ['token' => $user->remember_token]) }}" class="link-button">Reset
            Password</a>
    </p>

    <p>
        If you did not initiate this request, please email or call our support service line immediately so we can
        investigate a possible attempt to breach your account.
    </p>
@endsection
