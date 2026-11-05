<div class="modal fade" id="addNewLocationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Location</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form" method="POST" action="{{ route('createLocationSubmit') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="form-field">
                            <label>Location Type <span class="required">*</span></label>

                            <select name="type" class="form-input location-type-select" required>
                                <option value="country">Country</option>
                                <option value="state">State</option>
                                <option value="lga">LGA</option>
                                <option value="city">City / Town</option>
                            </select>
                        </div>

                        <div class="form-field">
                            <label>Parent Location</label>

                            <select name="parent_id" class="form-input location-parent-select"
                                data-current-parent="{{ old('parent_id') }}">
                                <option value="">None</option>

                                @foreach ($allLocations as $parentOption)
                                    <option value="{{ $parentOption->id }}" data-parent-type="{{ $parentOption->type }}"
                                        {{ old('parent_id') == $parentOption->id ? 'selected' : '' }}>
                                        {{ $parentOption->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-field full-width">
                            <label>Name <span class="required">*</span></label>

                            <input type="text" name="name" class="form-input" value="{{ old('name') }}"
                                placeholder="e.g. Nigeria, Lagos, Ikeja" required>
                        </div>

                        <div class="form-field">
                            <label>Code</label>

                            <input type="text" name="code" class="form-input" value="{{ old('code') }}"
                                placeholder="e.g. NG, LA">
                        </div>

                        <div class="form-field">
                            <label>Status</label>

                            <select name="is_active" class="form-input">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary-custom">
                            <i class="fa-solid fa-floppy-disk"></i> Save Location
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const parentTypes = {
            state: 'country',
            lga: 'state',
            city: 'lga',
        };

        function initialiseLocationModal(modal) {
            const typeSelect = modal.querySelector('.location-type-select');
            const parentSelect = modal.querySelector('.location-parent-select');

            if (!typeSelect || !parentSelect || parentSelect.dataset.initialised === 'true') {
                return;
            }

            /* Save this modal's own original options */
            const originalOptions = Array.from(parentSelect.options).map(function(option) {
                return {
                    value: option.value,
                    label: option.textContent.trim(),
                    parentType: option.dataset.parentType,
                };
            });

            function loadParents() {
                const selectedType = typeSelect.value;
                const requiredParentType = parentTypes[selectedType];
                const currentParent = parentSelect.dataset.currentParent;

                parentSelect.innerHTML = '';

                const noneOption = document.createElement('option');
                noneOption.value = '';
                noneOption.textContent = 'None';
                parentSelect.appendChild(noneOption);

                if (!requiredParentType) {
                    return;
                }

                originalOptions
                    .filter(function(option) {
                        return option.parentType === requiredParentType;
                    })
                    .forEach(function(option) {
                        const newOption = document.createElement('option');
                        newOption.value = option.value;
                        newOption.textContent = option.label;
                        newOption.dataset.parentType = option.parentType;

                        if (currentParent == option.value) {
                            newOption.selected = true;
                        }

                        parentSelect.appendChild(newOption);
                    });
            }

            typeSelect.addEventListener('change', loadParents);

            parentSelect.dataset.initialised = 'true';

            loadParents();
        }

        /* Initialise the create modal and all edit modals */
        document.querySelectorAll('.modal').forEach(function(modal) {
            if (modal.querySelector('.location-type-select')) {
                initialiseLocationModal(modal);
            }
        });

        /* Initialise again when a modal is opened */
        document.addEventListener('shown.bs.modal', function(event) {
            initialiseLocationModal(event.target);
        });
    });
</script>