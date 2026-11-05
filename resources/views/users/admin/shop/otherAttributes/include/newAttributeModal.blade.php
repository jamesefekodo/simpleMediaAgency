<div class="modal fade" id="addNewAttributeModal" tabindex="-1" aria-labelledby="addNewAttributeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewAttributeModalLabel">
                    Add Attribute
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form class="admin-form attribute-form" method="POST" action="{{ route('addNewAttributeSubmit') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="form-field full-width">
                            <label for="attribute_name">
                                Name <span class="required">*</span>
                            </label>

                            <input id="attribute_name" type="text" name="name"
                                class="form-input @error('name') is-invalid @enderror" value="{{ old('name') }}"
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
                                <div class="tag-list"></div>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function getValues(box) {
            return Array.from(box.querySelectorAll('input[name="values[]"]'))
                .map(function(input) {
                    return input.value;
                });
        }

        function renderTags(box) {
            const tagList = box.querySelector('.tag-list');
            const values = getValues(box);

            tagList.innerHTML = '';

            values.forEach(function(value, index) {
                const tag = document.createElement('span');
                tag.className = 'tag-item';
                tag.dataset.index = index;
                tag.title = 'Double-click to edit';

                tag.innerHTML = `
                    <span class="tag-text">${value}</span>

                    <input type="hidden" name="values[]" value="${value}">

                    <button type="button" class="tag-remove" aria-label="Remove ${value}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;

                tagList.appendChild(tag);
            });
        }

        function addValues(box, raw) {
            const values = getValues(box);

            raw
                .split(',')
                .map(function(value) {
                    return value.trim();
                })
                .filter(function(value) {
                    return value.length > 0;
                })
                .forEach(function(value) {
                    const exists = values.some(function(existing) {
                        return existing.toLowerCase() === value.toLowerCase();
                    });

                    if (!exists) {
                        values.push(value);
                    }
                });

            renderTagsFromValues(box, values);
        }

        function renderTagsFromValues(box, values) {
            const tagList = box.querySelector('.tag-list');

            tagList.innerHTML = '';

            values.forEach(function(value, index) {
                const tag = document.createElement('span');
                tag.className = 'tag-item';
                tag.dataset.index = index;
                tag.title = 'Double-click to edit';

                tag.innerHTML = `
                    <span class="tag-text">${value}</span>

                    <input type="hidden" name="values[]" value="${value}">

                    <button type="button" class="tag-remove" aria-label="Remove ${value}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;

                tagList.appendChild(tag);
            });
        }

        /* Add values with Enter, comma, or blur */
        document.addEventListener('keydown', function(event) {
            const input = event.target.closest('.tag-input');

            if (!input) {
                return;
            }

            const box = input.closest('.tag-input-box');

            if (event.key === 'Enter' || event.key === ',') {
                event.preventDefault();

                if (input.value.trim()) {
                    addValues(box, input.value);
                    input.value = '';
                }
            }

            if (
                event.key === 'Backspace' &&
                input.value === '' &&
                getValues(box).length > 0
            ) {
                const values = getValues(box);
                values.pop();

                renderTagsFromValues(box, values);
            }
        });

        document.addEventListener('blur', function(event) {
            const input = event.target.closest('.tag-input');

            if (!input || !input.value.trim()) {
                return;
            }

            const box = input.closest('.tag-input-box');

            addValues(box, input.value);
            input.value = '';
        }, true);

        /* Remove one individual value */
        document.addEventListener('click', function(event) {
            const removeButton = event.target.closest('.tag-remove');

            if (!removeButton) {
                return;
            }

            const tag = removeButton.closest('.tag-item');
            const box = tag.closest('.tag-input-box');

            tag.remove();
        });

        /* Double-click a tag to edit that individual value */
        document.addEventListener('dblclick', function(event) {
            const tag = event.target.closest('.tag-item');

            if (!tag) {
                return;
            }

            const box = tag.closest('.tag-input-box');
            const input = box.querySelector('.tag-input');
            const value = tag.querySelector('.tag-text').textContent.trim();

            tag.remove();

            input.value = value;
            input.focus();
        });

        /* Reopen the correct modal after validation errors */
        @if ($errors->any())
            const invalidField = document.querySelector('.attribute-form .is-invalid');

            if (invalidField) {
                const modalElement = invalidField.closest('.modal');

                if (modalElement) {
                    bootstrap.Modal.getOrCreateInstance(modalElement).show();
                }
            }
        @endif
    });
</script>
