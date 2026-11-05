<div class="modal fade" id="editAttributeModal-{{ $attribute->id }}" tabindex="-1"
    aria-labelledby="editAttributeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAttributeModalLabel">
                    Edit Attribute
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form attribute-form" method="POST"
                    action="{{ route('updateAttributeSubmit', ['id' => $attribute->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-field full-width">
                            <label for="attribute_name">
                                Name <span class="required">*</span>
                            </label>

                            <input id="attribute_name" type="text" name="name"
                                class="form-input @error('name') is-invalid @enderror" value="{{ $attribute->name }}"
                                placeholder="e.g. Size, Material, Capacity" required>

                            @error('name')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field full-width">
                            <label for="value">
                                Values <span class="required">*</span>
                            </label>
                            <div class="tag-input-box">
                                <div class="tag-list">
                                    @foreach ($attribute->attributeValues as $attributeValue)
                                        <span class="tag-item" title="Double-click to edit">
                                            <span class="tag-text">{{ $attributeValue->value }}</span>

                                            <input type="hidden" name="values[]" value="{{ $attributeValue->value }}">

                                            <button type="button" class="tag-remove"
                                                aria-label="Remove {{ $attributeValue->value }}">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </span>
                                    @endforeach
                                </div>

                                <input type="text" class="tag-input" placeholder="Type values separated by commas"
                                    autocomplete="off">
                            </div>
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary-custom">
                            <i class="fa-solid fa-floppy-disk"></i> Save Attribute
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
