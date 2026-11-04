<div class="modal fade" id="editProductCategoryModal" tabindex="-1" aria-labelledby="editProductCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductCategoryModalLabel">
                    Edit Category
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form" method="POST"
                    action="{{ route('updateProductCategory', ['slug' => $data['category']->slug]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php
                        $categoryImage = asset('system/images/image_placeholder.jpg');

                        if (!empty($data['category']->image)) {
                            $categoryImage = asset('assets/uploads/shop/categories/image/' . $data['category']->image);
                        }

                        $hasExistingImage = !empty($data['category']->image);
                    @endphp

                    <div class="form-field full-width">
                        <label for="image">
                            Category Image
                        </label>

                        <div class="image-upload-box" id="categoryImageUploadBox">
                            <img id="categoryImagePreview" class="image-preview {{ $hasExistingImage ? '' : 'd-none' }}"
                                src="{{ $categoryImage }}" alt="Category image preview">

                            <div class="image-placeholder {{ $hasExistingImage ? 'd-none' : '' }}"
                                id="categoryImagePlaceholder">
                                <i class="fa-regular fa-image"></i>
                                <p>Click to upload an image</p>
                                <span>PNG, JPG or WEBP — max 300kB</span>
                            </div>

                            <input type="file" id="image" name="image"
                                accept="image/png,image/jpeg,image/jpg,image/webp" class="image-input">
                        </div>

                        <p class="text-danger">{{ $errors->first('image') }}</p>
                    </div>

                    <div class="row gap-1">
                        <div class="form-field col-md-12">
                            <label for="name">
                                Name <span class="required">*</span>
                            </label>

                            <input id="name" type="text" name="name" class="form-input"
                                value="{{ $data['category']->name }}" placeholder="Name" required>
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        </div>

                        <div class="form-field col-md-12">
                            <label for="name">
                                Description <span class="required">*</span>
                            </label>

                            <input id="description" type="text" name="description" class="form-input"
                                value="{{ $data['category']->description }}" placeholder="Description" required>
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
