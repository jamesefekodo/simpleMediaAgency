<aside class="admin-sidebar" id="adminSidebar">
    <a class="sidebar-brand" href="{{ route('customerDashboard') }}">
        <img src="{{ logo() }}" alt="Logo">

        <div>
            <strong>{{ basicSystemInfo()->acronym ?? config('app.name') }}</strong>
            <span>Customer Portal</span>
        </div>
    </a>

    <nav class="sidebar-nav">
        <div class="sidebar-label">Overview</div>

        <a class="sidebar-link {{ request()->routeIs('customerDashboard') ? 'active' : '' }}"
            href="{{ route('customerDashboard') }}">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>

        <a class="sidebar-link {{ request()->routeIs('customerOrders') || request()->routeIs('customerViewOrder') ? 'active' : '' }}"
            {{-- href="{{ route('customerOrders') }}" --}}>
            <i class="fa-solid fa-box"></i> My Orders
        </a>

        <a class="sidebar-link {{ request()->routeIs('customerWallet') ? 'active' : '' }}" {{-- href="{{ route('customerWallet') }}" --}}>
            <i class="fa-solid fa-wallet"></i> My Wallet
        </a>

        <a class="sidebar-link {{ request()->routeIs('customerProfile') ? 'active' : '' }}" {{-- href="{{ route('customerProfile') }}" --}}>
            <i class="fa-solid fa-user"></i> My Profile
        </a>

        <div class="sidebar-label">Shopping</div>

        <a class="sidebar-link {{ request()->routeIs('shop') ? 'active' : '' }}" {{-- href="{{ route('shop') }}" --}}>
            <i class="fa-solid fa-bag-shopping"></i> Shop Products
        </a>

        <a class="sidebar-link {{ request()->routeIs('shopCategories') ? 'active' : '' }}" {{-- href="{{ route('shopCategories') }}" --}}>
            <i class="fa-solid fa-folder-tree"></i> Categories
        </a>

        <a class="sidebar-link {{ request()->routeIs('customerWishlist') ? 'active' : '' }}" {{-- href="{{ route('customerWishlist') }}" --}}>
            <i class="fa-solid fa-heart"></i> Wishlist
        </a>

        <a class="sidebar-link {{ request()->routeIs('customerCart') ? 'active' : '' }}" {{-- href="{{ route('customerCart') }}" --}}>
            <i class="fa-solid fa-cart-shopping"></i> Cart
        </a>

        <div class="sidebar-label">Support</div>

        <a class="sidebar-link {{ request()->routeIs('customerHelp') ? 'active' : '' }}" {{-- href="{{ route('customerHelp') }}" --}}>
            <i class="fa-solid fa-circle-question"></i> Help Center
        </a>

        <a class="sidebar-link {{ request()->routeIs('customerSupport') ? 'active' : '' }}" {{-- href="{{ route('customerSupport') }}" --}}>
            <i class="fa-solid fa-headset"></i> Contact Support
        </a>

        <a class="sidebar-link {{ request()->routeIs('customerPolicies') ? 'active' : '' }}" {{-- href="{{ route('customerPolicies') }}" --}}>
            <i class="fa-solid fa-shield-halved"></i> Policies
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ substr(auth()->user()->name ?? 'C', 0, 1) }}
            </div>

            <div>
                <strong>{{ auth()->user()->name ?? 'Customer' }}</strong>
                <span>{{ auth()->user()->email ?? 'customer@example.com' }}</span>
            </div>
        </div>

        <form action="{{ route('logoutRequest') }}" method="POST">
            @csrf

            <button type="submit" class="sidebar-logout-button">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutForm = document.querySelector('.sidebar-footer form');

            if (logoutForm) {
                logoutForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Logout?',
                        text: 'Are you sure you want to logout?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, logout',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }
        });
    </script>
</aside>
