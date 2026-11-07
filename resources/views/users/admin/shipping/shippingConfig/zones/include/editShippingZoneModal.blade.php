<div class="modal fade" id="editShippingZoneModal-{{ $zone->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Shipping Zone :: {{ $zone->name }}
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form" method="POST"
                    action="{{ route('updateShippingZone', ['slug' => $zone->slug]) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-field full-width">
                            <label>Zone Name <span class="required">*</span></label>

                            <input type="text" name="name" class="form-input"
                                value="{{ old('name', $zone->name) }}" required>
                            <p style="color: red">{{ $errors->first('name') }}</p>
                        </div>

                        {{-- <div class="form-field">
                            <label>Slug</label>

                            <input type="text" name="slug" class="form-input"
                                value="{{ old('slug', $zone->slug) }}" placeholder="e.g. lagos-mainland">
                            <p style="color: red">{{ $errors->first('slug') }}</p>
                        </div> --}}

                        <div class="form-field">
                            <label>Free Shipping Threshold <span class="">₦</span></label>

                            <input type="number" name="free_shipping_threshold" step="0.01" min="0"
                                class="form-input"
                                value="{{ old('free_shipping_threshold', $zone->free_shipping_threshold) }}"
                                placeholder="e.g. 50000">
                            <p style="color: red">{{ $errors->first('free_shipping_threshold') }}</p>

                            <span class="form-text mt-0 pt-o text-danger">
                                Leave empty or set to <strong>₦0</strong> for no threshold (all shipping will be paid).
                            </span>
                        </div>

                        <div class="form-field">
                            <label>Status</label>

                            <select name="is_active" class="form-input">
                                <option value="1" {{ old('is_active', $zone->is_active) ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ !old('is_active', $zone->is_active) ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            <p style="color: red">{{ $errors->first('is_active') }}</p>
                        </div>

                        <div class="form-field full-width">
                            <label>Description</label>

                            <textarea name="description" class="form-input" rows="3" placeholder="Describe this shipping zone">{{ old('description', $zone->description) }}</textarea>
                        </div>

                        @php
                            $assignableLocations = $data['locations']->filter(function ($location) {
                                return in_array($location->type, ['city', 'lga']);
                            });

                            $assignedLocationIds = old('location_ids', $zone->locations->pluck('id')->toArray());
                        @endphp

                        <div class="form-field full-width">
                            <label>Assigned Locations</label>

                            <select name="location_ids[]" class="form-input" multiple size="8">
                                @foreach ($assignableLocations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ in_array($location->id, $assignedLocationIds) ? 'selected' : '' }}>
                                        {{ $location->name }}
                                        ({{ ucfirst($location->type) }})
                                    </option>
                                @endforeach
                            </select>

                            <small class="form-text text-muted">
                                Hold Ctrl or Command to select multiple locations.
                            </small>

                            <p style="color: red">{{ $errors->first('location_ids[]') }}</p>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary-custom">
                            <i class="fa-solid fa-pen"></i> Update Zone
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
