@extends('layouts.userLayout')

@section('title', 'Create Product')

@section('topbar_left')
    <div>
        <h1 class="page-title">Create Product</h1>
    </div>
@endsection

@section('topbar_actions')
    <a href="{{ route('products') }}" class="btn-outline-light-custom">
        <i class="fa-solid fa-arrow-left"></i> Back to Products
    </a>
@endsection

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('addNewProductSubmit') }}" enctype="multipart/form-data" class="admin-form">
            @csrf

            <div class="panel form-panel">
                <div class="panel-header">
                    <div>
                        <h3>Product Details</h3>
                        <span>Add a new product to the shop.</span>
                    </div>
                </div>

                <div class="row col-md-12">
                    <div class="form-field col-md-6">
                        <label for="name">Product Name <span class="required">*</span></label>

                        <input id="name" name="name" type="text" class="form-input" value="{{ old('name') }}"
                            placeholder="Enter product name" required>

                        <p style="color: red">{{ $errors->first('name') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="brand_slug">Brand</label>

                        <select id="brand_slug" name="brand_slug" class="form-input">
                            <option value="">Select brand</option>

                            @foreach ($data['brands'] as $brand)
                                <option value="{{ $brand->slug }}"
                                    {{ old('brand_slug') === $brand->slug ? 'selected' : '' }}>
                                    {{ $brand->brand }}
                                </option>
                            @endforeach
                        </select>

                        <p style="color: red">{{ $errors->first('brand_slug') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="type">Product Type</label>

                        <select id="type" name="type" class="form-input">
                            <option value="simple">Simple product</option>
                            <option value="variable">Variable product</option>
                        </select>

                        <p style="color: red">{{ $errors->first('type') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="price">Price (₦)</label>

                        <input id="price" name="price" type="number" step="0.01" min="0" class="form-input"
                            value="{{ old('price') }}" placeholder="Actual selling price">

                        <p style="color: red">{{ $errors->first('price') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="compare_at_price">Compare At Price (₦)</label>

                        <input id="compare_at_price" name="compare_at_price" type="number" step="0.01" min="0"
                            class="form-input" value="{{ old('compare_at_price') }}"
                            placeholder="Original or crossed-out price used to show a discount">

                        <p style="color: red">{{ $errors->first('compare_at_price') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="cost_price">Cost Price (₦)</label>

                        <input id="cost_price" name="cost_price" type="number" step="0.01" min="0"
                            class="form-input" value="{{ old('cost_price') }}" placeholder="Production / purchase price">

                        <p style="color: red">{{ $errors->first('cost_price') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="weight_id">Shipping Weight</label>

                        <select id="weight_id" name="weight_id" class="form-input">
                            <option value="">Select weight</option>

                            @foreach ($data['weights'] as $weight)
                                <option value="{{ $weight->id }}"
                                    {{ old('weight_id') == $weight->id ? 'selected' : '' }}>
                                    {{ $weight->name }}
                                </option>
                            @endforeach
                        </select>

                        <p style="color: red">{{ $errors->first('weight_id') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="stock_quantity">Stock Quantity</label>

                        <input id="stock_quantity" name="stock_quantity" type="number" min="0" class="form-input"
                            value="{{ old('stock_quantity', 0) }}">

                        <p style="color: red">{{ $errors->first('stock_quantity') }}</p>
                    </div>

                    <div class="form-field col-md-12">
                        <label for="short_description">Short Description</label>

                        <textarea id="short_description" name="short_description" class="form-input" rows="3"
                            placeholder="Enter a short product description">{{ old('short_description') }}</textarea>

                        <p style="color: red">{{ $errors->first('short_description') }}</p>
                    </div>

                    <div class="form-field col-md-12">
                        <label for="description">Full Description</label>

                        <textarea id="description" name="description" class="form-input rich-text" rows="6"
                            placeholder="Enter full product details">{{ old('description') }}</textarea>

                        <p style="color: red">{{ $errors->first('description') }}</p>
                    </div>

                    <div class="form-field col-md-12">
                        <label for="image">Product Image</label>

                        <div class="image-upload-box">
                            <img id="productImagePreview" class="image-preview d-none" src=""
                                alt="Product image preview">

                            <div class="image-placeholder" id="productImagePlaceholder">
                                <i class="fa-regular fa-image"></i>
                                <p>Click to upload an image</p>
                                <span>PNG, JPG or WEBP — max 300kB</span>
                            </div>

                            <input type="file" id="image" name="image"
                                accept="image/png,image/jpeg,image/jpg,image/webp" class="image-input">
                        </div>

                        <p style="color: red">{{ $errors->first('image') }}</p>
                    </div>

                    <div class="form-field col-md-12">
                        <label>Categories</label>

                        <select name="category_slugs[]" multiple class="form-input" style="height:180px;">
                            @foreach ($data['categories'] as $category)
                                <option value="{{ $category->slug }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <p style="color: red">{{ $errors->first('category_slugs.*') }}</p>
                    </div>

                    <div class="form-field col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked
                                id="isActive">

                            <label class="form-check-label" for="isActive">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="form-field col-md-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                                id="isFeatured">

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
                        <i class="fa-solid fa-floppy-disk"></i> Save Product
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // $('#short_description').summernote({
            //     height: 150,
            //     toolbar: [
            //         ['style', ['bold', 'italic', 'underline', 'clear']],
            //         ['font', ['strikethrough', 'superscript', 'subscript']],
            //         ['fontsize', ['fontsize']],
            //         ['color', ['color']],
            //         ['para', ['ul', 'ol', 'paragraph']],
            //         ['height', ['height']],
            //         ['insert', []],
            //         ['view', []]
            //     ]
            // });

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

            const imageInput = document.getElementById('image');
            const preview = document.getElementById('productImagePreview');
            const placeholder = document.getElementById('productImagePlaceholder');

            if (!imageInput) return;

            imageInput.addEventListener('change', function() {
                const file = this.files[0];

                if (!file) return;

                const reader = new FileReader();

                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                };

                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
