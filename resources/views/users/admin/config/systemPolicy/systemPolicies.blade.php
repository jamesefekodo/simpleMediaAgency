@extends('layouts.userLayout')

@section('title', $data['pageTitle'])

@section('content')
    <header class="topbar">
        <div class="topbar-left">
            <div>
                <h1 class="page-title">{{ $data['pageTitle'] }}</h1>
                <p class="page-subtitle">
                    Manage policies.
                </p>
            </div>
        </div>

        <div class="topbar-actions">
            <form method="GET" class="search-box" action="{{ route('policiesSearch') }}">
                <i class="fa-solid fa-magnifying-glass"></i>

                <input class="search-input" type="search" name="searchKey" value="{{ $data['searchKey'] }}"
                    placeholder="Search policies..." aria-label="Search policies">
            </form>

            <button class="icon-button theme-toggle" type="button" aria-label="Toggle theme">
                <i class="fa-solid fa-sun"></i>
            </button>

            @if (Auth::user()->hasPermission('policy.create'))
                <a href="{{ route('newPolicy') }}" class="btn btn-lime" >
                    <i class="fa-solid fa-plus"></i> New Policy
                </a>
            @endif
        </div>
    </header>

    <div class="content">
        <div class="panel table-panel">
            <div class="panel-header">
                <div>
                    <h2>System Policies</h2>
                    <p>
                        {{ $data['systemPolicies']->total() }}
                        {{ $data['systemPolicies']->total() === 1 ? 'policy' : 'policies' }} found
                    </p>
                </div>

                @if ($data['requestType'] === 'search')
                    <a class="btn btn-ghost" href="{{ route('policies') }}">
                        <i class="fa-solid fa-arrow-left"></i>
                        Clear search
                    </a>
                @endif
            </div>

            @if ($data['systemPolicies']->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-file-shield"></i>

                    <h3>No policies found</h3>

                    <p>
                        @if ($data['requestType'] === 'search')
                            No policies match “{{ $data['searchKey'] }}”.
                        @else
                            No policies have been added yet.
                        @endif
                    </p>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Customer Policy</th>
                                <th>Administrator Policy</th>
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
                                        <span class="table-preview">
                                            {{ Str::limit(strip_tags($policy->applicable_to_customer), 90) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="table-preview">
                                            {{ Str::limit(strip_tags($policy->applicable_to_administrator), 90) }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <div class="table-actions">
                                            <a class="table-action" {{-- href="{{ route('policiesShow', $policy) }}" --}} title="View policy">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <a class="table-action" {{-- href="{{ route('policiesEdit', $policy) }}" --}} title="Edit policy">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <button type="button" class="table-action danger" {{-- data-delete-url="{{ route('policiesDestroy', $policy) }}" --}}
                                                data-policy-title="{{ $policy->title }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
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
@endsection
