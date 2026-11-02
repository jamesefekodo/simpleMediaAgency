@extends('layouts.userLayout')

@section('title', 'Update ' . $data['policy']->title)

@section('topbar_left')
    <div>
        <h1 class="page-title">Update {{ $data['policy']->title }}</h1>
        {{-- <p class="page-subtitle">Add a new policy for customers and administrators.</p> --}}
    </div>
@endsection

@section('topbar_actions')
    <a href="{{ route('viewPolicy', ['slug' => $data['policy']->slug]) }}" class="btn-outline-light-custom">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
@endsection

@section('content')
    <div class="content">
        <form method="POST"
        action="{{ route('updateSystemPolicy', ['slug' => $data['policy']->slug]) }}"
         class="admin-form">
            @csrf
            @method('PUT')

            <div class="panel form-panel">
                <div class="panel-header">
                    <div>
                        <h3>Policy Details</h3>
                        <span>Provide the policy title, statement and applicability.</span>
                    </div>
                </div>

                <div class="row col-md-12">
                    <div class="form-field col-md-8">
                        <label for="title">
                            Policy Title <span class="required">*</span>
                        </label>

                        <input id="title" name="title" type="text" class="form-input"
                            value="{{ $data['policy']->title }}" placeholder="Enter policy title" required>
                        <p class="text-danger">{{ $errors->first('title') }}</p>
                    </div>

                    <div class="form-field col-md-4">
                        <label for="is_active">
                            Applicable to Administrators <span class="required">*</span>
                        </label>

                        <select id="is_active" name="is_active" class="form-input text-center" required>
                            <option value="" disabled {{ old('is_active') === null ? 'selected' : '' }}>
                                Select option
                            </option>

                            <option value="0" {{ $data['policy']->is_active == '0' ? 'selected' : '' }}>
                                Inactive
                            </option>

                            <option value="1" {{ $data['policy']->is_active == '1' ? 'selected' : '' }}>
                                Active
                            </option>
                        </select>

                        <p class="text-danger">{{ $errors->first('is_active') }}</p>
                    </div>

                    <div class="form-field col-md-12">
                        <label for="policy_statement">
                            Policy Statement <span class="required">*</span>
                        </label>

                        <textarea id="policy_statement" name="policy_statement" class="form-input rich-text"
                            placeholder="Enter the main policy statement" rows="6" required>{{ $data['policy']->policy_statement }}</textarea>
                        <p class="text-danger">{{ $errors->first('policy_statement') }}</p>
                    </div>

                    <div class="section-divider m-3">
                        <span>Applicable To</span>
                    </div>

                    <div class="form-field col-md-6">
                        <label for="applicable_to_customer">
                            Applicable to Customers <span class="required">*</span>
                        </label>

                        <select id="applicable_to_customer" name="applicable_to_customer" class="form-input text-center"
                            required>
                            <option value="" disabled
                                {{ $data['policy']->applicable_to_customer === null ? 'selected' : '' }}>
                                Select option
                            </option>

                            <option value="0" {{ $data['policy']->applicable_to_customer == '0' ? 'selected' : '' }}>
                                No
                            </option>

                            <option value="1" {{ $data['policy']->applicable_to_customer == '1' ? 'selected' : '' }}>
                                Yes
                            </option>
                        </select>

                        <p class="text-danger">{{ $errors->first('applicable_to_customer') }}</p>

                    </div>

                    <div class="form-field col-md-6">
                        <label for="applicable_to_administrator">
                            Applicable to Administrators <span class="required">*</span>
                        </label>

                        <select id="applicable_to_administrator" name="applicable_to_administrator"
                            class="form-input text-center" required>
                            <option value="" disabled
                                {{ $data['policy']->applicable_to_administrator === null ? 'selected' : '' }}>
                                Select option
                            </option>

                            <option value="0"
                                {{ $data['policy']->applicable_to_administrator == '0' ? 'selected' : '' }}>
                                No
                            </option>

                            <option value="1"
                                {{ $data['policy']->applicable_to_administrator == '1' ? 'selected' : '' }}>
                                Yes
                            </option>
                        </select>

                        <p class="text-danger">{{ $errors->first('applicable_to_administrator') }}</p>
                    </div>
                </div>

                <div class="panel-footer form-actions">
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
