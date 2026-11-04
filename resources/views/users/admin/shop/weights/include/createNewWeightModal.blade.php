<div class="modal fade" id="addNewWeightModal" tabindex="-1" aria-labelledby="addNewWeightModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewWeightModalLabel">
                    Add Weight
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form colour-form" method="POST"
                action="{{ route('addNewWeightSubmit') }}">
                    @csrf

                    <div class="row col-md-12">
                        <div class="form-field full-width">
                            <label for="colour_name">
                                Name <span class="required">*</span>
                            </label>

                            <input id="name" type="text" name="name" class="form-input"
                                value="{{ old('name') }}" placeholder="Name of range" required>
                            <p style="color: red">{{ $errors->first('name') }}</p>
                        </div>
                            <div class="form-field col-md-6">
                                <label for="min_weight">
                                    Minimum Weight (kg) <span class="required">*</span>
                                </label>

                                <input id="min_weight" type="number" name="min_weight" class="form-input"
                                    value="{{ old('min_weight') }}" placeholder="0" min="0" required>
                                <p style="color: red">{{ $errors->first('min_weight') }}</p>
                            </div>
                            <div class="form-field col-md-6">
                                <label for="max_weight">
                                    Maximum Weight (kg) <span class="required">*</span>
                                </label>

                                <input id="max_weight" type="number" name="max_weight" class="form-input"
                                    value="{{ old('max_weight') }}" placeholder="0" min="0" required>
                                <p style="color: red">{{ $errors->first('max_weight') }}</p>
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
