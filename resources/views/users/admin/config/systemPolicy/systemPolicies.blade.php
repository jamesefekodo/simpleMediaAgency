@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('topbar_left')
    <div>
        <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
        <p class="page-subtitle">Manage policies.</p>
    </div>
@endsection

@section('topbar_actions')
    <form method="GET" class="search-box" action="{{ route('policiesSearch') }}">
        <i class="fa-solid fa-magnifying-glass"></i>

        <input class="search-input" type="search" name="searchKey" value="{{ $data['searchKey'] }}"
            placeholder="Search policies..." aria-label="Search policies">
    </form>

    @if (Auth::user()->hasPermission('policy.create'))
        <a href="{{ route('newPolicy') }}" class="btn-primary-custom">
            <i class="fa-solid fa-plus"></i> New Policy
        </a>
    @endif
@endsection

@section('content')
    <div class="content">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>System Policies</h3>
                    <span>
                        {{ $data['systemPolicies']->total() }}
                        {{ $data['systemPolicies']->total() === 1 ? 'policy' : 'policies' }} found
                    </span>
                </div>

                @if ($data['requestType'] === 'search')
                    <a href="{{ route('policies') }}" class="btn-outline-light-custom">
                        <i class="fa-solid fa-arrow-left"></i> Clear search
                    </a>
                @endif
            </div>

            @if ($data['systemPolicies']->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>

                    <h3>No policies found</h3>

                    <p>
                        @if ($data['requestType'] === 'search')
                            No policies match “{{ $data['searchKey'] }}”.
                        @else
                            No policies have been added yet.
                        @endif
                    </p>

                    @if (Auth::user()->hasPermission('policy.create'))
                        <a href="{{ route('newPolicy') }}" class="btn-primary-custom">
                            <i class="fa-solid fa-plus"></i> Create Policy
                        </a>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Applicable To</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data['systemPolicies'] as $policy)
                                <tr>
                                    <td>
                                        <strong>{{ $policy->title }}</strong>
                                    </td>

                                    <td>
                                        <div class="badge-group">
                                            @if ($policy->applicable_to_customer === true)
                                                <span class="status-pill completed">Customer</span>
                                            @endif

                                            @if ($policy->applicable_to_administrator === true)
                                                <span class="status-pill pending">Administrator</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="text-end">
                                        <div class="table-actions">
                                            <a class="btn-primary-custom"
                                                href="{{ route('viewPolicy', ['slug' => $policy->slug]) }}">
                                                <i class="fa-solid fa-eye"></i> View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="panel-footer">
                    {{ $data['systemPolicies']->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Back Home --}}
    <div class="w-100 justify-content-center text-center mb-4">
        <div class="w-100 justify-content-center text-center mb-4">
            @switch($data['requestType'])
                @case('all')
                    {{ '' }}
                @break

                @case('search')
                    <a class="btn btn-primary" href="{{ route('policies') }}"> <i class="fas fa-chevron-left"></i>
                        Back
                    </a>
                @break

                @default
            @endswitch

        </div>

    </div>
@endsection
