@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('topbar_left')
    <div>
        <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
        {{-- <p class="page-subtitle">Manage product categories.</p> --}}
    </div>
@endsection

@section('topbar_actions')
    <form method="GET" class="search-box" action="{{ route('brandsSearch') }}">
        <i class="fa-solid fa-magnifying-glass"></i>

        <input class="search-input" type="search" name="searchKey" value="{{ $data['searchKey'] }}"
            placeholder="Search brands..." aria-label="Search brands">
    </form>

    @if (Auth::user()->hasPermission('brands.create'))
        <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addNewBrandModal">
            <i class="fa-solid fa-plus"></i> Add Brand
        </button>
    @endif
@endsection

@section('content')
    <div class="content">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Brands</h3>
                    <span>
                        {{ $data['brands']->total() }}
                        {{ $data['brands']->total() === 1 ? 'brand' : 'brands' }} found
                    </span>
                </div>

                @if ($data['requestType'] === 'search')
                    <a href="{{ route('brands') }}" class="btn-outline-light-custom">
                        <i class="fa-solid fa-arrow-left"></i> Clear search
                    </a>
                @endif
            </div>

            @if ($data['brands']->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>

                    <h3>No brands found</h3>

                    <p>
                        @if ($data['requestType'] === 'search')
                            No brands match “{{ $data['searchKey'] }}”.
                        @else
                            No brands have been added yet.
                        @endif
                    </p>

                    @if (Auth::user()->hasPermission('brands.create'))
                        <button type="button" class="btn-primary-custom" data-bs-toggle="modal"
                            data-bs-target="#addNewBrandModal">
                            <i class="fa-solid fa-plus"></i> Add Brand
                        </button>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Products</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['brands'] as $brand)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @php
                                            $logoPath = public_path('assets/uploads/shop/brands/logo/' . $brand->logo);
                                        @endphp

                                        @if ($brand->logo && file_exists($logoPath))
                                            <img src="{{ asset('assets/uploads/shop/brands/logo/' . $brand->logo) }}"
                                                width="100">
                                        @else
                                            <img src="{{ asset('system/images/image_placeholder.jpg') }}" width="100">
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $brand->brand }}</strong>
                                    </td>
                                    <td>
                                        {!! \Illuminate\Support\Str::words(strip_tags(html_entity_decode($brand->description)), 10, '...') !!}
                                    </td>
                                    <td>
                                        {{-- {{ $category->products->count() }} --}}
                                    </td>
                                    <td class="text-end">
                                        <div class="table-actions">
                                            <a class="btn-primary-custom"
                                                href="{{ route('viewBrands', ['slug' => $brand->slug]) }}">
                                                <i class="fa-solid fa-eye"></i> View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                    {{ $data['brands']->links() }}
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
                    <a class="btn btn-primary" href="{{ route('brands') }}"> <i class="fas fa-chevron-left"></i>
                        Back
                    </a>
                @break

                @default
            @endswitch

        </div>

    </div>

    {{-- modals start --}}
    @include('users.admin.shop.brands.include.addNewBrandModal')

@endsection
