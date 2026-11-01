@extends('layouts.userLayout')

@section('title', 'Create Policy')


@section('content')
    <header class="topbar">
        <div class="topbar-left">
            <div>
                <h1 class="page-title">Create Policy</h1>
                {{-- <p class="page-subtitle">
                    Add a new policy for customers and administrators.
                </p> --}}
            </div>

        </div>

        <div class="topbar-actions">
            <a class="btn btn-ghost" href="{{ route('policies') }}">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Policies
            </a>
        </div>
    </header>

    <div class="content">
        <form method="POST" action="{{ route('addNewSystemPolicySubmit') }}" class="admin-form">
            @csrf

            <div class="panel form-panel">
                <div class="panel-header">
                    <div>
                        <h2>Policy Details</h2>
                        <p>Provide the policy title and its content.</p>
                    </div>
                </div>

                <div class="panel-body">
                        <div class="row col-md-12">
                            <div class="form-group col-md-12">
                                <label for="title">
                                    Policy Title <span class="required">*</span>
                                </label>

                                <input id="title" name="title" type="text"
                                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                    placeholder="Enter policy title" required>

                                @error('title')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="policy_statement">
                                    Policy Statement <span class="required">*</span>
                                </label>

                                <textarea id="policy_statement" name="policy_statement"
                                    class="form-control note-editable @error('policy_statement') is-invalid @enderror"
                                    placeholder="Enter the main policy statement" rows="6" required>{{ old('policy_statement') }}</textarea>

                                @error('policy_statement')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center">
                                <hr class="flex-grow-1">
                                <span class="mx-2">Applicable to:</span>
                                <hr class="flex-grow-1">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="applicable_to_customer">
                                    Applicable to Customers <span class="required">*</span>
                                </label>

                                <select class="form-select text-center" name="applicable_to_customer" required>
                                    <option selected disabled>
                                        -Select-</option>
                                    <option value="0" {{ old('applicable_to_customer') == '0' ? 'selected' : '' }}>
                                        No</option>
                                    <option value="1" {{ old('applicable_to_customer') == '1' ? 'selected' : '' }}>
                                        Yes</option>
                                </select>
                                @error('applicable_to_customer')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="applicable_to_administrator">
                                    Applicable to Administrators <span class="required">*</span>
                                </label>

                                 <select class="form-select text-center" name="applicable_to_administrator" required>
                                    <option selected disabled>
                                        -Select-</option>
                                    <option value="0" {{ old('applicable_to_administrator') == '0' ? 'selected' : '' }}>
                                        No</option>
                                    <option value="1" {{ old('applicable_to_administrator') == '1' ? 'selected' : '' }}>
                                        Yes</option>
                                </select>

                                @error('applicable_to_administrator')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                    </div>
                </div>

                <div class="panel-footer form-actions">
                    <a href="{{ route('policies') }}" class="btn btn-ghost">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-lime">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save Policy
                    </button>
                </div>
            </div>
        </form>
    </div>



    {{-- Back Home --}}
    <div class="w-100 justify-content-center text-center mb-4">
        <div class="w-100 justify-content-center text-center mb-4">
            <a class="btn btn-ghost" href="{{ route('policies') }}">
                <i class="fas fa-chevron-left"></i>
                Back
            </a>
        </div>

    </div>


    <!-- Initialize Summernote -->
    <script>
        $(document).ready(function() {
            $('#policy_statement').summernote({
                height: 200,
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

@endsection
