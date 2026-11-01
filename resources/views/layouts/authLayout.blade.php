<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ logo() }}">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.min.css">

    <!-- Toastr CSS and JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <link rel="stylesheet" href="{{ asset('custom/css/auth.css') }}">

    <title>
        @yield('title') |
        {{ basicSystemInfo()->acronym ?? config('app.name') }}
    </title>
</head>

<body>



    <main class="auth-shell">
        <aside class="auth-brand" id="authSlider">
            <!-- Replace these Unsplash URLs with your own branded images later -->
            <div class="slide active"
                style="background-image:url('https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=1800&q=80');"
                role="img" aria-label="Creator filming with professional camera equipment"></div>

            <div class="slide"
                style="background-image:url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=1800&q=80');"
                role="img" aria-label="Content creator editing video on a computer"></div>

            <div class="slide"
                style="background-image:url('https://images.unsplash.com/photo-1478720568477-152d9b164e26?auto=format&fit=crop&w=1800&q=80');"
                role="img" aria-label="Media production studio with lighting equipment"></div>

            <div class="slide"
                style="background-image:url('https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=1800&q=80');"
                role="img" aria-label="Photographer holding a camera in a creative workspace"></div>

            <div class="slide-overlay"></div>

            <a class="brand-mark" href="{{ url('/') }}">
                @if (logo())
                    <img class="brand-logo" src="{{ logo() }}"
                        alt="{{ basicSystemInfo()->app_name ?? config('app.name') }} logo">
                @else
                    <span class="brand-dot"></span>
                @endif

                {{ basicSystemInfo()->app_name ?? config('app.name') }}
            </a>

            <div class="brand-content">
                <p class="brand-eyebrow">Rayda Creator Network</p>

                <h1 class="brand-title">
                    Create. Publish. <span>Grow.</span>
                </h1>

                <p class="brand-text">
                    Sign in to manage your gadget orders, media services, event updates,
                    job opportunities, and creator community membership.
                </p>

                <div class="slider-dots" id="sliderDots">
                    <button class="slider-dot active" type="button" aria-label="Show slide 1"></button>
                    <button class="slider-dot" type="button" aria-label="Show slide 2"></button>
                    <button class="slider-dot" type="button" aria-label="Show slide 3"></button>
                    <button class="slider-dot" type="button" aria-label="Show slide 4"></button>
                </div>
            </div>
        </aside>


        @yield('content')



    </main>



    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Popper.js (required for some Bootstrap components like tooltips and popovers) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"
        integrity="sha512-TPh2Oxlg1zp+kz3nFA0C5vVC6leG/6mm1z9+mA81MI5eaUVqasPLO8Cuk4gMF4gUfP5etR73rgU/8PNMsSesoQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Sweet Alert --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.min.js"></script> --}}
    @include('layouts.include.toastrNotificationFunction')

    <script>
        const slides = document.querySelectorAll('#authSlider .slide');
        const dots = document.querySelectorAll('#sliderDots .slider-dot');
        const slideDuration = 6000;
        let currentIndex = 0;
        let sliderTimer;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });

            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });

            currentIndex = index;
        }

        function nextSlide() {
            showSlide((currentIndex + 1) % slides.length);
        }

        function startSlider() {
            clearInterval(sliderTimer);
            sliderTimer = setInterval(nextSlide, slideDuration);
        }

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
                startSlider();
            });
        });

        startSlider();

        document.querySelectorAll('.password-toggle').forEach(function(toggleButton) {
            toggleButton.addEventListener('click', function() {
                const passwordInput = toggleButton
                    .closest('.input-wrap')
                    .querySelector('.password-input');

                const isVisible = passwordInput.type === 'text';

                passwordInput.type = isVisible ? 'password' : 'text';

                toggleButton.textContent = isVisible ? 'Show' : 'Hide';
                toggleButton.setAttribute(
                    'aria-label',
                    isVisible ? 'Show password' : 'Hide password'
                );
            });
        });

        loginForm.addEventListener('submit', () => {
            submitButton.disabled = true;
            submitButton.classList.add('loading');
            buttonLabel.textContent = 'Please wait…';
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');

            const rules = {
                length: document.getElementById('length-rule'),
                lowercase: document.getElementById('lowercase-rule'),
                uppercase: document.getElementById('uppercase-rule'),
                number: document.getElementById('number-rule'),
                special: document.getElementById('special-char-rule'),
                match: document.getElementById('match-rule')
            };

            function setRule(element, isValid) {
                if (!element) return;

                element.classList.toggle('valid', isValid);
                element.classList.toggle('invalid', !isValid);

                const icon = element.querySelector('.rule-icon');

                if (icon) {
                    icon.classList.toggle('fa-circle-check', isValid);
                    icon.classList.toggle('fa-circle-xmark', !isValid);
                }
            }

            function validatePassword() {
                const password = passwordInput.value;
                const confirmPassword = confirmInput.value;

                setRule(rules.length, password.length >= 8);
                setRule(rules.lowercase, /[a-z]/.test(password));
                setRule(rules.uppercase, /[A-Z]/.test(password));
                setRule(rules.number, /\d/.test(password));
                setRule(rules.special, /[^A-Za-z0-9]/.test(password));
                setRule(rules.match, password.length > 0 && password === confirmPassword);
            }

            if (passwordInput && confirmInput) {
                passwordInput.addEventListener('input', validatePassword);
                confirmInput.addEventListener('input', validatePassword);

                validatePassword();
            }



            // ###########################################
            const registrationForm = document.getElementById('registrationForm');

            if (registrationForm) {
                registrationForm.addEventListener('submit', function(event) {
                    const password = passwordInput.value;
                    const confirmPassword = confirmInput.value;

                    const isValid =
                        password.length >= 8 &&
                        /[a-z]/.test(password) &&
                        /[A-Z]/.test(password) &&
                        /\d/.test(password) &&
                        /[^A-Za-z0-9]/.test(password) &&
                        password === confirmPassword;

                    if (!isValid) {
                        event.preventDefault();
                        validatePassword();
                        passwordInput.focus();
                    }
                });
            }
        });
    </script>

</body>

</html>
