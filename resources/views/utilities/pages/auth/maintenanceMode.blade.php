@extends('layouts.authLayout')
@section('title', 'Maintenance Mode')
@section('content')

    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-heading">System Under Maintenance</h2>
            <p class="auth-subtitle">
                {{-- Sign in to continue with {{ basicSystemInfo()->app_name ?? config('app.name') }}. --}}
            </p>

            @if ($errors->any())
                <div class="auth-error visible" role="alert" aria-live="polite">
                    {{ $errors->first() }}
                </div>
            @endif

            <h5 class="text-muted my-3">
                {{ basicSystemInfo()->app_name ?? config('app.name') }} is currently undergoing scheduled maintenance. We
                are performing necessary updates to improve performance and stability, and will be back online shortly.
            </h5>

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
