@extends('layouts.emailLayout')
@section('content')
    <p>
        Hi {{ $user->first_name ?? '' }},
    </p>

    <p>
        We’re glad to have you with us and look forward to having you as part of our community.
    </p>

    <p>
        If you have any questions or need assistance, please don’t hesitate to reach out.
    </p>
@endsection
