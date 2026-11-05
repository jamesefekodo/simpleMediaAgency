<div class="modal fade" id="editLocationModal-{{ $location->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Location :: {{ $location->name }}
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form location-form" method="POST" action="{{ route('updateLocation', $location) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-field">
                            <label>Location Type <span class="required">*</span></label>

                            <select name="type" class="form-input location-type-select" required>
                                @foreach (['country', 'state', 'lga', 'city'] as $type)
                                    <option value="{{ $type }}"
                                        {{ $location->type === $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-field">
                            <label>Parent Location</label>

                            <select name="parent_id" class="form-input location-parent-select"
                                data-current-parent="{{ $location->parent_id }}">
                                <option value="">None</option>

                                @foreach ($data['allLocations'] as $parentOption)
                                    <option value="{{ $parentOption->id }}" data-parent-type="{{ $parentOption->type }}"
                                        {{ $location->parent_id == $parentOption->id ? 'selected' : '' }}>
                                        {{ $parentOption->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-field full-width">
                            <label>Name <span class="required">*</span></label>

                            <input type="text" name="name" class="form-input"
                                value="{{ old('name', $location->name) }}" placeholder="e.g. Nigeria, Lagos, Ikeja"
                                required>
                        </div>

                        <div class="form-field">
                            <label>Code</label>

                            <input type="text" name="code" class="form-input"
                                value="{{ old('code', $location->code) }}" placeholder="e.g. NG, LA">
                        </div>

                        <div class="form-field">
                            <label>Status</label>

                            <select name="is_active" class="form-input">
                                <option value="1" {{ $location->is_active ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ !$location->is_active ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-danger-outline" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn-primary-custom">
                            <i class="fa-solid fa-pen"></i> Update Location
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
