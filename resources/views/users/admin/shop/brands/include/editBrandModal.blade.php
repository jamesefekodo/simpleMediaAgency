<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModalLabel">
                    Edit Brand
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form" method="POST"
                    action="{{ route('updateBrandSubmit', ['slug' => $data['brand']->slug]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @php
                        $brandImage = asset('system/images/image_placeholder.jpg');

                        if (!empty($data['brand']->logo)) {
                            $brandImage = asset('assets/uploads/shop/brands/logo/' . $data['brand']->logo);
                        }

                        $hasExistingImage = !empty($data['brand']->logo);
                    @endphp

                    <div class="form-field full-width">
                        <label for="image">
                            Brand Logo
                        </label>

                        <div class="image-upload-box" id="brandImageUploadBox">
                            <img id="brandImagePreview" class="image-preview {{ $hasExistingImage ? '' : 'd-none' }}"
                                src="{{ $brandImage }}"
                                data-has-existing-image="{{ $hasExistingImage ? 'true' : 'false' }}"
                                alt="Brand logo preview">

                            <div class="image-placeholder {{ $hasExistingImage ? 'd-none' : '' }}"
                                id="brandImagePlaceholder">
                                <i class="fa-regular fa-image"></i>
                                <p>Click to upload an image</p>
                                <span>PNG, JPG or WEBP — max 300kB</span>
                            </div>

                            <input type="file" id="image" name="logo"
                                accept="image/png,image/jpeg,image/jpg,image/webp" class="image-input">
                        </div>

                        <p class="field-error">{{ $errors->first('logo') }}</p>
                    </div>

                    <div class="row gap-1">
                        <div class="form-field col-md-12">
                            <label for="brand">
                                Brand Name <span class="required">*</span>
                            </label>

                            <input id="brand" type="text" name="brand" class="form-input"
                                value="{{ $data['brand']->brand }}" placeholder="Brand Name" required>
                            <p class="text-danger">{{ $errors->first('brand') }}</p>
                        </div>

                        <div class="form-field col-md-12">
                            <label for="name">
                                Description
                            </label>

                            <input id="description" type="text" name="description" class="form-input"
                                value="{{ $data['brand']->description }}" placeholder="Description">
                            <p class="text-danger">{{ $errors->first('description') }}</p>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary-custom">
                            <i class="fa-solid fa-floppy-disk"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const preview = document.getElementById('brandImagePreview');
            const placeholder = document.getElementById('brandImagePlaceholder');

            if (!imageInput || !preview || !placeholder) {
                return;
            }

            imageInput.addEventListener('change', function() {
                const file = this.files[0];

                if (!file) {
                    const hasExistingImage = preview.dataset.hasExistingImage === 'true';

                    preview.classList.toggle('d-none', !hasExistingImage);
                    placeholder.classList.toggle('d-none', hasExistingImage);

                    if (!hasExistingImage) {
                        preview.src = '';
                    }

                    return;
                }

                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    imageInput.value = '';
                    return;
                }

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
</div>
