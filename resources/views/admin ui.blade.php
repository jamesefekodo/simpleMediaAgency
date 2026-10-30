<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rayda Admin | Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --bg: #0b0e14;
            --sidebar: #10141d;
            --surface: #131822;
            --surface-2: #1b2230;
            --text: #f7f8fc;
            --muted: #a5adbc;
            --accent: #667dff;
            --green: #58d6a3;
            --lime: #c7f36b;
            --danger: #ff6b6b;
            --warning: #ffc86b;
            --border: rgba(255, 255, 255, .1);
            --radius: 16px;
            --sidebar-width: 264px;
        }

        html[data-theme="light"] {
            --bg: #f5f6f4;
            --sidebar: #ffffff;
            --surface: #ffffff;
            --surface-2: #eef0f3;
            --text: #14203b;
            --muted: #667085;
            --accent: #4058dc;
            --green: #168b65;
            --lime: #7ba429;
            --border: rgba(20, 32, 59, .12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .admin-shell {
            display: grid;
            grid-template-columns: var(--sidebar-width) 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 24px 18px;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 8px 24px;
        }

        .brand-mark {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border: 1px solid var(--lime);
            border-radius: 50%;
            color: var(--lime);
            font: 800 20px Georgia, serif;
        }

        .brand-copy strong {
            display: block;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 15px;
            letter-spacing: .16em;
        }

        .brand-copy small {
            display: block;
            color: var(--muted);
            font-size: 8px;
            letter-spacing: .22em;
        }

        .sidebar-label {
            margin: 18px 10px 10px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .sidebar-nav {
            display: grid;
            gap: 4px;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 13px;
            border-radius: 11px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
            transition: background .18s, color .18s;
        }

        .nav-item i {
            width: 18px;
            text-align: center;
        }

        .nav-item:hover {
            color: var(--text);
            background: var(--surface-2);
        }

        .nav-item.active {
            color: var(--text);
            background: var(--surface-2);
            box-shadow: inset 3px 0 0 var(--lime);
        }

        .nav-item.active i {
            color: var(--lime);
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid var(--border);
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 12px;
            background: var(--surface-2);
        }

        .avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            color: #151910;
            background: var(--lime);
            border-radius: 50%;
            font-weight: 700;
        }

        .admin-user small {
            display: block;
            color: var(--muted);
            font-size: 11px;
        }

        .admin-user strong {
            font-size: 13px;
        }

        /* Main */
        .admin-main {
            min-width: 0;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 50;
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 0 28px;
            background: color-mix(in srgb, var(--bg) 88%, transparent);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(16px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .page-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            letter-spacing: -.03em;
        }

        .page-subtitle {
            color: var(--muted);
            font-size: 12px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-button {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 50%;
        }

        .icon-button:hover {
            border-color: var(--lime);
        }

        .search-box {
            position: relative;
            width: min(320px, 38vw);
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 13px;
        }

        .search-input {
            width: 100%;
            height: 42px;
            padding: 0 15px 0 40px;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 999px;
            outline: none;
            font-size: 13px;
        }

        .search-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--accent) 22%, transparent);
        }

        .menu-button {
            display: none;
        }

        .content {
            padding: 28px;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            padding: 22px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            color: var(--green);
            background: var(--surface-2);
            border-radius: 12px;
        }

        .stat-trend {
            padding: 5px 9px;
            color: var(--green);
            background: color-mix(in srgb, var(--green) 14%, transparent);
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .stat-trend.down {
            color: var(--danger);
            background: color-mix(in srgb, var(--danger) 14%, transparent);
        }

        .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            letter-spacing: -.04em;
        }

        .stat-label {
            margin-top: 4px;
            color: var(--muted);
            font-size: 12px;
        }

        /* Panels */
        .panel-grid {
            display: grid;
            grid-template-columns: 1.65fr 1fr;
            gap: 18px;
            margin-bottom: 24px;
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            border-bottom: 1px solid var(--border);
        }

        .panel-header h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 17px;
            letter-spacing: -.02em;
        }

        .panel-header p {
            color: var(--muted);
            font-size: 12px;
        }

        .panel-link {
            color: var(--green);
            font-size: 12px;
            font-weight: 700;
        }

        .chart-placeholder {
            min-height: 310px;
            display: grid;
            place-items: center;
            color: var(--muted);
            background:
                linear-gradient(180deg, transparent 65%, var(--surface-2)),
                var(--surface);
            font-size: 13px;
        }

        .activity-list {
            padding: 8px 22px 20px;
        }

        .activity {
            display: flex;
            gap: 14px;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }

        .activity:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            color: var(--lime);
            background: var(--surface-2);
            border-radius: 10px;
            font-size: 13px;
        }

        .activity strong {
            display: block;
            font-size: 13px;
        }

        .activity small {
            color: var(--muted);
            font-size: 11px;
        }

        /* Table */
        .table-panel {
            margin-bottom: 24px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            padding: 15px 22px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        th {
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        tbody tr:hover {
            background: var(--surface-2);
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status.success {
            color: var(--green);
            background: color-mix(in srgb, var(--green) 13%, transparent);
        }

        .status.pending {
            color: var(--warning);
            background: color-mix(in srgb, var(--warning) 15%, transparent);
        }

        .status.failed {
            color: var(--danger);
            background: color-mix(in srgb, var(--danger) 13%, transparent);
        }

        .table-action {
            padding: 7px 12px;
            color: var(--text);
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
        }

        .table-action:hover {
            border-color: var(--lime);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 42px;
            padding: 10px 17px;
            border: 1px solid transparent;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            transition: transform .18s, background .18s, border-color .18s;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            color: #fff;
            background: var(--accent);
        }

        .btn-lime {
            color: #151910;
            background: var(--lime);
        }

        .btn-ghost {
            color: var(--text);
            background: var(--surface);
            border-color: var(--border);
        }

        /* Responsive */
        .sidebar-backdrop,
        .mobile-sidebar {
            display: none;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .panel-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            .admin-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: fixed;
                z-index: 1200;
                top: 0;
                left: 0;
                width: min(300px, 86vw);
                transform: translateX(-105%);
                transition: transform .28s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-backdrop {
                position: fixed;
                z-index: 1100;
                inset: 0;
                background: rgba(0, 0, 0, .6);
            }

            .sidebar-backdrop.open {
                display: block;
            }

            .menu-button {
                display: grid;
            }

            .topbar {
                padding: 0 18px;
            }

            .content {
                padding: 20px 18px;
            }

            .search-box {
                display: none;
            }
        }

        @media (max-width: 620px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-subtitle {
                display: none;
            }

            .topbar-actions .btn {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }

        .nav-group {
            display: grid;
        }

        .nav-dropdown-button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 11px 13px;
            border: 0;
            border-radius: 11px;
            background: transparent;
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
            text-align: left;
            transition: background .18s, color .18s;
        }

        .nav-dropdown-button:hover {
            color: var(--text);
            background: var(--surface-2);
        }

        .nav-dropdown-button .nav-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-dropdown-button i:first-child {
            width: 18px;
            text-align: center;
        }

        .nav-dropdown-button .chevron {
            font-size: 11px;
            transition: transform .2s ease;
        }

        .nav-dropdown-button[aria-expanded="true"] .chevron {
            transform: rotate(180deg);
        }

        .nav-dropdown {
            display: grid;
            grid-template-rows: 0fr;
            overflow: hidden;
            transition: grid-template-rows .25s ease;
        }

        .nav-dropdown.open {
            grid-template-rows: 1fr;
        }

        .nav-dropdown-inner {
            min-height: 0;
            display: grid;
            gap: 2px;
            padding: 4px 0 4px 20px;
        }

        .nav-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 9px;
            color: var(--muted);
            font-size: 12.5px;
            font-weight: 600;
        }

        .nav-dropdown a:hover {
            color: var(--text);
            background: var(--surface-2);
        }

        .nav-dropdown a.active {
            color: var(--text);
            background: var(--surface-2);
            box-shadow: inset 2px 0 0 var(--lime);
        }
    </style>
</head>

<body>

    <div class="admin-shell">
        {{-- Sidebar --}}
        <aside class="sidebar" id="adminSidebar">
            <a class="sidebar-brand" href="{{ url('/admin') }}">
                <span class="brand-mark">R</span>
                <span class="brand-copy">
                    <strong>RAYDA</strong>
                    <small>ADMIN PANEL</small>
                </span>
            </a>

            <p class="sidebar-label">Main</p>

            <nav class="sidebar-nav">
                {{-- Dashboard stays a normal link --}}
                <a class="nav-item active" href="{{ url('/admin') }}">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>

                {{-- Store dropdown --}}
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

                {{-- Media dropdown --}}
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

                {{-- Community dropdown --}}
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

                {{-- Opportunities dropdown --}}
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
                {{-- Reports dropdown --}}
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

                {{-- Settings dropdown --}}
                <div class="nav-group">
                    <button class="nav-dropdown-button" type="button" aria-expanded="false">
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
                            <a href="#">Payment Gateways</a>
                            <a href="#">Email Settings</a>
                            <a href="#">Admin Users</a>
                        </div>
                    </div>
                </div>
            </nav>

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

        {{-- Main --}}
        <div class="admin-main">
            <header class="topbar">
                <div class="topbar-left">
                    <button class="icon-button menu-button" id="sidebarToggle" type="button"
                        aria-label="Open menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <div>
                        <h1 class="page-title">Dashboard</h1>
                        <p class="page-subtitle">Overview of Rayda store, media and community activity.</p>
                    </div>
                </div>

                <div class="topbar-actions">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input class="search-input" type="search"
                            placeholder="Search orders, products, creators...">
                    </div>

                    <button class="icon-button" id="themeToggle" type="button" aria-label="Toggle theme">
                        <i class="fa-solid fa-sun"></i>
                    </button>

                    <a class="btn btn-lime" href="#">
                        <i class="fa-solid fa-plus"></i> New Product
                    </a>
                </div>
            </header>

            <div class="content">
                {{-- Stats --}}
                <section class="stats-grid">
                    <article class="stat-card">
                        <div class="stat-top">
                            <span class="stat-icon"><i class="fa-solid fa-naira-sign"></i></span>
                            <span class="stat-trend">+12.4%</span>
                        </div>
                        <div class="stat-value">₦0</div>
                        <p class="stat-label">Total revenue</p>
                    </article>

                    <article class="stat-card">
                        <div class="stat-top">
                            <span class="stat-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                            <span class="stat-trend">+8.1%</span>
                        </div>
                        <div class="stat-value">0</div>
                        <p class="stat-label">Orders</p>
                    </article>

                    <article class="stat-card">
                        <div class="stat-top">
                            <span class="stat-icon"><i class="fa-solid fa-users"></i></span>
                            <span class="stat-trend">+24</span>
                        </div>
                        <div class="stat-value">0</div>
                        <p class="stat-label">Community members</p>
                    </article>

                    <article class="stat-card">
                        <div class="stat-top">
                            <span class="stat-icon"><i class="fa-solid fa-briefcase"></i></span>
                            <span class="stat-trend down">-2.3%</span>
                        </div>
                        <div class="stat-value">0</div>
                        <p class="stat-label">Open opportunities</p>
                    </article>
                </section>

                {{-- Chart + activity --}}
                <section class="panel-grid">
                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h2>Revenue overview</h2>
                                <p>Store performance for the selected period.</p>
                            </div>
                            <a class="panel-link" href="#">View report</a>
                        </div>

                        <div class="chart-placeholder">
                            Connect Chart.js, ApexCharts or your preferred chart library here.
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <h2>Recent activity</h2>
                                <p>Latest admin and customer events.</p>
                            </div>
                            <a class="panel-link" href="#">View all</a>
                        </div>

                        <div class="activity-list">
                            <div class="activity">
                                <span class="activity-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                                <div>
                                    <strong>New order received</strong>
                                    <small>Rayda Creator Kit · Just now</small>
                                </div>
                            </div>

                            <div class="activity">
                                <span class="activity-icon"><i class="fa-solid fa-user-plus"></i></span>
                                <div>
                                    <strong>New community signup</strong>
                                    <small>Content creator · 12 minutes ago</small>
                                </div>
                            </div>

                            <div class="activity">
                                <span class="activity-icon"><i class="fa-solid fa-envelope"></i></span>
                                <div>
                                    <strong>New contact enquiry</strong>
                                    <small>Video production request · 1 hour ago</small>
                                </div>
                            </div>

                            <div class="activity">
                                <span class="activity-icon"><i class="fa-solid fa-briefcase"></i></span>
                                <div>
                                    <strong>New gig application</strong>
                                    <small>Freelance videographer · 3 hours ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Orders table --}}
                <section class="panel table-panel">
                    <div class="panel-header">
                        <div>
                            <h2>Recent orders</h2>
                            <p>Latest gadget kit orders and payment statuses.</p>
                        </div>
                        <a class="btn btn-ghost" href="#">View orders</a>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#RD-1042</td>
                                    <td>Amina Bello</td>
                                    <td>Rayda Creator Kit</td>
                                    <td>₦0</td>
                                    <td><span class="status success">Paid</span></td>
                                    <td>Oct 29, 2026</td>
                                    <td><a class="table-action" href="#">View</a></td>
                                </tr>

                                <tr>
                                    <td>#RD-1041</td>
                                    <td>David Okoro</td>
                                    <td>Content Creation Kit</td>
                                    <td>₦0</td>
                                    <td><span class="status pending">Pending</span></td>
                                    <td>Oct 29, 2026</td>
                                    <td><a class="table-action" href="#">View</a></td>
                                </tr>

                                <tr>
                                    <td>#RD-1040</td>
                                    <td>Zainab Yusuf</td>
                                    <td>Creator Pro Bundle</td>
                                    <td>₦0</td>
                                    <td><span class="status failed">Failed</span></td>
                                    <td>Oct 28, 2026</td>
                                    <td><a class="table-action" href="#">View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const root = document.documentElement;
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const themeToggle = document.getElementById('themeToggle');

            function setTheme(theme) {
                root.dataset.theme = theme;

                themeToggle.innerHTML = theme === 'light' ?
                    '<i class="fa-solid fa-moon"></i>' :
                    '<i class="fa-solid fa-sun"></i>';

                try {
                    localStorage.setItem('rayda-admin-theme', theme);
                } catch (error) {}
            }

            let savedTheme = null;

            try {
                savedTheme = localStorage.getItem('rayda-admin-theme');
            } catch (error) {}

            setTheme(
                savedTheme ||
                (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark')
            );

            themeToggle.addEventListener('click', function() {
                setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark');
            });

            function openSidebar() {
                sidebar.classList.add('open');
                backdrop.classList.add('open');
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                backdrop.classList.remove('open');
            }

            sidebarToggle.addEventListener('click', openSidebar);
            backdrop.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') closeSidebar();
            });


            document.querySelectorAll('.nav-dropdown-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    const dropdown = button.nextElementSibling;
                    const isOpen = dropdown.classList.contains('open');

                    document.querySelectorAll('.nav-dropdown').forEach(function(item) {
                        item.classList.remove('open');
                    });

                    document.querySelectorAll('.nav-dropdown-button').forEach(function(item) {
                        item.setAttribute('aria-expanded', 'false');
                    });

                    if (!isOpen) {
                        dropdown.classList.add('open');
                        button.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        });
    </script>

</body>

</html>
