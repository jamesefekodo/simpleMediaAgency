@extends('layouts.userLayout')

@section('title', 'Update Product :: ' . $data['product']->name)

@section('topbar_left')
    <div>
        <h1 class="page-title">Update Product</h1>
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
        <form method="POST" action="{{ route('updateProductSubmit', $data['product']->slug) }}" enctype="multipart/form-data"
            class="admin-form">
            @csrf
            @method('PUT')

            <div class="panel form-panel">
                <div class="panel-header">
                    <div>
                        <h3>Product Details</h3>
                        <span>Update the product information.</span>
                    </div>
                </div>

                <div class="row col-md-12">
                    <div class="form-field col-md-6">
                        <label for="name">Product Name <span class="required">*</span></label>

                        <input id="name" name="name" type="text" class="form-input"
                            value="{{ old('name', $data['product']->name) }}" placeholder="Enter product name" required>

                        <p style="color: red">{{ $errors->first('name') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="brand_slug">Brand</label>

                        <select id="brand_slug" name="brand_slug" class="form-input">
                            <option value="">Select brand</option>

                            @foreach ($data['brands'] as $brand)
                                <option value="{{ $brand->slug }}"
                                    {{ old('brand_slug', $data['product']->brand_slug) === $brand->slug ? 'selected' : '' }}>
                                    {{ $brand->brand }}
                                </option>
                            @endforeach
                        </select>

                        <p style="color: red">{{ $errors->first('brand_slug') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="type">Product Type</label>

                        <select id="type" name="type" class="form-input">
                            <option value="simple" {{ old('type', $data['product']->type) === 'simple' ? 'selected' : '' }}>
                                Simple product
                            </option>

                            <option value="variable"
                                {{ old('type', $data['product']->type) === 'variable' ? 'selected' : '' }}>
                                Variable product
                            </option>
                        </select>

                        <p style="color: red">{{ $errors->first('type') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="sku">SKU</label>

                        <input id="sku" name="sku" type="text" class="form-input"
                            value="{{ old('sku', $data['product']->sku) }}" placeholder="Enter product SKU">

                        <p style="color: red">{{ $errors->first('sku') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="barcode">Barcode</label>

                        <input id="barcode" name="barcode" type="text" class="form-input"
                            value="{{ old('barcode', $data['product']->barcode) }}" placeholder="Enter product barcode">

                        <p style="color: red">{{ $errors->first('barcode') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="price">Price (₦)</label>

                        <input id="price" name="price" type="number" step="0.01" min="0" class="form-input"
                            value="{{ old('price', $data['product']->price) }}" placeholder="Actual selling price">

                        <p style="color: red">{{ $errors->first('price') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="compare_at_price">Compare At Price (₦)</label>

                        <input id="compare_at_price" name="compare_at_price" type="number" step="0.01" min="0"
                            class="form-input" value="{{ old('compare_at_price', $data['product']->compare_at_price) }}"
                            placeholder="Original or crossed-out price">

                        <p style="color: red">{{ $errors->first('compare_at_price') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="cost_price">Cost Price (₦)</label>

                        <input id="cost_price" name="cost_price" type="number" step="0.01" min="0"
                            class="form-input" value="{{ old('cost_price', $data['product']->cost_price) }}"
                            placeholder="Production / purchase price">

                        <p style="color: red">{{ $errors->first('cost_price') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="weight_id">Shipping Weight</label>

                        <select id="weight_id" name="weight_id" class="form-input">
                            <option value="">Select weight</option>

                            @foreach ($data['weights'] as $weight)
                                <option value="{{ $weight->id }}"
                                    {{ old('weight_id', $data['product']->weight_id) == $weight->id ? 'selected' : '' }}>
                                    {{ $weight->name }}
                                </option>
                            @endforeach
                        </select>

                        <p style="color: red">{{ $errors->first('weight_id') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="stock_quantity">Stock Quantity</label>

                        <input id="stock_quantity" name="stock_quantity" type="number" min="0"
                            class="form-input" value="{{ old('stock_quantity', $data['product']->stock_quantity) }}">

                        <p style="color: red">{{ $errors->first('stock_quantity') }}</p>
                    </div>

                    <div class="form-field col-md-12">
                        <label for="short_description">Short Description</label>

                        <textarea id="short_description" name="short_description" class="form-input rich-text" rows="3"
                            placeholder="Enter a short product description">{{ old('short_description', $data['product']->short_description) }}</textarea>

                        <p style="color: red">{{ $errors->first('short_description') }}</p>
                    </div>

                    <div class="form-field col-md-12">
                        <label for="description">Full Description</label>

                        <textarea id="description" name="description" class="form-input rich-text" rows="6"
                            placeholder="Enter full product details">{{ old('description', $data['product']->description) }}</textarea>

                        <p style="color: red">{{ $errors->first('description') }}</p>
                    </div>

                    <div class="form-field col-md-12">
                        <label>Current Product Images</label>

                        <div class="current-product-images">
                            @forelse ($data['product']->images as $image)
                                <div class="current-image-card">
                                    <img src="{{ $image->url }}" alt="{{ $image->alt_text }}">

                                    <div class="current-image-actions">
                                        @if ($image->is_primary)
                                            <span class="badge bg-primary">
                                                Primary
                                            </span>
                                        @else
                                            <a href="{{ route('setPrimaryProductImage', [$data['product']->slug, $image->id]) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa-solid fa-star"></i> Set Primary
                                            </a>
                                        @endif

                                        <button type="button" class="btn btn-danger btn-sm delete-product-image"
                                            data-url="{{ route('deleteProductImage', [$data['product']->slug, $image->id]) }}"
                                            >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">No images uploaded yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="form-field col-md-12">
                        <label for="new_image">Add New Image</label>

                        <div class="image-upload-box">
                            <img id="preview-new-image" class="image-preview d-none" src=""
                                alt="New product image preview">

                            <div class="image-placeholder" id="placeholder-new-image">
                                <i class="fa-regular fa-image"></i>
                                <p>Click to upload an image</p>
                                <span>PNG, JPG or WEBP — max 300kB</span>
                            </div>

                            <input type="file" id="new_image" name="new_image"
                                accept="image/png,image/jpeg,image/jpg,image/webp" class="image-input">
                        </div>

                        <p style="color: red">{{ $errors->first('new_image') }}</p>
                    </div>

                    <div class="form-field col-md-12">
                        <label>Categories</label>

                        <select name="category_slugs[]" multiple class="form-input" style="height:180px;">
                            @foreach ($data['categories'] as $category)
                                <option value="{{ $category->slug }}"
                                    {{ in_array($category->slug, $data['selectedCategorySlugs']) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <p style="color: red">{{ $errors->first('category_slugs.*') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $data['product']->is_active) ? 'checked' : '' }} id="isActive">

                            <label class="form-check-label" for="isActive">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="form-field col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured', $data['product']->is_featured) ? 'checked' : '' }} id="isFeatured">

                            <label class="form-check-label" for="isFeatured">
                                Featured
                            </label>
                        </div>
                    </div>
                </div>

                <div class="panel-footer form-actions">
                    <a href="{{ route('products') }}" class="btn btn-outline-danger">
                        Cancel
                    </a>

                    <button type="submit" class="btn-primary-custom">
                        <i class="fa-solid fa-floppy-disk"></i> Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#short_description').summernote({
                height: 150,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', []],
                    ['view', []]
                ]
            });

            $('#description').summernote({
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', []],
                    ['view', []]
                ]
            });

            const newImageInput = document.getElementById('new_image');
            const newImagePreview = document.getElementById('preview-new-image');
            const newImagePlaceholder = document.getElementById('placeholder-new-image');

            if (newImageInput) {
                newImageInput.addEventListener('change', function() {
                    const file = this.files[0];

                    if (!file) {
                        newImagePreview.classList.add('d-none');
                        newImagePreview.src = '';
                        newImagePlaceholder.classList.remove('d-none');
                        return;
                    }

                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file.');
                        newImageInput.value = '';
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(event) {
                        newImagePreview.src = event.target.result;
                        newImagePreview.classList.remove('d-none');
                        newImagePlaceholder.classList.add('d-none');
                    };

                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
@endsection
