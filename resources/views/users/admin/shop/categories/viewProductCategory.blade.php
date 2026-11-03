@extends('layouts.userLayout')

@section('title', 'View Category :: ' . $data['category']->name)

@section('topbar_left')
    <div>
        <h1 class="page-title">View Category</h1>
        <p class="page-subtitle">{{ $data['category']->name }}</p>
    </div>
@endsection

@section('topbar_actions')
    <a href="{{ route('productCategories') }}" class="btn-outline-light-custom">
        <i class="fa-solid fa-arrow-left"></i> Back to Categories
    </a>
@endsection

@section('content')
    <div class="content">
        <div class="detail-card">
            <div class="detail-header">
                <div>
                    <h2 class="detail-title">
                        {{ $data['category']->name }}
                    </h2>

                    <p class="detail-subtitle">
                        Category details.
                    </p>
                </div>

                <div class="detail-actions">
                    @if (Auth::user()->hasPermission('product_category.update'))
                        <button type="button" class="btn-primary-custom" data-bs-toggle="modal"
                            data-bs-target="#editProductCategoryModal">
                            <i class="fa-solid fa-pen"></i> Update
                        </button>
                    @endif

                    @if (Auth::user()->hasPermission('product_category.delete'))
                        <button type="button" class="btn-danger-custom delete-record"
                        data-url="{{ route('deleteProductCategory', ['slug' => $data['category']->slug]) }}">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    @endif
                </div>
            </div>
            @include('users.admin.shop.categories.include.editProductCategoryModal')

            <div class="detail-grid">
                <div class="detail-field">
                    <span class="detail-label">Category</span>
                    <span class="detail-value">
                        {{ $data['category']->name }}</span>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Description</span>
                    <span class="detail-value">
                        {{ $data['category']->description }}
                    </span>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Created At</span>
                    <span class="detail-value">
                        {{ $data['category']->created_at->format('l, j F, Y \a\t g:i A') }}
                    </span>
                </div>

                <div class="detail-field">
                    <span class="detail-label">Updated At</span>
                    <span class="detail-value">
                        {{ $data['category']->updated_at->format('l, j F, Y \a\t g:i A') }}
                    </span>
                </div>
            </div>

            <div class="detail-section">
                <h3 class="detail-section-title">Product</h3>

                <div class="detail-body">
                    loop the products in this category
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
                            text: 'This product category will be permanently deleted.',
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
