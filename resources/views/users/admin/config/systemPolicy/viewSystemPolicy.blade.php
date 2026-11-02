@extends('layouts.userLayout')

@section('title', 'View Policy :: ' . $data['policy']->title)

@section('topbar_left')
    <div>
        <h1 class="page-title">View Policy</h1>
        <p class="page-subtitle">{{ $data['policy']->title }}</p>
    </div>
@endsection

@section('topbar_actions')
    <a href="{{ route('policies') }}" class="btn-outline-light-custom">
        <i class="fa-solid fa-arrow-left"></i> Back to Policies
    </a>
@endsection

@section('content')
    <div class="content">
        <div class="detail-card">
            <div class="detail-header">
                <div>
                    <h2 class="detail-title">
                        {{ $data['policy']->title }}
                    </h2>

                    <p class="detail-subtitle">
                        Policy details and applicability information.
                    </p>
                </div>

                <div class="detail-actions">
                    @if (Auth::user()->hasPermission('policy.update'))
                        <a href="{{ route('editPolicy', ['slug' => $data['policy']->slug]) }}" class="btn-primary-custom">
                            <i class="fa-solid fa-pen"></i> Update
                        </a>
                    @endif

                    @if (Auth::user()->hasPermission('policy.delete'))
                        <button type="button" class="btn-danger-custom delete-record" {{-- data-url="{{ route('deletePolicy', ['slug' => $data['policy']->slug]) }}" --}}>
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    @endif
                </div>
            </div>

            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">Title</span>
                    <span class="detail-value">{{ $data['policy']->title }}</span>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Status</span>
                    <span class="detail-value">
                        @if ($data['policy']->is_active)
                            <span class="status-pill completed">Active</span>
                        @else
                            <span class="status-pill failed">Inactive</span>
                        @endif
                    </span>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Members</span>
                    <span class="detail-value">
                        @if ($data['policy']->applicable_to_member)
                            <span class="status-pill completed">Applicable</span>
                        @else
                            <span class="status-pill failed">Not Applicable</span>
                        @endif
                    </span>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Administrators</span>
                    <span class="detail-value">
                        @if ($data['policy']->applicable_to_administrator)
                            <span class="status-pill completed">Applicable</span>
                        @else
                            <span class="status-pill failed">Not Applicable</span>
                        @endif
                    </span>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Created At</span>
                    <span class="detail-value">
                        {{ $data['policy']->created_at->format('l, j F, Y \a\t g:i A') }}
                    </span>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Updated At</span>
                    <span class="detail-value">
                        {{ $data['policy']->updated_at->format('l, j F, Y \a\t g:i A') }}
                    </span>
                </div>
            </div>

            <div class="detail-section">
                <h3 class="detail-section-title">Policy Statement</h3>

                <div class="detail-body">
                    {!! $data['policy']->policy_statement !!}
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.delete-record').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const url = this.dataset.url;

                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'This policy will be permanently deleted.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'Cancel',
                            reverseButtons: true
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                window.location.href = url;
                            }
                        });
                    });
                });
            });
        </script>
    </div>
@endsection
