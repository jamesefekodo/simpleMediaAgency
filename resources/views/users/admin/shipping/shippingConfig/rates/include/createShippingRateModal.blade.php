<div class="modal fade" id="addNewRateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Shipping Rate</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form" method="POST" {{-- action="{{ route('shippingRates.store') }}" --}}>
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
                        </div>

                        <div class="form-field">
                            <label>Weight <span class="required">*</span></label>

                            <select name="weight_id" class="form-input" required>
                                <option value="">Select weight</option>

                                @foreach ($weights as $weight)
                                    <option value="{{ $weight->id }}"
                                        {{ old('weight_id') == $weight->id ? 'selected' : '' }}>
                                        {{ $weight->name ?? $weight->min_weight . 'kg - ' . $weight->max_weight . 'kg' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-field">
                            <label>Base Fee <span class="required">*</span></label>

                            <input type="number" step="0.01" min="0" name="base_fee" class="form-input"
                                value="{{ old('base_fee') }}" required>
                        </div>

                        <div class="form-field">
                            <label>Per KG Fee <span class="required">*</span></label>

                            <input type="number" step="0.01" min="0" name="per_kg_fee" class="form-input"
                                value="{{ old('per_kg_fee') }}" required>
                        </div>

                        <div class="form-field">
                            <label>Minimum Delivery Days <span class="required">*</span></label>

                            <input type="number" min="0" name="estimated_days_min" class="form-input"
                                value="{{ old('estimated_days_min') }}" required>
                        </div>

                        <div class="form-field">
                            <label>Maximum Delivery Days <span class="required">*</span></label>

                            <input type="number" min="0" name="estimated_days_max" class="form-input"
                                value="{{ old('estimated_days_max') }}" required>
                        </div>

                        <div class="form-field full-width">
                            <label>Surcharges</label>

                            <select name="surcharge_ids[]" class="form-input" multiple size="5">
                                @foreach ($surcharges as $surcharge)
                                    <option value="{{ $surcharge->id }}"
                                        {{ in_array($surcharge->id, old('surcharge_ids', [])) ? 'selected' : '' }}>
                                        {{ $surcharge->name }} — {{ $surcharge->type }} — {{ $surcharge->value }}
                                    </option>
                                @endforeach
                            </select>
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
                            <i class="fa-solid fa-floppy-disk"></i> Save Rate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
