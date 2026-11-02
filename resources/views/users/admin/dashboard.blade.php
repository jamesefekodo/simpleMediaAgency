@extends('layouts.userLayout')
@section('title', 'Dashboard')
@section('content')

@section('topbar_left')
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Monitor store performance, customers and system activity.</p>
    </div>
@endsection

<div class="content">

    <section class="welcome-card">
        <h2>Welcome back, {{ auth()->user()->name ?? 'Administrator' }}</h2>
        <p>
            Here is a quick overview of your platform performance, recent customer activity and
            important operational updates.
        </p>

        <div class="welcome-actions">
            <a href="#" class="btn-light-custom">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> View Reports
            </a>

            <a href="#" class="btn-outline-light-custom">
                <i class="fa-solid fa-users"></i> Manage Customers
            </a>
        </div>
    </section>

    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon indigo">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="stat-trend trend-up">+12.4%</span>
            </div>

            <div class="stat-value">2,486</div>
            <div class="stat-label">Total Customers</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon green">
                    <i class="fa-solid fa-naira-sign"></i>
                </div>
                <span class="stat-trend trend-up">+8.1%</span>
            </div>

            <div class="stat-value">₦4.82M</div>
            <div class="stat-label">Total Revenue</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon amber">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <span class="stat-trend trend-down">-2.3%</span>
            </div>

            <div class="stat-value">318</div>
            <div class="stat-label">Pending Orders</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon red">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <span class="stat-trend trend-up">+5.6%</span>
            </div>

            <div class="stat-value">27</div>
            <div class="stat-label">Open Issues</div>
        </div>
    </section>

    <section class="panel-grid">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Recent Orders</h3>
                    <span>Latest customer transactions</span>
                </div>

                <a href="#" class="btn-primary-custom">
                    View All
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Order</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                <div class="customer">
                                    <div class="customer-avatar">AO</div>
                                    <div>
                                        <strong>Ada Obi</strong>
                                        <span>ada@example.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>#ORD-1042</td>
                            <td>₦84,500</td>
                            <td><span class="status-pill completed">Completed</span></td>
                        </tr>

                        <tr>
                            <td>
                                <div class="customer">
                                    <div class="customer-avatar">MB</div>
                                    <div>
                                        <strong>Musa Bello</strong>
                                        <span>musa@example.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>#ORD-1041</td>
                            <td>₦32,000</td>
                            <td><span class="status-pill pending">Pending</span></td>
                        </tr>

                        <tr>
                            <td>
                                <div class="customer">
                                    <div class="customer-avatar">CE</div>
                                    <div>
                                        <strong>Chidi Eze</strong>
                                        <span>chidi@example.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>#ORD-1040</td>
                            <td>₦126,750</td>
                            <td><span class="status-pill failed">Failed</span></td>
                        </tr>

                        <tr>
                            <td>
                                <div class="customer">
                                    <div class="customer-avatar">NA</div>
                                    <div>
                                        <strong>Ngozi Ade</strong>
                                        <span>ngozi@example.com</span>
                                    </div>
                                </div>
                            </td>
                            <td>#ORD-1039</td>
                            <td>₦58,900</td>
                            <td><span class="status-pill completed">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Quick Actions</h3>
                    <span>Common admin tasks</span>
                </div>
            </div>

            <div class="quick-grid">
                <a href="#" class="quick-action">
                    <i class="fa-solid fa-user-plus"></i>
                    <strong>Add Customer</strong>
                    <span>Create a new customer account</span>
                </a>

                <a href="#" class="quick-action">
                    <i class="fa-solid fa-box-open"></i>
                    <strong>Add Product</strong>
                    <span>Publish a new product</span>
                </a>

                <a href="#" class="quick-action">
                    <i class="fa-solid fa-file-shield"></i>
                    <strong>Create Policy</strong>
                    <span>Manage platform policies</span>
                </a>

                <a href="#" class="quick-action">
                    <i class="fa-solid fa-user-shield"></i>
                    <strong>Add Admin</strong>
                    <span>Invite an administrator</span>
                </a>
            </div>

            <div class="panel-header" style="margin-top: 28px;">
                <div>
                    <h3>Recent Activity</h3>
                    <span>System and user events</span>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fa-solid fa-user"></i>
                </div>

                <div>
                    <strong>New customer registered</strong>
                    <p>Ada Obi created an account.</p>
                    <span class="activity-time">12 minutes ago</span>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>

                <div>
                    <strong>New order received</strong>
                    <p>Order #ORD-1042 was placed.</p>
                    <span class="activity-time">35 minutes ago</span>
                </div>
            </div>

            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>

                <div>
                    <strong>Policy updated</strong>
                    <p>Refund Policy was modified.</p>
                    <span class="activity-time">2 hours ago</span>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
