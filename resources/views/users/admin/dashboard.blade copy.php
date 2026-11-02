@extends('layouts.userLayout')
@section('title', 'Dashboard')
@section('content')
    <header class="topbar">
        <div class="topbar-left">
            <div>
                <h1 class="page-title">Dashboard</h1>
                <p class="page-subtitle">Overview of Rayda store, media and community activity.</p>
            </div>
        </div>

        <div class="topbar-actions">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input class="search-input" type="search" placeholder="Search orders, products, creators...">
            </div>

            <button class="icon-button theme-toggle" type="button" aria-label="Toggle theme">
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

@endsection
