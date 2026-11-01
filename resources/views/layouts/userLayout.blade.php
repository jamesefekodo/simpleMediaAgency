<!DOCTYPE html>
<html lang="en" data-theme="dark">

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


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.min.css">

    <!-- Toastr CSS and JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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

        <div class="admin-main">
            <header class="mobile-topbar">
                <button class="icon-button menu-button" id="sidebarToggle" type="button" aria-label="Open menu">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <a class="mobile-brand" href="{{ route('adminDashboard') }}">
                    <img class="mobile-brand-logo" src="{{ logo() }}" alt="Logo">
                    <span>{{ basicSystemInfo()->acronym ?? config('app.name') }}</span>
                </a>

                <button class="icon-button theme-toggle" type="button" aria-label="Toggle theme">
                    <i class="fa-solid fa-sun"></i>
                </button>
            </header>

            <header class="topbar desktop-topbar">
                <div class="topbar-left">
                    @yield('topbar_left')
                </div>

                <div class="topbar-actions">
                    @yield('topbar_actions')

                    <button class="icon-button theme-toggle" type="button" aria-label="Toggle theme">
                        <i class="fa-solid fa-sun"></i>
                    </button>
                </div>
            </header>

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Popper.js (required for some Bootstrap components like tooltips and popovers) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"
        integrity="sha512-TPh2Oxlg1zp+kz3nFA0C5vVC6leG/6mm1z9+mA81MI5eaUVqasPLO8Cuk4gMF4gUfP5etR73rgU/8PNMsSesoQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Sweet Alert --}}
    @include('layouts.include.toastrNotificationFunction')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const root = document.documentElement;
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const themeToggles = document.querySelectorAll('.theme-toggle');

            /* Theme */
            function setTheme(theme) {
                root.dataset.theme = theme;

                themeToggles.forEach(function(toggle) {
                    toggle.innerHTML = theme === 'light' ?
                        '<i class="fa-solid fa-moon"></i>' :
                        '<i class="fa-solid fa-sun"></i>';

                    toggle.setAttribute(
                        'aria-label',
                        theme === 'light' ? 'Switch to dark theme' : 'Switch to light theme'
                    );
                });

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

            themeToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark');
                });
            });

            /* Sidebar */
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

            sidebarToggle.addEventListener('click', openSidebar);
            backdrop.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') closeSidebar();
            });

            /* Sidebar dropdowns */
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


            const sidebarClose = document.getElementById('sidebarClose');

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }
        });
    </script>
</body>

</html>
