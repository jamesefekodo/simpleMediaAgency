@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('topbar_left')
    <div>
        <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
        {{-- <p class="page-subtitle">Manage product categories.</p> --}}
    </div>
@endsection

@section('topbar_actions')
    <form method="GET" class="search-box" action="{{ route('coloursSearch') }}">
        <i class="fa-solid fa-magnifying-glass"></i>

        <input class="search-input" type="search" name="searchKey" value="{{ $data['searchKey'] }}"
            placeholder="Search colours..." aria-label="Search colours">
    </form>

    @if (Auth::user()->hasPermission('colour.manage'))
        <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addNewColourModal">
            <i class="fa-solid fa-plus"></i> Add Colour
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
                    <h3>Colours</h3>
                    <span>
                        {{ $data['colours']->total() }}
                        {{ $data['colours']->total() === 1 ? 'colour' : 'colours' }} found
                    </span>
                </div>

                @if ($data['requestType'] === 'search')
                    <a href="{{ route('colours') }}" class="btn-outline-light-custom">
                        <i class="fa-solid fa-arrow-left"></i> Clear search
                    </a>
                @endif
            </div>

            @if ($data['colours']->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>

                    <h3>No colours found</h3>

                    <p>
                        @if ($data['requestType'] === 'search')
                            No colours match “{{ $data['searchKey'] }}”.
                        @else
                            No colours have been added yet.
                        @endif
                    </p>

                    @if (Auth::user()->hasPermission('colour.manage'))
                        <button type="button" class="btn-primary-custom" data-bs-toggle="modal"
                            data-bs-target="#addNewColourModal">
                            <i class="fa-solid fa-plus"></i> Add Colour
                        </button>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Colour</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['colours'] as $colour)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $colour->name }}</td>
                                    <td>
                                        @php
                                            $hex = preg_match('/^#[0-9A-Fa-f]{6}$/', $colour->hex_code)
                                                ? $colour->hex_code
                                                : '#000000';
                                        @endphp

                                        <div style="display:flex; align-items:center; gap:8px;">

                                            <span
                                                style="width:60px; height:25px; background-color: {{ $hex }}; border:1px solid #ccc; display:inline-block;">
                                            </span>
                                            {{ $hex }}
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="table-actions">
                                            @if (Auth::user()->hasPermission('colour.manage'))
                                                <button type="button" class="btn btn-warning rounded btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editColourModal-{{ $colour->id }}">
                                                    <i class="fa-solid fa-edit"></i> Edit
                                                </button>
                                            @endif

                                            @if (Auth::user()->hasPermission('colour.manage'))
                                                <button type="button" class="btn btn-danger rounded btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#deleteColourModal">
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
                    {{ $data['colours']->links() }}
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
                    <a class="btn btn-primary" href="{{ route('colours') }}"> <i class="fas fa-chevron-left"></i>
                        Back
                    </a>
                @break

                @default
            @endswitch

        </div>

    </div>

    {{-- modals start --}}
    @include('users.admin.shop.colours.include.createNewColourModal')

    @if ($data['colours']->isNotEmpty())
        @foreach ($data['colours'] as $colour)
            @include('users.admin.shop.colours.include.editColourModal')
        @endforeach
    @endif

@endsection
