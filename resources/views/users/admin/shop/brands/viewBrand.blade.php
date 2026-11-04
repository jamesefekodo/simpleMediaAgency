@extends('layouts.userLayout')

@section('title', 'View Brand :: ' . $data['brand']->brand)

@section('topbar_left')
    <div>
        <h1 class="page-title">View Brand</h1>
        <p class="page-subtitle">{{ $data['brand']->brand }}</p>
    </div>
@endsection

@section('topbar_actions')
    <a href="{{ route('brands') }}" class="btn-outline-light-custom">
        <i class="fa-solid fa-arrow-left"></i> Back to Brands
    </a>
@endsection

@section('content')
    <div class="content">
        <div class="detail-card">
            <div class="detail-header">
                <div>
                    <h2 class="detail-title">
                        {{ $data['brand']->brand }}
                    </h2>

                    <p class="detail-subtitle">
                        Brand details
                    </p>
                </div>

                <div class="detail-actions">
                    @if (Auth::user()->hasPermission('brands.update'))
                        <button type="button" class="btn-primary-custom" data-bs-toggle="modal"
                            data-bs-target="#editBrandModal">
                            <i class="fa-solid fa-pen"></i> Update
                        </button>
                    @endif

                    @if (Auth::user()->hasPermission('brands.delete'))
                        <button type="button" class="btn-danger-custom delete-record" {{-- data-url="{{ route('deleteBrand', ['slug' => $data['brand']->slug]) }}" --}}>
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    @endif
                </div>
            </div>
            @include('users.admin.shop.brands.include.editBrandModal')

            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">Brand</span>
                    <span class="detail-value">
                        @php
                            $brand = $data['brand'];

                            $logoPath =
                                $brand && $brand->logo
                                    ? public_path('assets/uploads/shop/brands/logo/' . $brand->logo)
                                    : null;
                        @endphp

                        @if ($brand && $logoPath && file_exists($logoPath))
                            <img src="{{ asset('assets/uploads/shop/brands/logo/' . $brand->logo) }}"
                                alt="{{ $brand->name }} logo" class="brand-logo-a">
                        @endif

                        {{ $data['brand']->brand }}
                    </span>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Description</span>
                    <span class="detail-value">
                        {{ $data['brand']->description }}
                    </span>
                </div>
            </div>

            <div class="detail-section">
                <h3 class="detail-section-title">Product</h3>

                <div class="detail-body">
                    loop the products of this brand
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
                            text: 'This brand will be permanently deleted.',
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


    {{-- Back Home --}}
    <div class="w-100 justify-content-center text-center mb-4">
        <div class="w-100 justify-content-center text-center mb-4">

            <a class="btn btn-primary" href="{{ route('brands') }}"> <i class="fas fa-chevron-left"></i>
                Back
            </a>
        </div>

    </div>

@endsection
