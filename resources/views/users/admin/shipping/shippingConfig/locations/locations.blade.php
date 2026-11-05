@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('topbar_left')
    <div>
        <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
        <p class="page-subtitle">Manage shipping countries, states, LGAs and cities.</p>
    </div>
@endsection

@section('topbar_actions')
    <form method="GET" class="search-box" action="{{ route('locationsSearch') }}">
        <input type="hidden" name="type" value="{{ $data['selectedType'] }}">

        @if ($data['selectedParent'])
            <input type="hidden" name="parent" value="{{ $data['selectedParent'] }}">
        @endif

        <i class="fa-solid fa-magnifying-glass"></i>

        <input class="search-input" type="search" name="searchKey" value="{{ $data['searchKey'] }}"
            placeholder="Search locations..." aria-label="Search locations">
    </form>

    <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addNewLocationModal">
        <i class="fa-solid fa-plus"></i> Add Location
    </button>
@endsection

@section('content')
    <div class="content">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>{{ ucfirst($data['selectedType']) }} Locations</h3>
                    <span>
                        {{ $data['locations']->total() }}
                        {{ $data['locations']->total() === 1 ? 'location' : 'locations' }} found
                    </span>
                </div>

                <div class="filter-tabs">
                    @foreach (['country' => 'Countries', 'state' => 'States', 'lga' => 'LGAs', 'city' => 'Cities'] as $type => $label)
                        <a href="{{ route('locations', ['type' => $type]) }}"
                            class="filter-tab badge {{ $data['selectedType'] === $type ? 'bg-primary text-white' : 'bg-secondary-subtle text-black' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if ($data['selectedType'] !== 'country')
                <form method="GET" action="{{ route('locations') }}" class="location-filter">
                    <input type="hidden" name="type" value="{{ $data['selectedType'] }}">

                    <select name="parent" class="form-input" onchange="this.form.submit()">
                        <option value="">All
                            {{ $data['selectedType'] === 'state' ? 'countries' : ($data['selectedType'] === 'lga' ? 'states' : 'LGAs') }}
                        </option>

                        @foreach ($data['parentOptions'] as $parentOption)
                            <option value="{{ $parentOption->id }}"
                                {{ $data['selectedParent'] == $parentOption->id ? 'selected' : '' }}>
                                {{ $parentOption->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif

            @if ($data['locations']->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <h3>No locations found</h3>
                    <p>No locations match the selected filters.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Parent</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['locations'] as $location)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <strong>{{ $location->name }}</strong>
                                    </td>

                                    <td>{{ $location->code ?? '—' }}</td>

                                    <td>
                                        {{ $location->parent?->name ?? '—' }}
                                    </td>

                                    <td>
                                        @if ($location->is_active)
                                            <span class="status-pill completed">Active</span>
                                        @else
                                            <span class="status-pill failed">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="table-actions">
                                            <button type="button" class="icon-button" data-bs-toggle="modal"
                                                data-bs-target="#editLocationModal-{{ $location->id }}">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            <button type="button" class="icon-button danger delete-record"
                                                data-url="{{ route('deleteLocation', $location) }}">
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
                    {{ $data['locations']->links() }}
                </div>
            @endif
        </div>
    </div>

    @include('users.admin.shipping.shippingConfig.locations.include.createLocationModal', [
        'allLocations' => $data['allLocations'],
    ])

    @if ($data['locations']->isNotEmpty())
        @foreach ($data['locations'] as $location)
            @include('users.admin.shipping.shippingConfig.locations.include.editLocationModal', [
                'location' => $location,
                'parentOptions' => $data['parentOptions'],
            ])
        @endforeach
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-record').forEach(function(button) {
                button.addEventListener('click', function() {
                    const url = this.dataset.url;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This location will be permanently deleted.',
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
@endsection
