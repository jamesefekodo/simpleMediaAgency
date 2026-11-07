@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('topbar_left')
    <div>
        <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
        <p class="page-subtitle">Manage delivery fees by shipping zone and package weight.</p>
    </div>
@endsection

@section('topbar_actions')
    <form method="GET" class="search-box">
        <select name="zone" class="form-input" onchange="this.form.submit()">
            <option value="">All Zones</option>

            @foreach ($data['zones'] as $zone)
                <option value="{{ $zone->id }}"
                    {{ $data['selectedZoneId'] == $zone->id ? 'selected' : '' }}>
                    {{ $zone->name }}
                </option>
            @endforeach
        </select>

        <i class="fa-solid fa-magnifying-glass"></i>

        <input
            type="search"
            name="searchKey"
            class="search-input"
            value="{{ $data['searchKey'] }}"
            placeholder="Search rates..."
            aria-label="Search rates"
        >
    </form>

    @if ($data['canCreateRate'])
        <button type="button" class="btn-primary-custom"
            data-bs-toggle="modal"
            data-bs-target="#addNewShippingRateModal">
            <i class="fa-solid fa-plus"></i> Add Rate
        </button>
    @else
        <a href="{{ route('shippingZones') }}" class="btn-primary-custom">
            <i class="fa-solid fa-layer-group"></i> Create Zone / Weight First
        </a>
    @endif
@endsection

@section('content')
    <div class="content">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Shipping Rates</h3>
                    <span>
                        {{ $data['rates']->total() }}
                        {{ $data['rates']->total() === 1 ? 'rate' : 'rates' }} found
                    </span>
                </div>
            </div>

            @if (!$data['canCreateRate'])
                <div class="alert alert-warning">
                    <strong>Shipping rates cannot be created yet.</strong>

                    @if ($data['zones']->isEmpty())
                        Create at least one shipping zone first.
                    @endif

                    @if ($data['weights']->isEmpty())
                        Create at least one package weight first.
                    @endif
                </div>
            @endif

            @if ($data['rates']->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>

                    <h3>No shipping rates found</h3>
                    <p>Create delivery fees for a shipping zone and package weight.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Zone</th>
                                <th>Weight</th>
                                <th>Base Fee</th>
                                <th>Per KG Fee</th>
                                <th>Delivery Days</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['rates'] as $rate)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $rate->shippingZone?->name ?? '—' }}</td>

                                    <td>{{ $rate->weight?->name ?? '—' }}</td>

                                    <td>₦{{ number_format($rate->base_fee, 2) }}</td>

                                    <td>₦{{ number_format($rate->per_kg_fee, 2) }}</td>

                                    <td>
                                        {{ $rate->estimated_days_min }} -
                                        {{ $rate->estimated_days_max }} days
                                    </td>

                                    <td>
                                        @if ($rate->is_active)
                                            <span class="status-pill completed">Active</span>
                                        @else
                                            <span class="status-pill failed">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="table-actions">
                                            <button type="button" class="icon-button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editShippingRateModal-{{ $rate->id }}">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            <button type="button"
                                                class="icon-button danger delete-shipping-rate"
                                                data-url="{{ route('deleteSshippingRate', ['id' => $rate->id]) }}"
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
                    {{ $data['rates']->links() }}
                </div>
            @endif
        </div>
    </div>

    @include('users.admin.shipping.shippingConfig.rates.include.createShippingRateModal', [
        'zones' => $data['zones'],
        'weights' => $data['weights'],
    ])

    @foreach ($data['rates'] as $rate)
        @include('users.admin.shipping.shippingConfig.rates.include.editShippingRateModal', [
            'rate' => $rate,
            'zones' => $data['zones'],
            'weights' => $data['weights'],
        ])
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-shipping-rate').forEach(function(button) {
                button.addEventListener('click', function() {
                    const url = this.dataset.url;

                    Swal.fire({
                        title: 'Delete shipping rate?',
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