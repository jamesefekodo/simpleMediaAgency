<div class="modal fade" id="editSurchargeModal-{{ $surcharge->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Shipping Surcharge :: {{ $surcharge->name }}
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form" method="POST" 
                action="{{ route('updateShippingSurcharge', ['slug' => $surcharge->slug]) }}"
                >
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-field full-width">
                            <label>Name <span class="required">*</span></label>

                            <input type="text" name="name" class="form-input"
                                value="{{ old('name', $surcharge->name) }}" required>

                            <p style="color: red">
                                {{ $errors->first('name') }}
                            </p>
                        </div>

                        <div class="form-field">
                            <label>Type <span class="required">*</span></label>

                            <select name="type" class="form-input" required>
                                <option value="fixed"
                                    {{ old('type', $surcharge->type) === 'fixed' ? 'selected' : '' }}>
                                    Fixed Amount
                                </option>

                                <option value="percentage"
                                    {{ old('type', $surcharge->type) === 'percentage' ? 'selected' : '' }}>
                                    Percentage
                                </option>
                            </select>

                            <p style="color: red">
                                {{ $errors->first('type') }}
                            </p>
                        </div>

                        <div class="form-field">
                            <label>Value <span class="required">*</span></label>

                            <input type="number" name="value" step="0.01" min="0" class="form-input"
                                value="{{ old('value', $surcharge->value) }}" placeholder="e.g. 500 or 5" required>

                            <p style="color: red">
                                {{ $errors->first('value') }}
                            </p>
                        </div>

                        <div class="form-field">
                            <label>Status</label>

                            <select name="is_active" class="form-input">
                                <option value="1" {{ old('is_active', $surcharge->is_active) ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0"
                                    {{ !old('is_active', $surcharge->is_active) ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

                            <p style="color: red">
                                {{ $errors->first('is_active') }}
                            </p>
                        </div>

                        <div class="form-field full-width">
                            <label>Description</label>

                            <textarea name="description" class="form-input" rows="3" placeholder="Describe this surcharge">{{ old('description', $surcharge->description) }}</textarea>

                            <p style="color: red">
                                {{ $errors->first('description') }}
                            </p>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary-custom">
                            <i class="fa-solid fa-pen"></i> Update Surcharge
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
