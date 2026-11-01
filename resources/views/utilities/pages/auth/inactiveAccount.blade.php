@extends('layouts.authLayout')
@section('title', 'Account Inactive')
@section('content')

    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-heading">Account Inactive</h2>
            <p class="auth-subtitle">
                Your account is currently inactive, so access to this system is restricted.
            </p>


            <div class="d-flex gap-2 mt-5">
                <a href="{{ url()->current() }}" class="btn btn-primary flex-fill py-2">
                    <i class="fas fa-rotate-right me-2"></i>
                    Refresh
                </a>

                <a href="{{ route('logoutRequest') }}" class="btn btn-outline-danger flex-fill py-2">
                    <i class="fas fa-right-from-bracket me-2"></i>
                    Logout
                </a>

            </div>

        </div>
    </section>



@endsection
