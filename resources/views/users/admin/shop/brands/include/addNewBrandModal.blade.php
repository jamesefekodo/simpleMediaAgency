<div class="modal fade" id="addNewBrandModal" tabindex="-1" aria-labelledby="addNewBrandModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewBrandModalLabel">
                    Add New Brand
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form" method="POST"
                action="{{ route('addNewBrandSubmit') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-field full-width">
                        <label for="image">
                            Brand Image
                        </label>

                        <div class="image-upload-box" id="categoryImageUploadBox">
                            <img id="categoryImagePreview" class="image-preview d-none" src=""
                                alt="Brand image preview">

                            <div class="image-placeholder" id="categoryImagePlaceholder">
                                <i class="fa-regular fa-image"></i>
                                <p>Click to upload an image</p>
                                <span>PNG, JPG or WEBP — max 300kB</span>
                            </div>

                            <input type="file" id="image" name="logo"
                                accept="image/png,image/jpeg,image/jpg,image/webp" class="image-input">
                        </div>

                        <p class="text-danger">{{ $errors->first('logo') }}</p>
                    </div>
                    <div class="row gap-1">
                        <div class="form-field col-md-12">
                            <label for="brand">
                                Brand Name <span class="required">*</span>
                            </label>

                            <input id="brand" type="text" name="brand" class="form-input"
                                value="{{ old('brand') }}" placeholder="Brand Name" required>
                            <p class="text-danger">{{ $errors->first('brand') }}</p>
                        </div>

                        <div class="form-field col-md-12">
                            <label for="name">
                                Description
                            </label>

                            <input id="description" type="text" name="description" class="form-input"
                                value="{{ old('description') }}" placeholder="Description">
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
            const preview = document.getElementById('categoryImagePreview');
            const placeholder = document.getElementById('categoryImagePlaceholder');

            if (!imageInput) {
                return;
            }

            imageInput.addEventListener('change', function() {
                const file = this.files[0];

                if (!file) {
                    preview.classList.add('d-none');
                    placeholder.classList.remove('d-none');
                    preview.src = '';
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
