<div class="modal fade" id="addProductImageModal" tabindex="-1"
    aria-labelledby="addProductImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductImageModalLabel">
                    Add Product Image
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form method="POST"
                {{-- action="{{ route('addProductImage', $data['product']->slug) }}" --}}
                enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-field">
                        <label for="product_image">Select Image</label>

                        <div class="image-upload-box">
                            <img id="preview-new-image"
                                class="image-preview d-none"
                                src=""
                                alt="New product image preview">

                            <div class="image-placeholder" id="placeholder-new-image">
                                <i class="fa-regular fa-image"></i>
                                <p>Click to upload an image</p>
                                <span>PNG, JPG or WEBP — max 300kB</span>
                            </div>

                            <input type="file" id="product_image" name="image"
                                accept="image/png,image/jpeg,image/jpg,image/webp"
                                class="image-input">
                        </div>

                        <p style="color: red">{{ $errors->first('image') }}</p>
                    </div>

                    <div class="form-field">
                        <label for="alt_text">Alt Text</label>

                        <input type="text" id="alt_text" name="alt_text"
                            class="form-input"
                            value="{{ old('alt_text') }}"
                            placeholder="Describe the image">

                        <p style="color: red">{{ $errors->first('alt_text') }}</p>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                            name="is_primary" value="1" id="isPrimary">

                        <label class="form-check-label" for="isPrimary">
                            Set as primary image
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn-primary-custom">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Upload Image
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newImageInput = document.getElementById('product_image');
        const newImagePreview = document.getElementById('preview-new-image');
        const newImagePlaceholder = document.getElementById('placeholder-new-image');

        if (!newImageInput || !newImagePreview || !newImagePlaceholder) {
            return;
        }

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

        // Reset preview whenever the modal is closed
        const addImageModal = document.getElementById('addProductImageModal');

        addImageModal.addEventListener('hidden.bs.modal', function() {
            newImageInput.value = '';
            newImagePreview.src = '';
            newImagePreview.classList.add('d-none');
            newImagePlaceholder.classList.remove('d-none');
        });
    });
</script>
