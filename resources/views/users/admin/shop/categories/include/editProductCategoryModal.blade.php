
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
                <form class="admin-form" method="POST" action="{{ route('updateProductCategories', ['slug' => $data['category']->slug]) }}"
                 enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
</div>
