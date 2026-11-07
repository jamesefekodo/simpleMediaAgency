@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('topbar_left')
    <div>
        <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
        <p class="page-subtitle">Manage additional shipping charges applied to delivery rates.</p>
    </div>
@endsection

@section('topbar_actions')
    <form method="GET" class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>

        <input type="search" name="searchKey" class="search-input" value="{{ $data['searchKey'] }}"
            placeholder="Search surcharges..." aria-label="Search surcharges">
    </form>

    <select name="type" class="form-input" onchange="this.form.submit()">
        <option value="">All Types</option>

        <option value="fixed" {{ $data['selectedType'] === 'fixed' ? 'selected' : '' }}>
            Fixed
        </option>

        <option value="percentage" {{ $data['selectedType'] === 'percentage' ? 'selected' : '' }}>
            Percentage
        </option>
    </select>

    <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addNewSurchargeModal">
        <i class="fa-solid fa-plus"></i> New
    </button>
@endsection

@section('content')
    <div class="content">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Shipping Surcharges</h3>
                    <span>
                        {{ $data['surcharges']->total() }}
                        {{ $data['surcharges']->total() === 1 ? 'surcharge' : 'surcharges' }} found
                    </span>
                </div>
            </div>

            @if ($data['surcharges']->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon" data-bs-toggle="modal" data-bs-target="#addNewSurchargeModal">
                        <i class="fa-solid fa-plus-circle"></i>
                    </div>

                    <h3>No shipping surcharges found</h3>
                    <p>Create surcharges such as fuel levy, handling fee, or insurance.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['surcharges'] as $surcharge)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <strong>{{ $surcharge->name }}</strong>

                                        @if ($surcharge->description)
                                            <div class="text-muted small">
                                                {{ Str::limit($surcharge->description, 60) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>{{ ucfirst($surcharge->type) }}</td>

                                    <td>
                                        @if ($surcharge->type === 'percentage')
                                            {{ number_format($surcharge->value, 2) }}%
                                        @else
                                            ₦{{ number_format($surcharge->value, 2) }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($surcharge->is_active)
                                            <span class="status-pill completed">Active</span>
                                        @else
                                            <span class="status-pill failed">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="table-actions">
                                            <button type="button" class="icon-button" data-bs-toggle="modal"
                                                data-bs-target="#editSurchargeModal-{{ $surcharge->id }}">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            <button type="button" class="icon-button danger delete-surcharge"
                                                data-url="{{ route('deleteShippingSurcharge', ['slug' => $surcharge->slug]) }}"
                                                >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                    {{ $data['surcharges']->links() }}
                </div>
            @endif
        </div>
    </div>

    @include('users.admin.shipping.shippingConfig.surcharges.include.createSurchargeModal')

    @foreach ($data['surcharges'] as $surcharge)
        @include('users.admin.shipping.shippingConfig.surcharges.include.editSurchargeModal', [
            'surcharge' => $surcharge,
        ])
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-surcharge').forEach(function(button) {
                button.addEventListener('click', function() {
                    const url = this.dataset.url;

                    Swal.fire({
                        title: 'Delete shipping surcharge?',
                        text: 'This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it',
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
@endsection
