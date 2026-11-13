@extends('layouts.userLayout')

@section('title', 'View Product :: ' . $data['product']->name)

@section('topbar_left')
    <div>
        <h1 class="page-title">Product Details</h1>
        <p class="page-subtitle">{{ $data['product']->name }}</p>
    </div>
@endsection

@section('topbar_actions')
    <a href="{{ route('products') }}" class="btn-outline-light-custom">
        <i class="fa-solid fa-arrow-left"></i> Back to Products
    </a>
@endsection

@section('content')
    <div class="content">
        <div class="product-admin-page">
            <div class="product-admin-header">
                <div>
                    <div class="product-admin-badges">
                        <span class="badge bg-primary">
                            {{ ucfirst($data['product']->type) }} product
                        </span>

                        @if ($data['product']->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif

                        @if ($data['product']->is_featured)
                            <span class="badge bg-warning text-dark">Featured</span>
                        @endif
                    </div>

                    <h2 class="product-admin-title">
                        {{ $data['product']->name }}
                    </h2>

                    <p class="product-admin-brand">
                        {{ $data['product']->brand?->brand ?? 'No brand selected' }}
                    </p>
                </div>

                <div class="product-admin-actions">
                    @if (Auth::user()->hasPermission('product.update'))
                        <a href="{{ route('editProduct', $data['product']->slug) }}" class="btn-primary-custom">
                            <i class="fa-solid fa-pen"></i> Update Product
                        </a>
                    @endif

                    @if (Auth::user()->hasPermission('product.delete'))
                        <button type="button" class="btn-danger-custom delete-product"
                            data-url="{{ route('deleteProduct', $data['product']->slug) }}">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    @endif
                </div>
            </div>

            <div class="product-admin-layout">
                {{-- Product gallery --}}
                <div class="product-gallery-panel">
                    <div class="product-main-image-wrapper">
                        <img id="productMainImage"
                            src="{{ $data['product']->primaryImage?->url ?? asset('images/default-product.png') }}"
                            alt="{{ $data['product']->primaryImage?->alt_text ?? $data['product']->name }}">

                        <div class="product-gallery-controls">
                            <button type="button" class="gallery-control zoom-out" data-scale="0.25">
                                <i class="fa-solid fa-magnifying-glass-minus"></i>
                            </button>

                            <button type="button" class="gallery-control zoom-in" data-scale="0.25">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                            </button>

                            <button type="button" class="gallery-control zoom-reset">
                                <i class="fa-solid fa-arrows-rotate"></i>
                            </button>
                        </div>
                    </div>

                    <div class="gallery-toolbar">
                        <button type="button" class="btn-primary-custom" data-bs-toggle="modal"
                            data-bs-target="#addProductImageModal">
                            <i class="fa-solid fa-plus"></i> Add Image
                        </button>
                    </div>

                    <div class="product-thumbnails">
                        @forelse ($data['product']->images as $image)
                            <div class="product-thumbnail-wrapper {{ $image->is_primary ? 'primary' : '' }}">
                                <button type="button" class="product-thumbnail {{ $image->is_primary ? 'active' : '' }}"
                                    data-image="{{ $image->url }}">
                                    <img src="{{ $image->url }}" alt="{{ $image->alt_text }}">
                                </button>

                                <div class="thumbnail-actions">
                                    @if (!$image->is_primary)
                                        <form method="POST"
                                            action="{{ route('setPrimaryProductImage', [$data['product']->slug, $image->id]) }}">
                                            @csrf
                                            <button type="submit" class="thumbnail-action primary-action"
                                                title="Set as primary image">
                                                <i class="fa-solid fa-star"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="thumbnail-action primary-badge" title="Primary image">
                                            <i class="fa-solid fa-star"></i>
                                        </span>
                                    @endif

                                    <form method="POST" {{-- action="{{ route('deleteProductImage', [$data['product']->slug, $image->id]) }}" --}}
                                        onsubmit="return confirm('Delete this image?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="thumbnail-action delete-action" title="Delete image">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="empty-gallery">
                                <i class="fa-regular fa-image"></i>
                                <span>No images uploaded</span>
                            </div>
                        @endforelse
                    </div>


                </div>

                {{-- Product details --}}
                <div class="product-details-panel">
                    <div class="product-price-box">
                        <div class="product-price">
                            ₦{{ number_format($data['product']->price ?? 0, 2) }}
                        </div>

                        @if ($data['product']->compare_at_price)
                            <div class="product-compare-price">
                                ₦{{ number_format($data['product']->compare_at_price, 2) }}
                            </div>

                            <div class="product-discount">
                                Save {{ $data['product']->discount_percentage }}%
                            </div>
                        @endif
                    </div>

                    <div class="product-rating-box">
                        <div class="product-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($data['product']->rating_average ?? 0))
                                    <i class="fa-solid fa-star"></i>
                                @else
                                    <i class="fa-regular fa-star"></i>
                                @endif
                            @endfor
                        </div>

                        <span>
                            {{ number_format($data['product']->rating_average ?? 0, 1) }}
                            ({{ $data['product']->reviews_count ?? 0 }} reviews)
                        </span>
                    </div>

                    <div class="product-stock-box">
                        @if ($data['product']->is_in_stock)
                            <span class="stock-badge in-stock">
                                <i class="fa-solid fa-circle-check"></i>
                                In stock
                            </span>
                        @else
                            <span class="stock-badge out-of-stock">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Out of stock
                            </span>
                        @endif

                        <span class="stock-count">
                            {{ $data['product']->stock_quantity }} available
                        </span>
                    </div>

                    <div class="product-info-grid">
                        <div class="product-info-item">
                            <span class="label">SKU</span>
                            <span class="value">
                                {{ $data['product']->sku ?? '—' }}
                            </span>
                        </div>

                        <div class="product-info-item">
                            <span class="label">Barcode</span>
                            <span class="value">
                                {{ $data['product']->barcode ?? '—' }}
                            </span>
                        </div>

                        <div class="product-info-item">
                            <span class="label">Cost Price</span>
                            <span class="value">
                                ₦{{ number_format($data['product']->cost_price ?? 0, 2) }}
                            </span>
                        </div>

                        <div class="product-info-item">
                            <span class="label">Shipping Weight</span>
                            <span class="value">
                                {{ $data['product']->weight?->name ?? '—' }}
                            </span>
                        </div>
                    </div>

                    <div class="product-categories">
                        <span class="label">Categories</span>

                        <div class="category-list">
                            @forelse ($data['product']->categories as $category)
                                <span class="category-pill">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <span class="text-muted">No categories selected</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="product-short-description">
                        <h4>Short Description</h4>

                        <div>
                            {!! $data['product']->short_description ?? 'No short description provided.' !!}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Full description --}}
            <div class="product-section">
                <h3>Product Description</h3>

                <div class="product-section-body">
                    {!! $data['product']->description ?? 'No description provided.' !!}
                </div>
            </div>

            {{-- Variants --}}
            <div class="product-section">
                <h3>Product Variants</h3>

                <div class="product-section-body">
                    @if ($data['product']->variants->isEmpty())
                        <p class="text-muted">No variants have been created for this product.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Variant</th>
                                        <th>SKU</th>
                                        <th>Colour</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data['product']->variants as $variant)
                                        <tr>
                                            <td>
                                                <strong>{{ $variant->name ?? 'Variant' }}</strong>
                                            </td>

                                            <td>
                                                {{ $variant->sku ?? '—' }}
                                            </td>

                                            <td>
                                                @if ($variant->colour)
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span
                                                            style="width:20px; height:20px; border-radius:50%; display:inline-block; background:{{ $variant->colour->hex_code }}; border:1px solid #ddd;"></span>
                                                        {{ $variant->colour->name }}
                                                    </div>
                                                @else
                                                    —
                                                @endif
                                            </td>

                                            <td>
                                                ₦{{ number_format($variant->price, 2) }}
                                            </td>

                                            <td>
                                                {{ $variant->available_quantity }}
                                            </td>

                                            <td>
                                                @if ($variant->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Reviews --}}
            <div class="product-section">
                <h3>Customer Reviews</h3>

                <div class="product-section-body">
                    @if ($data['product']->approvedReviews->isEmpty())
                        <p class="text-muted">No approved reviews yet.</p>
                    @else
                        @foreach ($data['product']->approvedReviews as $review)
                            <div class="review-card">
                                <div class="review-header">
                                    <div class="review-user">
                                        <strong>
                                            {{ $review->reviewer_name ?? ($review->user?->name ?? 'Customer') }}
                                        </strong>

                                        <small class="text-muted">
                                            {{ $review->created_at->format('d M Y') }}
                                        </small>
                                    </div>

                                    <div class="review-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                @if ($review->title)
                                    <h5 class="review-title">{{ $review->title }}</h5>
                                @endif

                                <p class="review-body">
                                    {{ $review->review }}
                                </p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Zoom modal --}}
    <div class="modal fade" id="productImageZoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Image</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <img id="productZoomImage" src="" alt="Product image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.getElementById('productMainImage');
            const zoomImage = document.getElementById('productZoomImage');

            let currentScale = 1;
            const minScale = 1;
            const maxScale = 3;
            const zoomStep = 0.25;

            function applyZoom() {
                mainImage.style.transform = `scale(${currentScale})`;
            }

            function resetZoom() {
                currentScale = 1;
                applyZoom();
            }

            document.querySelectorAll('.product-thumbnail').forEach(function(button) {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.product-thumbnail').forEach(function(item) {
                        item.classList.remove('active');
                    });

                    this.classList.add('active');

                    mainImage.src = this.dataset.image;

                    resetZoom();
                });
            });

            document.querySelectorAll('.zoom-in').forEach(function(button) {
                button.addEventListener('click', function() {
                    currentScale = Math.min(currentScale + zoomStep, maxScale);
                    applyZoom();
                });
            });

            document.querySelectorAll('.zoom-out').forEach(function(button) {
                button.addEventListener('click', function() {
                    currentScale = Math.max(currentScale - zoomStep, minScale);
                    applyZoom();
                });
            });

            document.querySelectorAll('.zoom-reset').forEach(function(button) {
                button.addEventListener('click', resetZoom);
            });

            mainImage.addEventListener('wheel', function(event) {
                event.preventDefault();

                if (event.deltaY < 0) {
                    currentScale = Math.min(currentScale + zoomStep, maxScale);
                } else {
                    currentScale = Math.max(currentScale - zoomStep, minScale);
                }

                applyZoom();
            }, {
                passive: false
            });

            mainImage.addEventListener('dblclick', resetZoom);

            document.querySelectorAll('.product-zoom-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    zoomImage.src = this.dataset.image;

                    const modal = new bootstrap.Modal(
                        document.getElementById('productImageZoomModal')
                    );

                    modal.show();
                });
            });

            document.querySelectorAll('.delete-product').forEach(function(button) {
                button.addEventListener('click', function() {
                    const url = this.dataset.url;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This product will be deleted.',
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


    @include('users.admin.shop/products.include.addNewProductImageModal')

    {{-- Back Home --}}
    <div class="w-100 justify-content-center text-center mb-4">
        <div class="w-100 justify-content-center text-center mb-4">
            <a class="btn btn-primary" href="{{ route('products') }}"> <i class="fas fa-chevron-left"></i>
                Back
            </a>
        </div>

    </div>


@endsection
