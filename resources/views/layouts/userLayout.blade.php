<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/x-icon" href="{{ logo() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
        rel="stylesheet">

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">



    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.min.css">

    <!-- Toastr CSS and JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <link rel="stylesheet" href="{{ asset('custom/css/adminDashboard.css') }}">

    <title>
        @yield('title') |
        {{ basicSystemInfo()->acronym ?? config('app.name') }}
    </title>
</head>

<body>
    <div class="admin-shell">

        @include('layouts.include.adminMenu')
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <main class="admin-main">
            <header class="mobile-topbar">
                <button class="icon-button" id="sidebarToggle" type="button" aria-label="Open menu">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <strong>{{ basicSystemInfo()->acronym ?? config('app.name') }}</strong>

                <div class="sidebar-user-avatar">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
            </header>

            <header class="admin-topbar">
                <div class="topbar-title">
                    @yield('topbar_left')
                </div>

                <div class="topbar-actions">
                    @yield('topbar_actions')
                </div>
            </header>

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggle = document.getElementById('sidebarToggle');

            function openSidebar() {
                sidebar.classList.add('open');
                backdrop.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                backdrop.classList.remove('open');
                document.body.style.overflow = '';
            }

            toggle.addEventListener('click', openSidebar);
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                const button = form.querySelector('button[type="submit"]');

                if (!button || button.dataset.loading === 'true') {
                    return;
                }

                button.dataset.loading = 'true';
                button.disabled = true;

                button.dataset.originalHtml = button.innerHTML;
                button.innerHTML =
                    '<span class="button-spinner"></span> Please wait...';
            });
        });
    });
</script>
</body>

</html>
