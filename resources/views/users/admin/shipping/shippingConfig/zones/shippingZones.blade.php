@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('topbar_left')
    <div>
        <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
        <p class="page-subtitle">Group delivery locations into shipping zones.</p>
    </div>
@endsection

@section('topbar_actions')
    <form method="GET" class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>

        <input type="search" name="searchKey" class="search-input" value="{{ $data['searchKey'] }}"
            placeholder="Search shipping zones..." aria-label="Search shipping zones">
    </form>

    <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addNewShippingZoneModal">
        <i class="fa-solid fa-plus"></i> Add Zone
    </button>

@endsection

@section('content')
    <div class="content">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Shipping Zones</h3>
                    <span>
                        {{ $data['zones']->total() }}
                        {{ $data['zones']->total() === 1 ? 'zone' : 'zones' }} found
                    </span>
                </div>
            </div>

            @if ($data['zones']->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>

                    <h3>No shipping zones found</h3>
                    <p>Create a shipping zone and assign delivery locations to it.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Zone</th>
                                <th>Locations</th>
                                <th>Free Shipping From</th>
                                <th>Rates</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['zones'] as $zone)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <strong>{{ $zone->name }}</strong>

                                        @if ($zone->description)
                                            <div class="text-muted small">
                                                {{ Str::limit($zone->description, 60) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>{{ $zone->locations_count }}</td>

                                    <td>
                                        {{ $zone->free_shipping_threshold ? '₦' . number_format($zone->free_shipping_threshold, 2) : '—' }}
                                    </td>

                                    <td>{{ $zone->shipping_rates_count }}</td>

                                    <td>
                                        @if ($zone->is_active)
                                            <span class="status-pill completed">Active</span>
                                        @else
                                            <span class="status-pill failed">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="table-actions">
                                            <button type="button" class="btn-primary-custom" data-bs-toggle="modal"
                                                data-bs-target="#editShippingZoneModal-{{ $zone->id }}"
                                                class="icon-button">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            <button type="button" class="icon-button danger delete-zone"
                                                data-url="{{ route('deleteShippingZone', ['slug' => $zone->slug]) }}"
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
                    {{ $data['zones']->links() }}
                </div>
            @endif
        </div>



        @include('users.admin.shipping.shippingConfig.zones.include.createShippingZoneModal')

        @if ($data['zones']->isNotEmpty())
            @foreach ($data['zones'] as $zone)
                @include('users.admin.shipping.shippingConfig.zones.include.editShippingZoneModal')
            @endforeach
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-zone').forEach(function(button) {
                button.addEventListener('click', function() {
                    const url = this.dataset.url;

                    Swal.fire({
                        title: 'Delete shipping zone?',
                        text: 'This zone and its location assignments will be removed.',
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
