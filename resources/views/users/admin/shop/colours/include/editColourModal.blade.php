<div class="modal fade" id="editColourModal-{{ $colour->id }}" tabindex="-1" aria-labelledby="addNewColourModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewColourModalLabel">
                    Add New Colour
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form colour-form" method="POST" action="{{ route('updateColourSubmit', ['id' => $colour->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-field full-width">
                            <label for="colour_name">
                                Colour Name <span class="required">*</span>
                            </label>

                            <input id="colour_name" type="text" name="name"
                                class="form-input" value="{{ $colour->name }}"
                                placeholder="Enter colour name" required>

                            <p style="color: red">{{ $errors->first('name') }}</p>
                        </div>

                        <div class="form-field">
                            <label for="colour_hex_code">
                                Colour Code <span class="required">*</span>
                            </label>

                            <input id="colour_hex_code" type="text" name="hex_code"
                                class="form-input colour-code-input"
                                value="{{ old('hex_code', $colour->hex_code) }}" placeholder="#000000" maxlength="7" required
                                data-colour-sync="text">

                          <p style="color: red">{{ $errors->first('hex_code') }}</p>
                        </div>

                        <div class="form-field">
                            <label for="colour_picker">
                                Pick Colour
                            </label>

                            <input id="colour_picker" type="color" class="colour-picker"
                                value="{{ old('hex_code', $colour->hex_code) }}" data-colour-sync="picker">
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
