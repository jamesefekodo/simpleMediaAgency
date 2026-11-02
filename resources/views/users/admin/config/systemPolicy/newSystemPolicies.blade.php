@extends('layouts.userLayout')

@section('title', 'Create Policy')

@section('topbar_left')
    <div>
        <h1 class="page-title">Create Policy</h1>
        <p class="page-subtitle">Add a new policy for customers and administrators.</p>
    </div>
@endsection

@section('topbar_actions')
    <a href="{{ route('policies') }}" class="btn-outline-light-custom">
        <i class="fa-solid fa-arrow-left"></i> Back to Policies
    </a>
@endsection

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('addNewSystemPolicySubmit') }}" class="admin-form">
            @csrf

            <div class="panel form-panel">
                <div class="panel-header">
                    <div>
                        <h3>Policy Details</h3>
                        <span>Provide the policy title, statement and applicability.</span>
                    </div>
                </div>

                <div class="row col-md-12">
                    <div class="form-field col-md-12">
                        <label for="title">
                            Policy Title <span class="required">*</span>
                        </label>

                        <input id="title" name="title" type="text"
                            class="form-input @error('title') is-invalid @enderror" value="{{ old('title') }}"
                            placeholder="Enter policy title" required>

                        @error('title')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field col-md-12">
                        <label for="policy_statement">
                            Policy Statement <span class="required">*</span>
                        </label>

                        <textarea id="policy_statement" name="policy_statement"
                            class="form-input rich-text @error('policy_statement') is-invalid @enderror"
                            placeholder="Enter the main policy statement" rows="6" required>{{ old('policy_statement') }}</textarea>

                        @error('policy_statement')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="section-divider m-3">
                        <span>Applicable To</span>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="applicable_to_customer">
                            Applicable to Customers <span class="required">*</span>
                        </label>

                        <select id="applicable_to_customer" name="applicable_to_customer"
                            class="form-input text-center @error('applicable_to_customer') is-invalid @enderror" required>
                            <option value="" disabled {{ old('applicable_to_customer') === null ? 'selected' : '' }}>
                                Select option
                            </option>

                            <option value="0" {{ old('applicable_to_customer') == '0' ? 'selected' : '' }}>
                                No
                            </option>

                            <option value="1" {{ old('applicable_to_customer') == '1' ? 'selected' : '' }}>
                                Yes
                            </option>
                        </select>

                        @error('applicable_to_customer')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field col-md-6">
                        <label for="applicable_to_administrator">
                            Applicable to Administrators <span class="required">*</span>
                        </label>

                        <select id="applicable_to_administrator" name="applicable_to_administrator"
                            class="form-input text-center @error('applicable_to_administrator') is-invalid @enderror" required>
                            <option value="" disabled
                                {{ old('applicable_to_administrator') === null ? 'selected' : '' }}>
                                Select option
                            </option>

                            <option value="0" {{ old('applicable_to_administrator') == '0' ? 'selected' : '' }}>
                                No
                            </option>

                            <option value="1" {{ old('applicable_to_administrator') == '1' ? 'selected' : '' }}>
                                Yes
                            </option>
                        </select>

                        @error('applicable_to_administrator')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="panel-footer form-actions">
                    <a href="{{ route('policies') }}" class="btn-outline-light-custom">
                        Cancel
                    </a>

                    <button type="submit" class="btn-primary-custom">
                        <i class="fa-solid fa-floppy-disk"></i> Save Policy
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#policy_statement').summernote({
                height: 220,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', []],
                    ['view', []]
                ]
            });
        });
    </script>

    {{-- Back Home --}}
    <div class="w-100 justify-content-center text-center mb-4">
        <div class="w-100 justify-content-center text-center mb-4">
            <a class="btn btn-success" href="{{ route('policies') }}"> <i class="fas fa-chevron-left"></i>
                Back
            </a>

        </div>

    </div>
@endsection
