@extends('layouts.userLayout')

@section('title', 'Dashboard')

@section('topbar_left')
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">
            Welcome back, {{ auth()->user()->name ?? 'Customer' }}. Here is an overview of your account.
        </p>
    </div>
@endsection

@section('topbar_actions')
    <a 
    {{-- href="{{ route('shop') }}" --}}
    class="btn-primary-custom">
        <i class="fa-solid fa-bag-shopping"></i> Continue Shopping
    </a>
@endsection

@section('content')
    <div class="content">
        {{-- Welcome card --}}
        <section class="welcome-card">
            <h2>
                Welcome back, {{ auth()->user()->name ?? 'Customer' }}
            </h2>

            <p>
                Track your orders, manage your wallet, review your purchases and discover new products.
            </p>

            <div class="welcome-actions">
                <a 
                {{-- href="{{ route('customerOrders') }}" --}}
                 class="btn-light-custom">
                    <i class="fa-solid fa-box"></i> View Orders
                </a>

                <a 
                {{-- href="{{ route('customerWallet') }}" --}}
                 class="btn-outline-light-custom">
                    <i class="fa-solid fa-wallet"></i> My Wallet
                </a>
            </div>
        </section>

        {{-- Account summary --}}
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon indigo">
                        <i class="fa-solid fa-box"></i>
                    </div>
                </div>

                <div class="stat-value">
                    {{-- {{ $data['totalOrders'] }} --}} 0
                </div>

                <div class="stat-label">Total Orders</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>

                <div class="stat-value">
                    {{-- {{ $data['completedOrders'] }} --}} 0
                </div>

                <div class="stat-label">Completed Orders</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon amber">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                </div>

                <div class="stat-value">
                    {{-- {{ $data['pendingOrders'] }} --}} 0
                </div>

                <div class="stat-label">Pending Orders</div>
            </div>

            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon red">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>

                <div class="stat-value">
                    {{-- ₦{{ number_format($data['walletBalance'], 2) }} --}} ₦0.00
                </div>

                <div class="stat-label">Wallet Balance</div>
            </div>
        </section>

        <section class="panel-grid">
            {{-- Recent orders --}}
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <h3>Recent Orders</h3>
                        <span>Your latest purchases</span>
                    </div>

                    <a 
                    {{-- href="{{ route('customerOrders') }}" --}}
                     class="btn-primary-custom">
                        View All
                    </a>
                </div>

                {{-- @if ($data['recentOrders']->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fa-solid fa-box-open"></i>
                        </div>

                        <h3>No orders yet</h3>

                        <p>
                            You have not placed any orders yet. Start shopping to see your orders here.
                        </p>

                        <a 
                        href="{{ route('shop') }}"
                         class="btn-primary-custom">
                            <i class="fa-solid fa-bag-shopping"></i> Start Shopping
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data['recentOrders'] as $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>

                                        <td>
                                            {{ $order->created_at->format('d M Y') }}
                                        </td>

                                        <td>
                                            ₦{{ number_format($order->total_amount, 2) }}
                                        </td>

                                        <td>
                                            @if ($order->status === 'completed')
                                                <span class="status-pill completed">Completed</span>
                                            @elseif ($order->status === 'pending')
                                                <span class="status-pill pending">Pending</span>
                                            @elseif ($order->status === 'failed')
                                                <span class="status-pill failed">Failed</span>
                                            @else
                                                <span class="status-pill pending">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="text-end">
                                            <a 
                                            href="{{ route('customerViewOrder', $order->id) }}"
                                                class="btn-primary-custom">
                                                <i class="fa-solid fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif --}}
            </div>

            {{-- Quick actions --}}
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <h3>Quick Actions</h3>
                        <span>Manage your account</span>
                    </div>
                </div>

                <div class="quick-grid">
                    <a 
                    {{-- href="{{ route('shop') }}" --}}
                     class="quick-action">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <strong>Shop Products</strong>
                        <span>Browse available products</span>
                    </a>

                    <a 
                    {{-- href="{{ route('customerOrders') }}" --}}
                     class="quick-action">
                        <i class="fa-solid fa-box"></i>
                        <strong>My Orders</strong>
                        <span>Track and view your orders</span>
                    </a>

                    <a 
                    {{-- href="{{ route('customerWallet') }}" --}}
                     class="quick-action">
                        <i class="fa-solid fa-wallet"></i>
                        <strong>My Wallet</strong>
                        <span>Check wallet balance</span>
                    </a>

                    <a 
                    {{-- href="{{ route('customerProfile') }}" --}}
                     class="quick-action">
                        <i class="fa-solid fa-user"></i>
                        <strong>My Profile</strong>
                        <span>Update account details</span>
                    </a>
                </div>

                <div class="panel-header" style="margin-top: 28px;">
                    <div>
                        <h3>Recommended Products</h3>
                        <span>Products you may like</span>
                    </div>
                </div>

                {{-- @if ($data['recommendedProducts']->isEmpty())
                    <p class="text-muted">No recommended products available yet.</p>
                @else
                    <div class="recommended-products">
                        @foreach ($data['recommendedProducts'] as $product)
                            <a href="{{ route('viewProduct', $product->slug) }}"
                                class="recommended-product-card">
                                @if ($product->primaryImage)
                                    <img src="{{ $product->primaryImage->url }}"
                                        alt="{{ $product->primaryImage->alt_text }}">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fa-regular fa-image"></i>
                                    </div>
                                @endif

                                <div class="recommended-product-details">
                                    <strong>{{ $product->name }}</strong>

                                    <span>
                                        ₦{{ number_format($product->price ?? 0, 2) }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif --}}
            </div>
        </section>
    </div>
@endsection