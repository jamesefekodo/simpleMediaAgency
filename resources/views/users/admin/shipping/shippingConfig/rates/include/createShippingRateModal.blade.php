<div class="modal fade" id="addNewShippingRateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Shipping Rate</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form" method="POST" 
                action="{{ route('createNewshippingRate') }}"
                >
                    @csrf

                    <div class="form-grid">
                        <div class="form-field">
                            <label>Shipping Zone <span class="required">*</span></label>

                            <select name="shipping_zone_id" class="form-input" required>
                                <option value="">Select zone</option>

                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}"
                                        {{ old('shipping_zone_id') == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->name }}
                                    </option>
                                @endforeach
                            </select>

                            <p style="color: red">
                                {{ $errors->first('shipping_zone_id') }}
                            </p>
                        </div>

                        <div class="form-field">
                            <label>Package Weight <span class="required">*</span></label>

                            <select name="weight_id" class="form-input" required>
                                <option value="">Select weight</option>

                                @foreach ($weights as $weight)
                                    <option value="{{ $weight->id }}"
                                        {{ old('weight_id') == $weight->id ? 'selected' : '' }}>
                                        {{ $weight->name }}
                                        ({{ number_format($weight->min_weight, 3) }}kg -
                                        {{ number_format($weight->max_weight, 3) }}kg)
                                    </option>
                                @endforeach
                            </select>

                            <p style="color: red">
                                {{ $errors->first('weight_id') }}
                            </p>
                        </div>

                        <div class="form-field">
                            <label>Base Fee <span class="required">*</span></label>

                            <input
                                type="number"
                                name="base_fee"
                                step="0.01"
                                min="0"
                                class="form-input"
                                value="{{ old('base_fee') }}"
                                placeholder="e.g. 2000"
                                required
                            >

                            <p style="color: red">
                                {{ $errors->first('base_fee') }}
                            </p>
                        </div>

                        <div class="form-field">
                            <label>Per KG Fee <span class="required">*</span></label>

                            <input
                                type="number"
                                name="per_kg_fee"
                                step="0.01"
                                min="0"
                                class="form-input"
                                value="{{ old('per_kg_fee') }}"
                                placeholder="e.g. 300"
                                required
                            >

                            <p style="color: red">
                                {{ $errors->first('per_kg_fee') }}
                            </p>
                        </div>

                        <div class="form-field">
                            <label>Minimum Delivery Days <span class="required">*</span></label>

                            <input
                                type="number"
                                name="estimated_days_min"
                                min="0"
                                class="form-input"
                                value="{{ old('estimated_days_min') }}"
                                placeholder="e.g. 1"
                                required
                            >

                            <p style="color: red">
                                {{ $errors->first('estimated_days_min') }}
                            </p>
                        </div>

                        <div class="form-field">
                            <label>Maximum Delivery Days <span class="required">*</span></label>

                            <input
                                type="number"
                                name="estimated_days_max"
                                min="0"
                                class="form-input"
                                value="{{ old('estimated_days_max') }}"
                                placeholder="e.g. 3"
                                required
                            >

                            <p style="color: red">
                                {{ $errors->first('estimated_days_max') }}
                            </p>
                        </div>

                        {{-- <div class="form-field">
                            <label>Status</label>

                            <select name="is_active" class="form-input">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                            <p style="color: red">
                                {{ $errors->first('is_active') }}
                            </p>
                        </div> --}}
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary-custom">
                            <i class="fa-solid fa-floppy-disk"></i> Save Rate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>