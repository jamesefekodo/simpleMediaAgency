@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('topbar_left')
    <div>
        <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
    </div>
@endsection

@section('topbar_actions')
    <form method="GET" class="search-box" action="{{ route('products') }}">
        <i class="fa-solid fa-magnifying-glass"></i>

        <input class="search-input" type="search" name="searchKey"
            value="{{ $data['searchKey'] }}"
            placeholder="Search products..." aria-label="Search products">
    </form>

    <a href="{{ route('newProduct') }}" class="btn-primary-custom">
        <i class="fa-solid fa-plus"></i> Add Product
    </a>
@endsection

@section('content')
    <div class="content">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Products</h3>
                    <span>
                        {{ $data['products']->total() }}
                        {{ $data['products']->total() === 1 ? 'product' : 'products' }} found
                    </span>
                </div>

                @if ($data['searchKey'])
                    <a href="{{ route('products') }}" class="btn-outline-light-custom">
                        <i class="fa-solid fa-arrow-left"></i> Clear search
                    </a>
                @endif
            </div>

            @if ($data['products']->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-box-open"></i>
                    </div>

                    <h3>No products found</h3>

                    <p>
                        @if ($data['searchKey'])
                            No products match “{{ $data['searchKey'] }}”.
                        @else
                            No products have been added yet.
                        @endif
                    </p>

                    <a href="{{ route('newProduct') }}" class="btn-primary-custom">
                        <i class="fa-solid fa-plus"></i> Add Product
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Brand</th>
                                <th>Categories</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['products'] as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($product->primaryImage)
                                                <img src="{{ $product->primaryImage->url }}"
                                                    alt="{{ $product->primaryImage->alt_text }}"
                                                    style="width:45px; height:45px; object-fit:cover; border-radius:8px;">
                                            @else
                                                <div style="width:45px; height:45px; border-radius:8px; background:#f1f5f9; display:flex; align-items:center; justify-content:center;">
                                                    <i class="fa-regular fa-image text-muted"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <strong>{{ $product->name }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $product->sku ?? 'No SKU' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        {{ $product->brand?->brand ?? '—' }}
                                    </td>

                                    <td>
                                        @forelse ($product->categories as $category)
                                            <span class="badge bg-primary me-1">
                                                {{ $category->name }}
                                            </span>
                                        @empty
                                            <span class="text-muted">—</span>
                                        @endforelse
                                    </td>

                                    <td>
                                        ₦{{ number_format($product->price ?? 0, 2) }}
                                    </td>

                                    <td>
                                        {{ $product->stock_quantity }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($product->rating_average ?? 0))
                                                    <i class="fa-solid fa-star text-warning"></i>
                                                @else
                                                    <i class="fa-regular fa-star text-muted"></i>
                                                @endif
                                            @endfor

                                            <small class="ms-1">
                                                ({{ $product->reviews_count ?? 0 }})
                                            </small>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($product->is_active)
                                            <span class="status-pill completed">Active</span>
                                        @else
                                            <span class="status-pill pending">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        <div class="table-actions">
                                            <a class="btn-primary-custom"
                                                href="{{ route('viewProduct', ['slug' => $product->slug]) }}">
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
                    {{ $data['products']->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
