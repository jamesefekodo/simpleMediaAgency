@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('topbar_left')
    <div>
        <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
        {{-- <p class="page-subtitle">Manage product categories.</p> --}}
    </div>
@endsection

@section('topbar_actions')
    <form method="GET" class="search-box" action="{{ route('otherAttributesSearch') }}">
        <i class="fa-solid fa-magnifying-glass"></i>

        <input class="search-input" type="search" name="searchKey" value="{{ $data['searchKey'] }}"
            placeholder="Search weights..." aria-label="Search attribute">
    </form>

    @if (Auth::user()->hasPermission('other_attributes.manage'))
        <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addNewAttributeModal">
            <i class="fa-solid fa-plus"></i> Add Weight
        </button>
    @endif
@endsection

@section('content')
    <div class="content row">
        {{-- ################################# --}}
        <div class="col-md-1 individual-review-card">
            @include('users.admin/shop.colours.include.attributeSideMenu')
        </div>
        {{-- ################################### --}}
        <div class="panel col-md-11">
            <div class="panel-header">
                <div>
                    <h3>Other Attributes</h3>
                    <span>
                        {{ $data['otherAttributes']->total() }}
                        {{ $data['otherAttributes']->total() === 1 ? 'attribute' : 'attributes' }} found
                    </span>
                </div>

                @if ($data['requestType'] === 'search')
                    <a href="{{ route('weights') }}" class="btn-outline-light-custom">
                        <i class="fa-solid fa-arrow-left"></i> Clear search
                    </a>
                @endif
            </div>

            @if ($data['otherAttributes']->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>

                    <h3>No attributes found</h3>

                    <p>
                        @if ($data['requestType'] === 'search')
                            No attributes match “{{ $data['searchKey'] }}”.
                        @else
                            No attributes have been added yet.
                        @endif
                    </p>

                    @if (Auth::user()->hasPermission('other_attributes.manage'))
                        <button type="button" class="btn-primary-custom" data-bs-toggle="modal"
                            data-bs-target="#addNewAttributeModal">
                            <i class="fa-solid fa-plus"></i> Add Attribute
                        </button>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Attribute</th>
                                <th>Status</th>
                                <th>Properties</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['otherAttributes'] as $attribute)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $attribute->name }}</td>
                                    <td>
                                        @if ($attribute->is_active)
                                            <span class="badge bg-success-subtle text-success"><i
                                                    class="fas fa-circle-check me-2"></i>Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger"><i
                                                    class="fas fa-circle-times me-2"></i>Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attribute->attributeValues->isNotEmpty())
                                            @foreach ($attribute->attributeValues as $value)
                                                <span
                                                    class="badge bg-secondary-subtle text-black m-1 p-1">{{ $value->value }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="table-actions">
                                            @if (Auth::user()->hasPermission('other_attributes.manage'))
                                                <button type="button" class="btn btn-warning rounded btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editAttributeModal-{{ $attribute->id }}"
                                                    >
                                                    <i class="fa-solid fa-edit"></i> Edit
                                                </button>
                                            @endif

                                            @if (Auth::user()->hasPermission('other_attributes.manage'))
                                                <button type="button" class="btn btn-danger rounded btn-sm delete-record"
                                                    data-bs-toggle="modal" data-bs-target="#deleteAttributeModal"
                                                    data-url="{{ route('deleteAttribute', ['id' => $attribute->id]) }}"
                                                    >
                                                    <i class="fa-solid fa-trash"></i> Delete
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                    {{ $data['otherAttributes']->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Back Home --}}
    <div class="w-100 justify-content-center text-center mb-4">
        <div class="w-100 justify-content-center text-center mb-4">
            @switch($data['requestType'])
                @case('all')
                    {{ '' }}
                @break

                @case('search')
                    <a class="btn btn-primary" href="{{ route('otherAttributes') }}"> <i class="fas fa-chevron-left"></i>
                        Back
                    </a>
                @break

                @default
            @endswitch

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-record').forEach(function(button) {
                button.addEventListener('click', function() {
                    const url = this.dataset.url;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This attribute will be permanently deleted.',
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

    {{-- modals start --}}

    @include('users.admin.shop.otherAttributes.include.newAttributeModal')


    @if ($data['otherAttributes']->isNotEmpty())
        @foreach ($data['otherAttributes'] as $attributes)
            @include('users.admin.shop.otherAttributes.include.editAttributeModal')
        @endforeach
    @endif

@endsection
