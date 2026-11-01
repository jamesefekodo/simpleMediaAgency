@extends('layouts.authLayout')
@section('title', 'Manage Sessions')
@section('content')

    <section class="auth-panel">
        <div class="auth-card">
            <h2 class="auth-heading">Manage Sessions</h2>
            <p class="auth-subtitle">
                {{-- Sign in to continue with {{ basicSystemInfo()->app_name ?? config('app.name') }}. --}}
            </p>

            @if ($errors->any())
                <div class="auth-error visible" role="alert" aria-live="polite">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- <h5 class="text-muted my-3">
                {{ basicSystemInfo()->app_name ?? config('app.name') }} is currently undergoing scheduled maintenance. We
                are performing necessary updates to improve performance and stability, and will be back online shortly.
            </h5> --}}
             <ul class="mx-3 p-0 text-muted" style="text-align: start">
                <li class="mx-3 p-0"><strong>End Other Sessions</strong> – This will automatically sign you out of all
                    other devices.
                </li>
                <li class="mx-3 p-0"><strong>Logout</strong> – End this session.</li>
            </ul>


            <div class="d-flex gap-2 mt-5">
                <a href="{{ route('endOtherSessions') }}" class="btn btn-primary flex-fill py-2">
                      <i class="fas fa-ban me-2"></i>
                    End Other Sessions
                </a>

                <a href="{{ route('logoutRequest') }}" class="btn btn-outline-danger flex-fill py-2">
                    <i class="fas fa-right-from-bracket me-2"></i>
                    Logout
                </a>

            </div>

        </div>
    </section>



@endsection
