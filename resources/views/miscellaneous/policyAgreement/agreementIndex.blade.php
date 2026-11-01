@extends('layouts.miscellaneousLayout')
@section('title', 'Policy Agreement')
@section('content')
    <div class="container container-fluid">
        <div class="col-md-12 m-auto">
            <div class="user_page_title">Policy Agreement</div>

            <div class="user_page_container mb-5">
                <div class="row">
                    <div class="col-md-12 main_content_container">
                        <table class="table">
                            <tbody>
                                {{-- New Policies Start --}}
                                @if (!empty($data['newPolicies']))
                                    @foreach ($data['newPolicies'] as $new)
                                        <tr class="align-middle">
                                            <td class="px-5">
                                                {{ $new->title }}
                                                <span class="badge bg-blue ">New</span>
                                            </td>
                                            <td>
                                                {{-- Policy Modal Trigger --}}
                                                <a type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#showPolicy_{{ $new->slug }}">
                                                    <i class="fas fa-eye"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                                {{-- New Policies end --}}

                                @if (!empty($data['updatedPolicies']))
                                    {{-- Updated Policies Start --}}
                                    @foreach ($data['updatedPolicies'] as $updated)
                                        <tr class="align-middle">
                                            <td class="px-5">
                                                {{ $updated->title }}
                                                <span class="badge bg-yellow text-black">Updated</span>
                                            </td>
                                            <td>
                                                {{-- Policy Modal Trigger --}}
                                                <a type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#showPolicy_{{ $updated->slug }}">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- Updated Policies end --}}
                                @endif
                                {{-- ####################################### --}}
                                @if (!empty($data['agreedPolicies']))
                                    {{-- Agreed Policies start --}}
                                    @foreach ($data['agreedPolicies'] as $agreed)
                                        <tr class="align-middle">
                                            <td class="px-5">
                                                {{ $agreed->title }}
                                                <span class="badge bg-green ">Agreed</span>
                                            </td>
                                            <td>
                                                {{-- Policy Modal Trigger --}}
                                                <a type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#showPolicy_{{ $agreed->slug }}">
                                                    <i class="fas fa-eye"></i> View
                                                </a>

                                                {{-- Policy Modal Start --}}
                                                <div class="modal fade" id="showPolicy_{{ $agreed->slug }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div
                                                                class="modal-header d-flex justify-content-between align-items-center modal_title">
                                                                <h5 class="modal-title text-white"
                                                                    id="exampleModalLongTitle">
                                                                    {{ $agreed->title }}
                                                                </h5>
                                                                <button type="button" class="btn btn-danger p-2"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <span class="px-3">
                                                                    {!! $agreed->policy_statement !!}
                                                                </span>
                                                                <p class="text-secondary">
                                                                    This policy was Published On:
                                                                    <span
                                                                        class="text-black">{{ \Carbon\Carbon::parse($agreed->published_on)->format('l, j F Y \a\t g:i:s A') }}.</span>
                                                                    <br>
                                                                    Last Updated On:
                                                                    @if (!empty($agreed->updated_at))
                                                                        <span class="text-black">
                                                                            {{ \Carbon\Carbon::parse($agreed->updated_at)->format('l, j F Y \a\t g:i:s A') }}.
                                                                        </span>
                                                                    @endif
                                                                    <br>
                                                                    You agreed to this policy on:
                                                                    <span class="text-black">
                                                                        {{ \Carbon\Carbon::parse($agreed->agreement_date)->format('l, j F Y \a\t g:i:s A') }}
                                                                    </span>
                                                                </p>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Policy Modal End --}}

                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- Agreed Policies end --}}

                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('loginPage') }}" class="btn btn-success mx-3">
                                Proceed
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a href="{{ route('logoutRequest') }}" class="btn btn-danger mx-3">
                                Logout
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                        </table>

                    </div>

                </div>

                {{-- </div> --}}

            </div>
        </div>


        @if (!empty($data['newPolicies']))
            {{-- new policy modal start --}}
            @foreach ($data['newPolicies'] as $new)
                <div class="modal fade" id="showPolicy_{{ $new->slug }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between align-items-center modal_title">
                                <h5 class="modal-title text-white" id="exampleModalLongTitle">
                                    {{ $new->title }}
                                </h5>
                                <button type="button" class="btn btn-danger p-2" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <span class="px-3">
                                    {!! $new->policy_statement !!}
                                </span>

                            </div>
                            <div class="modal-footer">
                                <form class="my_form" action="{{ route('userAgreeToSystemPolicy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="policy" value="{{ $new->slug }}">
                                    <div class="form-group">
                                        <label for="applicable_to_local_employee">I confirm that I have read and agreed to
                                            this
                                            <span style="font-style: italic">
                                                {{ $new->title }}
                                            </span></label>
                                        <select class="form-select" name="agreement_status" required>
                                            <option selected disabled>
                                                -Select-
                                            </option>
                                            <option value="disagreed">
                                                No
                                            </option>
                                            <option value="agreed">
                                                Yes
                                            </option>
                                        </select>
                                        <p style="color: red">
                                            {{ $errors->first('agreement_status') }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger m-1"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary m-1">Save Changes</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- new policy modal end --}}
        @endif


        {{-- ################################# --}}

        @if (!empty($data['updatedPolicies']))
            {{-- Policy Modal Start --}}
            @foreach ($data['updatedPolicies'] as $updated)
                <div class="modal fade" id="showPolicy_{{ $updated->slug }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between align-items-center modal_title">
                                <h5 class="modal-title text-white" id="exampleModalLongTitle">
                                    {{ $updated->title }}
                                </h5>
                                <button type="button" class="btn btn-danger p-2" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <span class="px-3">
                                    {!! $updated->policy_statement !!}
                                </span>

                            </div>
                            <div class="modal-footer">
                                <form class="my_form" action="{{ route('userAgreeToSystemPolicy') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="policy" value="{{ $updated->slug }}">
                                    <div class="form-group">
                                        <label for="applicable_to_local_employee">I confirm that I have read and agreed to
                                            this
                                            <span style="font-style: italic">
                                                {{ $updated->title }}
                                            </span></label>
                                        <select class="form-select" name="agreement_status" required>
                                            <option selected disabled>
                                                -Select-
                                            </option>
                                            <option value="disagreed">
                                                No
                                            </option>
                                            <option value="agreed">
                                                Yes
                                            </option>
                                        </select>
                                        <p style="color: red">
                                            {{ $errors->first('agreement_status') }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger m-1"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary m-1">Save Changes</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- Policy Modal End --}}
        @endif

    </div>
@endsection
