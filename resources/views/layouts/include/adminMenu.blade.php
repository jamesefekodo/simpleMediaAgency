<aside class="sidebar" id="adminSidebar">
    <div class="sidebar-mobile-header">
        <a class="sidebar-brand" href="{{ route('adminDashboard') }}">
            <img class="brand-logo" src="{{ logo() }}" alt="Logo">

            <span class="brand-copy">
                <strong>{{ basicSystemInfo()->acronym ?? config('app.name') }}</strong>
                <small>ADMIN PANEL</small>
            </span>
        </a>

        <button class="icon-button sidebar-close" id="sidebarClose" type="button" aria-label="Close menu">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    {{-- One scrollable area for the whole menu --}}
    <div class="sidebar-body">
        <p class="sidebar-label">Main</p>

        <nav class="sidebar-nav">
            <a class="nav-item {{ Route::is('adminDashboard') ? 'active' : '' }}" href="{{ route('adminDashboard') }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>

            {{-- Store --}}
            <div class="nav-group">
                <button class="nav-dropdown-button" type="button" aria-expanded="false">
                    <span class="nav-left">
                        <i class="fa-solid fa-bag-shopping"></i>
                        Store
                    </span>
                    <i class="fa-solid fa-chevron-down chevron"></i>
                </button>

                <div class="nav-dropdown">
                    <div class="nav-dropdown-inner">
                        <a href="#">Products</a>
                        <a href="#">Categories</a>
                        <a href="#">Orders</a>
                        <a href="#">Coupons</a>
                        <a href="#">Payments</a>
                    </div>
                </div>
            </div>

            {{-- Users --}}
            <div class="nav-group">
                <button class="nav-dropdown-button" type="button" aria-expanded="false">
                    <span class="nav-left">
                        <i class="fa-solid fa-users"></i>
                        Users
                    </span>
                    <i class="fa-solid fa-chevron-down chevron"></i>
                </button>

                <div class="nav-dropdown">
                    <div class="nav-dropdown-inner">
                        <a href="#">Customers</a>
                        <a href="#">Admins</a>
                    </div>
                </div>
            </div>

            {{-- Media --}}
            <div class="nav-group">
                <button class="nav-dropdown-button" type="button" aria-expanded="false">
                    <span class="nav-left">
                        <i class="fa-solid fa-photo-film"></i>
                        Media
                    </span>
                    <i class="fa-solid fa-chevron-down chevron"></i>
                </button>

                <div class="nav-dropdown">
                    <div class="nav-dropdown-inner">
                        <a href="#">Portfolio</a>
                        <a href="#">Services</a>
                        <a href="#">Events</a>
                        <a href="#">Gallery</a>
                    </div>
                </div>
            </div>

            {{-- Community --}}
            <div class="nav-group">
                <button class="nav-dropdown-button" type="button" aria-expanded="false">
                    <span class="nav-left">
                        <i class="fa-solid fa-users"></i>
                        Community
                    </span>
                    <i class="fa-solid fa-chevron-down chevron"></i>
                </button>

                <div class="nav-dropdown">
                    <div class="nav-dropdown-inner">
                        <a href="#">Members</a>
                        <a href="#">Creator Types</a>
                        <a href="#">Email Subscribers</a>
                        <a href="#">Contact Enquiries</a>
                    </div>
                </div>
            </div>

            {{-- Opportunities --}}
            <div class="nav-group">
                <button class="nav-dropdown-button" type="button" aria-expanded="false">
                    <span class="nav-left">
                        <i class="fa-solid fa-briefcase"></i>
                        Opportunities
                    </span>
                    <i class="fa-solid fa-chevron-down chevron"></i>
                </button>

                <div class="nav-dropdown">
                    <div class="nav-dropdown-inner">
                        <a href="#">Jobs</a>
                        <a href="#">Gigs</a>
                        <a href="#">Applications</a>
                    </div>
                </div>
            </div>
        </nav>

        <p class="sidebar-label">System</p>

        <nav class="sidebar-nav">
            {{-- Reports --}}
            <div class="nav-group">
                <button class="nav-dropdown-button" type="button" aria-expanded="false">
                    <span class="nav-left">
                        <i class="fa-solid fa-chart-line"></i>
                        Reports
                    </span>
                    <i class="fa-solid fa-chevron-down chevron"></i>
                </button>

                <div class="nav-dropdown">
                    <div class="nav-dropdown-inner">
                        <a href="#">Sales Report</a>
                        <a href="#">Community Report</a>
                        <a href="#">Media Report</a>
                    </div>
                </div>
            </div>

            {{-- Settings --}}
            <div class="nav-group">
                <button class="nav-dropdown-button active" type="button" aria-expanded="false">
                    <span class="nav-left">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </span>
                    <i class="fa-solid fa-chevron-down chevron"></i>
                </button>

                <div class="nav-dropdown">
                    <div class="nav-dropdown-inner">
                        <a href="#">General</a>
                        <a href="#">Branding</a>
                        <a href="#">Roles</a>

                        @if (Auth::user()->hasPermission('policy.read'))
                            <a href="{{ route('policies') }}"
                                class="{{ Str::startsWith(request()->path(), 'admin/config/policies') ? 'active' : '' }}">
                                Policies
                            </a>
                        @endif

                        <a href="#">Payment Gateways</a>
                        <a href="#">Email Settings</a>
                        <a href="#">Admin Users</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="sidebar-footer">
        <div class="admin-user">
            <span class="avatar">R</span>

            <span>
                <strong>Rayda Admin</strong>
                <small>admin@rayda.com</small>
            </span>
        </div>
    </div>
</aside>

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
