<div class="modal fade" id="addNewColourModal" tabindex="-1" aria-labelledby="addNewColourModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewColourModalLabel">
                    Add New Colour
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form colour-form" method="POST" action="{{ route('addNewColourSubmit') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="form-field full-width">
                            <label for="colour_name">
                                Colour Name <span class="required">*</span>
                            </label>

                            <input id="colour_name" type="text" name="name"
                                class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Enter colour name" required>

                            @error('name')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="colour_hex_code">
                                Colour Code <span class="required">*</span>
                            </label>

                            <input id="colour_hex_code" type="text" name="hex_code"
                                class="form-input colour-code-input @error('hex_code') is-invalid @enderror"
                                value="{{ old('hex_code', '#000000') }}" placeholder="#000000" maxlength="7" required
                                data-colour-sync="text">

                            @error('hex_code')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="colour_picker">
                                Pick Colour
                            </label>

                            <input id="colour_picker" type="color" class="colour-picker"
                                value="{{ old('hex_code', '#000000') }}" data-colour-sync="picker">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary-custom">
                            <i class="fa-solid fa-floppy-disk"></i> Save Colour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        function isValidHex(value) {
            return /^#[0-9A-Fa-f]{6}$/.test(value);
        }

        document.addEventListener('input', function(event) {
            const field = event.target.closest('[data-colour-sync]');

            if (!field) {
                return;
            }

            const form = field.closest('.colour-form');

            if (!form) {
                return;
            }

            const hexInput = form.querySelector('[data-colour-sync="text"]');
            const colourPicker = form.querySelector('[data-colour-sync="picker"]');

            if (!hexInput || !colourPicker) {
                return;
            }

            if (field.dataset.colourSync === 'picker') {
                const colour = colourPicker.value.toUpperCase();

                hexInput.value = colour;
                hexInput.style.borderColor = colour;
                colourPicker.style.borderColor = colour;
            } else {
                let value = hexInput.value.trim();

                if (value && !value.startsWith('#')) {
                    value = '#' + value;
                    hexInput.value = value;
                }

                if (isValidHex(value)) {
                    colourPicker.value = value.toLowerCase();
                    hexInput.style.borderColor = value;
                    colourPicker.style.borderColor = value;
                }
            }
        });

        document.addEventListener('submit', function(event) {
            const form = event.target.closest('.colour-form');

            if (!form) {
                return;
            }

            const hexInput = form.querySelector('[data-colour-sync="text"]');

            if (!hexInput) {
                return;
            }

            let value = hexInput.value.trim();

            if (value && !value.startsWith('#')) {
                value = '#' + value;
                hexInput.value = value;
            }

            if (!isValidHex(value)) {
                event.preventDefault();
                hexInput.classList.add('is-invalid');
                hexInput.focus();
            }
        });

        @if ($errors->any())
            const invalidField = document.querySelector('.colour-form .is-invalid');

            if (invalidField) {
                const modalElement = invalidField.closest('.modal');

                if (modalElement) {
                    bootstrap.Modal.getOrCreateInstance(modalElement).show();
                }
            }
        @endif
    });
</script>
