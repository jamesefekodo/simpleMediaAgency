
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rayda Global Agency | Turning Ideas into Impact</title>

    <meta name="description" content="Rayda Global Agency delivers creative media production, photography, video, events, creator gadgets and opportunities for creators.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        /* =====================================================
           RAYDA GLOBAL AGENCY
           Single-file Laravel Blade homepage
        ===================================================== */

        :root {
            --bg: #0b0e14;
            --surface: #131822;
            --surface-2: #1b2230;
            --text: #f7f8fc;
            --muted: #a5adbc;
            --accent: #667dff;
            --green: #58d6a3;
            --border: rgba(255,255,255,.11);
            --header-bg: rgba(11,14,20,.86);
            --shadow: 0 20px 60px rgba(0,0,0,.2);
            --radius: 18px;
            --container: 1200px;
        }

        html[data-theme="light"] {
            --bg: #f7f8f6;
            --surface: #ffffff;
            --surface-2: #edf0f4;
            --text: #14203b;
            --muted: #667085;
            --accent: #4058dc;
            --green: #168b65;
            --border: rgba(20,32,59,.12);
            --header-bg: rgba(247,248,246,.92);
            --shadow: 0 18px 55px rgba(20,32,59,.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 90px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.65;
            overflow-x: hidden;
            transition: background .3s, color .3s;
        }

        body, button, input, textarea, select {
            font-family: 'DM Sans', sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button, input, textarea, select {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .container {
            width: min(var(--container), calc(100% - 48px));
            margin-inline: auto;
        }

        .section {
            padding: 105px 0;
        }

        .section-soft {
            background: var(--surface);
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 30px;
            margin-bottom: 42px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--green);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .eyebrow::before {
            content: "";
            width: 20px;
            height: 2px;
            background: var(--green);
        }

        h1, h2, h3, h4 {
            font-family: 'Space Grotesk', sans-serif;
            line-height: 1.12;
        }

        h2 {
            font-size: clamp(32px, 4vw, 49px);
            letter-spacing: -1.8px;
        }

        .section-heading p {
            color: var(--muted);
            max-width: 390px;
            font-size: 14px;
        }

        .text-muted {
            color: var(--muted);
        }

        .accent-text {
            color: var(--green);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 47px;
            padding: 12px 19px;
            border: 1px solid transparent;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 700;
            transition: transform .2s, background .2s, border-color .2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            color: #fff;
            background: var(--accent);
        }

        .btn-primary:hover {
            background: #5068ef;
        }

        .btn-outline {
            border-color: var(--border);
            color: var(--text);
            background: transparent;
        }

        .btn-outline:hover {
            border-color: var(--green);
        }

        .btn-green {
            color: #081810;
            background: var(--green);
        }

        .full-width {
            width: 100%;
        }

        /* ================= HEADER ================= */

        .site-header {
            position: sticky;
            z-index: 1000;
            top: 0;
            background: var(--header-bg);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(18px);
        }

        .navbar {
            min-height: 78px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
        }

        .brand {
            flex-shrink: 0;
        }

        .brand img {
            width: 175px;
            height: 62px;
            object-fit: contain;
            object-position: left center;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .nav-links a {
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            transition: color .2s;
        }

        .nav-links a:hover {
            color: var(--green);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .theme-toggle,
        .menu-toggle,
        .cart-button {
            position: relative;
            width: 41px;
            height: 41px;
            display: grid;
            place-items: center;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 50%;
        }

        .theme-toggle:hover,
        .cart-button:hover {
            border-color: var(--green);
        }

        .cart-count {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            display: grid;
            place-items: center;
            color: #081810;
            background: var(--green);
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
        }

        .menu-toggle {
            display: none;
        }

        /* ================= CINEMATIC HERO ================= */

        .hero {
            position: relative;
            isolation: isolate;
            min-height: 680px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: #0b0e14;
            color: #fff;
        }

        .hero-backdrop {
            position: absolute;
            z-index: -3;
            inset: -3%;
            background: url('https://images.unsplash.com/photo-1492619375914-88005aa9e8fb?auto=format&fit=crop&w=2200&q=85') center 45% / cover;
            transform: scale(1.04);
            animation: backdropMove 24s ease-in-out infinite alternate;
        }

        .hero-backdrop::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(7,10,16,.96) 0%, rgba(7,10,16,.8) 40%, rgba(7,10,16,.23) 100%),
                linear-gradient(0deg, #0b0e14 0%, transparent 27%, rgba(7,10,16,.18) 100%);
        }

        html[data-theme="light"] .hero-backdrop::after {
            background:
                linear-gradient(90deg, rgba(7,10,16,.92) 0%, rgba(7,10,16,.72) 43%, rgba(7,10,16,.16) 100%),
                linear-gradient(0deg, #f7f8f6 0%, transparent 23%);
        }

        .hero-grain {
            position: absolute;
            z-index: -1;
            inset: 0;
            opacity: .09;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.35'/%3E%3C/svg%3E");
        }

        .hero-content {
            width: 100%;
            display: grid;
            grid-template-columns: 1.03fr .97fr;
            align-items: center;
            gap: 35px;
            padding-top: 75px;
            padding-bottom: 90px;
        }

        .hero-copy {
            position: relative;
            z-index: 5;
            animation: revealUp .8s both;
        }

        .hero .eyebrow {
            color: #72e0b5;
        }

        .hero h1 {
            max-width: 700px;
            font-size: clamp(53px, 7vw, 88px);
            letter-spacing: -5px;
            line-height: .99;
        }

        .hero h1 span {
            color: #76e0b4;
        }

        .hero-description {
            max-width: 475px;
            margin-top: 24px;
            color: #d3d8e1;
            font-size: 15px;
            line-height: 1.9;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 13px;
            margin-top: 30px;
        }

        .hero .btn-outline {
            color: #fff;
            border-color: rgba(255,255,255,.35);
        }

        .hero .btn-outline:hover {
            border-color: #76e0b4;
        }

        .hero-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 49px;
            color: #d3d8e1;
            font-size: 9px;
            letter-spacing: 1.4px;
        }

        .hero-meta .line {
            width: 28px;
            height: 1px;
            background: var(--green);
        }

        .hero-visual {
            position: relative;
            min-height: 470px;
            perspective: 1000px;
        }

        .hero-main-image {
            position: absolute;
            inset: 20px 35px 40px 20px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 45% 45% 12px 12px;
            box-shadow: 0 30px 90px rgba(0,0,0,.35);
            animation: imageBob 8s ease-in-out infinite alternate;
        }

        .hero-main-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity .3s, transform .8s;
        }

        .hero-main-image:hover img {
            transform: scale(1.04);
        }

        .hero-image-caption {
            position: absolute;
            inset: auto 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 28px 20px 20px;
            color: white;
            background: linear-gradient(transparent, rgba(0,0,0,.85));
            font-size: 12px;
        }

        .hero-image-caption span:first-child {
            color: #8de6c1;
            font-size: 10px;
        }

        .hero-float-card {
            position: absolute;
            z-index: 3;
            right: 0;
            bottom: 12px;
            width: 155px;
            padding: 6px;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 12px;
            background: #1b2230;
            box-shadow: 0 20px 55px rgba(0,0,0,.35);
            transform: rotate(4deg);
            animation: floatCard 6s ease-in-out infinite;
        }

        .hero-float-card img {
            width: 100%;
            height: 120px;
            border-radius: 7px;
            object-fit: cover;
        }

        .hero-float-card div {
            padding: 10px 5px 5px;
            color: white;
            font-size: 10px;
        }

        .hero-float-card i {
            color: #8de6c1;
            margin-right: 6px;
        }

        .hero-label {
            position: absolute;
            top: 0;
            right: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            font-size: 9px;
            letter-spacing: 1.5px;
        }

        .hero-label span {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--green);
            box-shadow: 0 0 12px var(--green);
        }

        .hero-bottom {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            border-top: 1px solid rgba(255,255,255,.18);
        }

        .hero-bottom-inner {
            min-height: 65px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            color: #d3d8e1;
            font-size: 9px;
            letter-spacing: 1.2px;
        }

        .hero-bottom a {
            color: white;
        }

        .hero-bottom a i {
            color: var(--green);
            margin-left: 8px;
        }

        .hero-scene-controls {
            display: flex;
            gap: 7px;
        }

        .scene-btn {
            width: 35px;
            height: 29px;
            color: white;
            background: transparent;
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 4px;
            font-size: 10px;
        }

        .scene-btn.active,
        .scene-btn:hover {
            color: #0b0e14;
            background: #76e0b4;
            border-color: #76e0b4;
        }

        /* ================= TRUST STRIP ================= */

        .trust-strip {
            padding: 27px 0;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
        }

        .trust-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
        }

        .trust-inner span {
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
        }

        .trust-inner .trust-brand {
            color: var(--text);
            font-family: 'Space Grotesk', sans-serif;
            font-size: 13px;
            letter-spacing: .3px;
        }

        /* ================= PORTFOLIO ================= */

        .portfolio-grid {
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            gap: 22px;
        }

        .portfolio-card {
            position: relative;
            min-height: 280px;
            overflow: hidden;
            background: var(--surface-2);
            border-radius: var(--radius);
        }

        .portfolio-card.large {
            grid-row: span 2;
            min-height: 580px;
        }

        .portfolio-card img {
            width: 100%;
            height: 100%;
            position: absolute;
            inset: 0;
            object-fit: cover;
            transition: transform .7s;
        }

        .portfolio-card:hover img {
            transform: scale(1.06);
        }

        .portfolio-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(0,0,0,.86), transparent 70%);
        }

        .portfolio-card-content {
            position: absolute;
            z-index: 2;
            right: 24px;
            bottom: 24px;
            left: 24px;
            color: white;
        }

        .portfolio-card-content span {
            color: #8de6c1;
            font-size: 10px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .portfolio-card-content h3 {
            margin-top: 7px;
            font-size: clamp(22px, 3vw, 31px);
        }

        .portfolio-card-content p {
            margin-top: 5px;
            color: #d2d6df;
            font-size: 12px;
        }

        .portfolio-arrow {
            position: absolute;
            z-index: 3;
            top: 18px;
            right: 18px;
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            color: white;
            border: 1px solid rgba(255,255,255,.5);
            border-radius: 50%;
            transition: background .2s, color .2s;
        }

        .portfolio-card:hover .portfolio-arrow {
            background: var(--green);
            color: #0b0e14;
        }

        /* ================= SERVICES ================= */

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 17px;
        }

        .service-card {
            padding: 30px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--bg);
            transition: transform .25s, border-color .25s;
        }

        .service-card:hover {
            transform: translateY(-5px);
            border-color: var(--green);
        }

        .service-icon {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            margin-bottom: 28px;
            color: var(--green);
            background: var(--surface-2);
            border-radius: 13px;
            font-size: 21px;
        }

        .service-card h3 {
            margin-bottom: 12px;
            font-size: 21px;
        }

        .service-card p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.9;
        }

        .service-link {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-top: 22px;
            color: var(--green);
            font-size: 12px;
            font-weight: 700;
        }

        /* ================= STORE ================= */

        .store-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .product-card {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--bg);
        }

        .product-image {
            position: relative;
            height: 270px;
            overflow: hidden;
            background: var(--surface-2);
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s;
        }

        .product-card:hover .product-image img {
            transform: scale(1.06);
        }

        .product-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 6px 10px;
            color: #081810;
            background: var(--green);
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .product-details {
            padding: 23px;
        }

        .product-details h3 {
            font-size: 20px;
        }

        .product-details p {
            min-height: 43px;
            margin-top: 9px;
            color: var(--muted);
            font-size: 12px;
        }

        .product-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .product-price {
            font-size: 18px;
            font-weight: 700;
        }

        .add-cart {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            color: white;
            background: var(--accent);
            border: 0;
            border-radius: 9px;
        }

        .add-cart:hover {
            background: var(--green);
            color: #081810;
        }

        /* ================= FEATURE BANNER ================= */

        .feature-banner {
            position: relative;
            overflow: hidden;
            padding: 65px;
            color: white;
            background: #171f30;
            border-radius: 22px;
        }

        .feature-banner::after {
            content: "";
            position: absolute;
            width: 360px;
            height: 360px;
            top: -180px;
            right: -80px;
            border: 1px solid rgba(88,214,163,.45);
            border-radius: 50%;
            box-shadow: 0 0 0 40px rgba(88,214,163,.04),
                        0 0 0 80px rgba(88,214,163,.03);
            pointer-events: none;
        }

        .feature-banner-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
        }

        .feature-banner h2 {
            margin-bottom: 17px;
        }

        .feature-banner p {
            max-width: 570px;
            color: #c5ccd9;
            font-size: 14px;
        }

        .feature-banner .btn {
            margin-top: 26px;
        }

        /* ================= EVENTS / JOBS ================= */

        .updates-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .update-panel {
            padding: 27px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--bg);
        }

        .update-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .update-panel-header h3 {
            font-size: 23px;
        }

        .update-panel-header a {
            color: var(--green);
            font-size: 11px;
            font-weight: 700;
        }

        .update-item {
            display: flex;
            align-items: flex-start;
            gap: 17px;
            padding: 22px 0;
            border-bottom: 1px solid var(--border);
        }

        .update-item:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .date-box {
            flex: 0 0 56px;
            padding: 10px 4px;
            text-align: center;
            background: var(--surface-2);
            border-radius: 9px;
        }

        .date-box strong {
            display: block;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 22px;
            line-height: 1.2;
        }

        .date-box span {
            color: var(--green);
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .update-copy {
            flex: 1;
        }

        .update-copy h4 {
            font-size: 16px;
        }

        .update-copy p {
            margin-top: 7px;
            color: var(--muted);
            font-size: 12px;
        }

        .update-copy a {
            display: inline-block;
            margin-top: 10px;
            color: var(--green);
            font-size: 11px;
            font-weight: 700;
        }

        .job-label {
            display: inline-block;
            margin-bottom: 7px;
            color: var(--green);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ================= CREATOR COMMUNITY ================= */

        .community-grid {
            display: grid;
            grid-template-columns: 1fr .9fr;
            gap: 60px;
            align-items: center;
        }

        .community-copy h2 {
            max-width: 570px;
        }

        .community-copy > p {
            max-width: 480px;
            margin-top: 20px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.9;
        }

        .community-benefits {
            display: grid;
            gap: 15px;
            margin-top: 30px;
        }

        .community-benefits li {
            display: flex;
            align-items: center;
            gap: 12px;
            list-style: none;
            font-size: 13px;
        }

        .community-benefits i {
            color: var(--green);
        }

        .community-form {
            padding: 30px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .community-form h3 {
            margin-bottom: 8px;
            font-size: 24px;
        }

        .community-form > p {
            margin-bottom: 23px;
            color: var(--muted);
            font-size: 12px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 11px;
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            min-height: 46px;
            padding: 12px 14px;
            color: var(--text);
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 7px;
            outline: none;
            font-size: 12px;
        }

        .form-control:focus {
            border-color: var(--accent);
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .form-control option {
            color: var(--text);
            background: var(--surface);
        }

        .form-note {
            margin-top: 12px;
            color: var(--muted);
            text-align: center;
            font-size: 10px;
        }

        .form-status {
            display: none;
            padding: 12px;
            margin-bottom: 15px;
            color: var(--text);
            background: var(--surface-2);
            border-radius: 7px;
            font-size: 12px;
        }

        /* ================= CONTACT ================= */

        .contact-grid {
            display: grid;
            grid-template-columns: .8fr 1fr;
            gap: 55px;
        }

        .contact-copy > p {
            margin-top: 17px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.9;
        }

        .contact-detail {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-top: 25px;
        }

        .contact-icon {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            color: var(--green);
            background: var(--surface-2);
            border-radius: 10px;
        }

        .contact-detail small {
            display: block;
            color: var(--muted);
            font-size: 10px;
        }

        .contact-detail strong {
            display: block;
            margin-top: 3px;
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .contact-form {
            padding: 27px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* ================= FOOTER ================= */

        .site-footer {
            padding: 55px 0 22px;
            background: var(--surface);
            border-top: 1px solid var(--border);
        }

        .footer-top {
            display: grid;
            grid-template-columns: 1.3fr .7fr .7fr;
            gap: 40px;
            padding-bottom: 40px;
        }

        .footer-brand img {
            width: 175px;
            height: 65px;
            object-fit: contain;
            object-position: left center;
        }

        .footer-brand p {
            max-width: 320px;
            margin-top: 15px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.9;
        }

        .social-links {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .social-links a {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border: 1px solid var(--border);
            border-radius: 50%;
            transition: background .2s, color .2s;
        }

        .social-links a:hover {
            color: #081810;
            background: var(--green);
        }

        .footer-column h4 {
            margin-bottom: 18px;
            font-size: 14px;
        }

        .footer-column a {
            display: block;
            margin-bottom: 12px;
            color: var(--muted);
            font-size: 12px;
        }

        .footer-column a:hover {
            color: var(--green);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 10px;
        }

        /* ================= CART DRAWER ================= */

        .cart-overlay {
            position: fixed;
            z-index: 1999;
            inset: 0;
            display: none;
            background: rgba(0,0,0,.6);
        }

        .cart-overlay.open {
            display: block;
        }

        .cart-drawer {
            position: fixed;
            z-index: 2000;
            top: 0;
            right: 0;
            width: min(410px, 100%);
            height: 100dvh;
            display: flex;
            flex-direction: column;
            padding: 25px;
            color: var(--text);
            background: var(--surface);
            box-shadow: var(--shadow);
            transform: translateX(105%);
            transition: transform .3s;
        }

        .cart-drawer.open {
            transform: translateX(0);
        }

        .cart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border);
        }

        .cart-header h3 {
            font-size: 22px;
        }

        .cart-close {
            width: 38px;
            height: 38px;
            color: var(--text);
            background: var(--surface-2);
            border: 0;
            border-radius: 50%;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 15px 0;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border);
        }

        .cart-item h4 {
            font-size: 13px;
        }

        .cart-item p {
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .cart-remove {
            margin-top: 7px;
            padding: 0;
            color: #ff8585;
            background: none;
            border: 0;
            font-size: 10px;
        }

        .cart-footer {
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 17px;
            font-weight: 700;
        }

        .cart-empty {
            padding: 45px 0;
            color: var(--muted);
            text-align: center;
            font-size: 13px;
        }

        /* ================= SCROLL ANIMATIONS ================= */

        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes backdropMove {
            from { transform: scale(1.04) translate3d(-.4%, 0, 0); }
            to { transform: scale(1.12) translate3d(.4%, -1%, 0); }
        }

        @keyframes imageBob {
            from { transform: translateY(0); }
            to { transform: translateY(-9px); }
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0) rotate(4deg); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }

        @keyframes revealUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 1050px) {
            .nav-links {
                gap: 15px;
            }

            .nav-links a {
                font-size: 11px;
            }

            .navbar > .nav-actions > .header-cta {
                display: none;
            }

            .hero-content {
                grid-template-columns: 1fr .85fr;
            }

            .hero h1 {
                font-size: clamp(52px, 6.4vw, 76px);
            }

            .hero-visual {
                min-height: 410px;
            }
        }

        @media (max-width: 820px) {
            .section {
                padding: 75px 0;
            }

            .menu-toggle {
                display: grid;
            }

            .nav-links {
                position: absolute;
                top: 78px;
                right: 0;
                left: 0;
                display: none;
                align-items: stretch;
                flex-direction: column;
                gap: 0;
                padding: 12px 24px 20px;
                background: var(--surface);
                border-bottom: 1px solid var(--border);
            }

            .nav-links.open {
                display: flex;
            }

            .nav-links a {
                padding: 13px 0;
                border-bottom: 1px solid var(--border);
                font-size: 13px;
            }

            .hero {
                min-height: auto;
            }

            .hero-content {
                grid-template-columns: 1fr;
                gap: 20px;
                padding-top: 65px;
                padding-bottom: 100px;
            }

            .hero-copy {
                max-width: 650px;
            }

            .hero h1 {
                font-size: clamp(56px, 10vw, 82px);
            }

            .hero-visual {
                width: min(100%, 580px);
                min-height: 420px;
                margin: 0 auto;
            }

            .portfolio-grid {
                grid-template-columns: 1fr 1fr;
            }

            .portfolio-card.large {
                grid-column: span 2;
                grid-row: auto;
                min-height: 420px;
            }

            .portfolio-card:not(.large) {
                min-height: 270px;
            }

            .services-grid,
            .store-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .community-grid {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .footer-top {
                grid-template-columns: 1fr 1fr;
            }

            .footer-brand {
                grid-column: span 2;
            }
        }

        @media (max-width: 560px) {
            .container {
                width: calc(100% - 32px);
            }

            .navbar {
                min-height: 70px;
                gap: 10px;
            }

            .brand img {
                width: 130px;
                height: 53px;
            }

            .nav-links {
                top: 70px;
            }

            .nav-actions {
                gap: 7px;
            }

            .theme-toggle,
            .menu-toggle,
            .cart-button {
                width: 37px;
                height: 37px;
            }

            .section {
                padding: 60px 0;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
                margin-bottom: 28px;
            }

            h2 {
                font-size: 35px;
                letter-spacing: -1.2px;
            }

            .hero-content {
                padding-top: 55px;
                padding-bottom: 95px;
            }

            .hero h1 {
                font-size: clamp(47px, 12.8vw, 68px);
                letter-spacing: -3px;
            }

            .hero-description {
                font-size: 13px;
            }

            .hero-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .hero-actions .btn {
                width: 100%;
            }

            .hero-meta {
                gap: 8px;
                margin-top: 32px;
                font-size: 8px;
            }

            .hero-visual {
                min-height: 320px;
            }

            .hero-main-image {
                inset: 18px 27px 28px 12px;
            }

            .hero-float-card {
                width: 125px;
            }

            .hero-float-card img {
                height: 90px;
            }

            .hero-label {
                font-size: 8px;
            }

            .hero-bottom-inner {
                min-height: 58px;
                gap: 8px;
                font-size: 8px;
            }

            .hero-bottom-inner > span {
                max-width: 85px;
            }

            .hero-bottom-inner > a {
                max-width: 120px;
                text-align: right;
            }

            .scene-btn {
                width: 29px;
                height: 27px;
            }

            .trust-inner {
                justify-content: flex-start;
                gap: 15px 23px;
            }

            .trust-inner span {
                font-size: 9px;
            }

            .portfolio-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .portfolio-card.large,
            .portfolio-card:not(.large) {
                grid-column: auto;
                min-height: 330px;
            }

            .services-grid,
            .store-grid,
            .updates-grid {
                grid-template-columns: 1fr;
            }

            .service-card {
                padding: 24px;
            }

            .product-image {
                height: 270px;
            }

            .feature-banner {
                padding: 35px 25px;
            }

            .update-panel {
                padding: 20px;
            }

            .community-form,
            .contact-form {
                padding: 22px 17px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .footer-top {
                grid-template-columns: 1fr 1fr;
                gap: 28px 18px;
            }

            .footer-brand {
                grid-column: span 2;
            }

            .footer-brand img {
                width: 155px;
            }

            .footer-bottom {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>

<body>

    {{-- ================= HEADER ================= --}}

    <header class="site-header">
        <div class="container navbar">

            <a href="#home" class="brand" aria-label="Rayda homepage">
                <img src="{{ asset('images/rayda-logo.png') }}"
                     alt="Rayda Global Agency"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">

                <span style="display:none;font-family:'Space Grotesk',sans-serif;font-size:22px;font-weight:700;">
                    RAYDA<span class="accent-text">.</span>
                </span>
            </a>

            <nav class="nav-links" id="navLinks">
                <a href="#home">Home</a>
                <a href="#portfolio">Portfolio</a>
                <a href="#services">Services</a>
                <a href="#store">Gadget Store</a>
                <a href="#events">Events</a>
                <a href="#jobs">Jobs</a>
                <a href="#community">Community</a>
            </nav>

            <div class="nav-actions">

                <button type="button" class="theme-toggle" id="themeToggle"
                        aria-label="Switch theme" title="Switch theme">
                    <i class="fa-solid fa-sun"></i>
                </button>

                <button type="button" class="cart-button" id="cartButton"
                        aria-label="Open shopping cart">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </button>

                <a href="#contact" class="btn btn-primary header-cta">
                    Let's Talk <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>

                <button type="button" class="menu-toggle" id="menuToggle"
                        aria-label="Toggle navigation" aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <main>

        {{-- ================= HERO ================= --}}

        {{-- Rayda Global Agency — Cinematic CTA Hero
     Save as resources/views/users/guests/themes/rayda/partials/hero.blade.php
     Include with @include('users.guests.themes.rayda.partials.hero')
     Replace demo image URLs and section anchors with your real assets/routes.
--}}
<section id="raydaHero" class="rh-hero" aria-label="Rayda Global Agency">
    <div class="rh-backdrop" aria-hidden="true">
        <div class="rh-slide is-active" data-slide="0" style="background-image:url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=2200&q=85')"></div>
        <div class="rh-slide" data-slide="1" style="background-image:url('https://images.unsplash.com/photo-1492684223066-1a?auto=format&fit=crop&w=2200&q=85')"></div>
        <div class="rh-slide" data-slide="2" style="background-image:url('https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=2200&q=85')"></div>
        <div class="rh-shade"></div><div class="rh-grain"></div>
    </div>
    <header class="rh-topbar">
        <a class="rh-brand" href="{{ url('/') }}" aria-label="Rayda Global Agency home"><span class="rh-brand-mark">R<span>•</span></span><span class="rh-brand-copy"><strong>RAYDA</strong><small>GLOBAL AGENCY</small></span></a>
        <nav class="rh-nav" aria-label="Main navigation"><a href="#raydaWork">Work</a><a href="#raydaServices">Services</a><a href="#raydaStore">Creator kits</a><a href="#raydaCommunity">Community</a></nav>
        <div class="rh-top-actions"><button class="rh-theme-toggle" type="button" aria-label="Toggle hero theme" title="Toggle theme"><i class="fa-solid fa-sun"></i></button><a class="rh-contact-link" href="#raydaContact">Let’s talk <i class="fa-solid fa-arrow-up-right-from-square"></i></a><button class="rh-menu-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false"><i class="fa-solid fa-bars"></i></button></div>
    </header>
    <div class="rh-content">
        <div class="rh-kicker"><span class="rh-kicker-line"></span><span id="rhKickerText">CREATIVE STRATEGY · DIGITAL STORIES</span><span class="rh-kicker-index">01 / 03</span></div>
        <div class="rh-copy"><p class="rh-eyebrow">IDEAS DESERVE TO MAKE AN IMPACT.</p><h1 id="rhTitle">Make your<br><em>next move</em><br>matter<span class="rh-period">.</span></h1><p id="rhDescription" class="rh-description">We turn bold ideas into brands, experiences and digital stories people remember.</p>
            <div class="rh-ctas"><a class="rh-btn rh-btn-primary" href="#raydaWork">Explore our work <span><i class="fa-solid fa-arrow-up-right"></i></span></a><a class="rh-btn rh-btn-secondary" href="#raydaServices">What we do <i class="fa-solid fa-arrow-right"></i></a></div>
            <div class="rh-proof"><span class="rh-proof-stars">✳ ✳ ✳</span><span>Strategy with purpose.<br><strong>Creative with impact.</strong></span></div>
        </div>
        <div class="rh-bottom">
            <div class="rh-slide-controls"><button type="button" class="rh-arrow rh-prev" aria-label="Previous slide"><i class="fa-solid fa-arrow-left"></i></button><button type="button" class="rh-arrow rh-next" aria-label="Next slide"><i class="fa-solid fa-arrow-right"></i></button><div class="rh-progress"><span></span></div><button type="button" class="rh-autoplay" aria-label="Pause slideshow"><i class="fa-solid fa-pause"></i></button></div>
            <div class="rh-thumbnails" aria-label="Choose a hero slide"><button class="rh-thumb is-active" type="button" data-go="0"><span class="rh-thumb-img" style="background-image:url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=240&q=70')"></span><span><small>01</small><strong>CREATE</strong></span></button><button class="rh-thumb" type="button" data-go="1"><span class="rh-thumb-img" style="background-image:url('https://images.unsplash.com/photo-1492684223066-1a?auto=format&fit=crop&w=240&q=70')"></span><span><small>02</small><strong>CONNECT</strong></span></button><button class="rh-thumb" type="button" data-go="2"><span class="rh-thumb-img" style="background-image:url('https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=240&q=70')"></span><span><small>03</small><strong>AMPLIFY</strong></span></button></div>
            <a class="rh-scroll" href="#raydaServices"><span class="rh-scroll-icon"><i></i></span><span>SCROLL TO DISCOVER</span></a>
        </div>
    </div>
</section>
<style>
#raydaHero{--lime:#c7f36b;position:relative;min-height:780px;height:min(900px,100svh);overflow:hidden;background:#11140f;color:#fff;font-family:inherit;isolation:isolate}#raydaHero *{box-sizing:border-box}#raydaHero a{color:inherit;text-decoration:none}#raydaHero button{font:inherit;color:inherit;cursor:pointer}#raydaHero .rh-backdrop,#raydaHero .rh-slide,#raydaHero .rh-shade,#raydaHero .rh-grain{position:absolute;inset:0}#raydaHero .rh-backdrop{z-index:-2;overflow:hidden}#raydaHero .rh-slide{background-size:cover;background-position:center;opacity:0;transform:scale(1.08);transition:opacity 1s ease,transform 7s ease}#raydaHero .rh-slide.is-active{opacity:1;transform:scale(1)}#raydaHero .rh-shade{background:linear-gradient(90deg,rgba(7,10,8,.88),rgba(7,10,8,.62) 42%,rgba(7,10,8,.12)),linear-gradient(0deg,rgba(7,10,8,.7),transparent 40%,rgba(7,10,8,.2))}#raydaHero .rh-grain{opacity:.1;pointer-events:none;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.24'/%3E%3C/svg%3E")}#raydaHero .rh-topbar{height:94px;padding:0 clamp(22px,5.2vw,84px);display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid rgba(255,255,255,.18);position:relative;z-index:3}#raydaHero .rh-brand{display:flex;align-items:center;gap:11px;letter-spacing:.08em}#raydaHero .rh-brand-mark{display:grid;place-items:center;width:42px;height:42px;border:1px solid var(--lime);border-radius:50%;font:800 24px Georgia,serif;color:var(--lime)}#raydaHero .rh-brand-mark span{font-size:10px}#raydaHero .rh-brand-copy{display:flex;flex-direction:column;gap:3px}#raydaHero .rh-brand-copy strong{font-size:15px;letter-spacing:.2em}#raydaHero .rh-brand-copy small{font-size:8px;letter-spacing:.23em;opacity:.7}#raydaHero .rh-nav{display:flex;gap:clamp(18px,3vw,48px)}#raydaHero .rh-nav a{font-size:12px;color:rgba(255,255,255,.8)}#raydaHero .rh-nav a:hover{color:var(--lime)}#raydaHero .rh-top-actions{display:flex;align-items:center;gap:20px}#raydaHero .rh-theme-toggle,#raydaHero .rh-menu-toggle{border:0;background:transparent;padding:9px}#raydaHero .rh-theme-toggle{color:var(--lime)}#raydaHero .rh-contact-link{font-size:12px;font-weight:650;display:flex;gap:12px}#raydaHero .rh-contact-link i{color:var(--lime)}#raydaHero .rh-menu-toggle{display:none}#raydaHero .rh-content{position:relative;min-height:calc(100% - 94px);padding:clamp(36px,5vh,64px) clamp(22px,8.2vw,132px) 32px;display:flex;flex-direction:column}#raydaHero .rh-kicker{display:flex;align-items:center;gap:12px;font-size:9px;letter-spacing:.2em;color:rgba(255,255,255,.8)}#raydaHero .rh-kicker-line{height:1px;width:29px;background:var(--lime)}#raydaHero .rh-kicker-index{margin-left:10px;color:var(--lime)}#raydaHero .rh-copy{margin:auto 0;max-width:730px;padding:30px 0 44px}#raydaHero .rh-eyebrow{font-size:10px;letter-spacing:.22em;font-weight:650;color:var(--lime);margin:0 0 22px}#raydaHero h1{font-size:clamp(58px,8.2vw,124px);line-height:.88;letter-spacing:-.075em;font-weight:650;margin:0}#raydaHero h1 em{font-family:Georgia,'Times New Roman',serif;font-weight:400;letter-spacing:-.085em;color:var(--lime)}#raydaHero .rh-period{color:var(--lime)}#raydaHero .rh-description{max-width:405px;margin:27px 0;color:rgba(255,255,255,.78);font-size:15px;line-height:1.7}#raydaHero .rh-ctas{display:flex;align-items:center;gap:24px;flex-wrap:wrap}#raydaHero .rh-btn{min-height:52px;display:inline-flex;align-items:center;justify-content:center;gap:24px;font-size:12px;font-weight:700;transition:transform .25s}#raydaHero .rh-btn:hover{transform:translateY(-3px)}#raydaHero .rh-btn-primary{padding:6px 7px 6px 22px;background:var(--lime);color:#151910}#raydaHero .rh-btn-primary>span{width:38px;height:38px;display:grid;place-items:center;background:#172015;color:var(--lime)}#raydaHero .rh-btn-secondary{gap:15px;border-bottom:1px solid rgba(255,255,255,.45);min-height:42px}#raydaHero .rh-btn-secondary i{color:var(--lime)}#raydaHero .rh-proof{display:flex;align-items:center;gap:15px;margin-top:32px;color:rgba(255,255,255,.7);font-size:10px;line-height:1.7}#raydaHero .rh-proof-stars{color:var(--lime);font-size:15px;letter-spacing:3px}#raydaHero .rh-proof strong{color:#fff}#raydaHero .rh-bottom{display:grid;grid-template-columns:1fr auto 1fr;align-items:end;gap:20px;margin-top:auto}#raydaHero .rh-slide-controls{display:flex;align-items:center;gap:9px}#raydaHero .rh-arrow{width:39px;height:39px;border:1px solid rgba(255,255,255,.3);background:rgba(0,0,0,.12);border-radius:50%}#raydaHero .rh-arrow:hover{background:var(--lime);border-color:var(--lime);color:#151910}#raydaHero .rh-progress{width:75px;height:2px;background:rgba(255,255,255,.25);margin:0 5px;overflow:hidden}#raydaHero .rh-progress span{display:block;width:0;height:100%;background:var(--lime)}#raydaHero .rh-progress span.is-running{animation:rhProgress 6s linear forwards}@keyframes rhProgress{to{width:100%}}#raydaHero .rh-autoplay{border:0;background:transparent;color:rgba(255,255,255,.8);font-size:11px;padding:8px}#raydaHero .rh-thumbnails{display:flex;gap:8px}#raydaHero .rh-thumb{display:flex;align-items:center;gap:9px;text-align:left;border:1px solid transparent;background:rgba(10,12,10,.3);padding:5px 10px 5px 5px;min-width:116px;opacity:.65}#raydaHero .rh-thumb.is-active{opacity:1;border-color:rgba(199,243,107,.8);background:rgba(10,12,10,.58)}#raydaHero .rh-thumb-img{width:40px;height:40px;background-size:cover;background-position:center;display:block}#raydaHero .rh-thumb span:last-child{display:flex;flex-direction:column;gap:4px}#raydaHero .rh-thumb small{font-size:8px;color:var(--lime)}#raydaHero .rh-thumb strong{font-size:9px;letter-spacing:.14em}#raydaHero .rh-scroll{justify-self:end;display:flex;align-items:center;gap:12px;font-size:8px;letter-spacing:.18em;color:rgba(255,255,255,.75)}#raydaHero .rh-scroll-icon{width:17px;height:27px;border:1px solid rgba(255,255,255,.55);border-radius:99px;display:flex;justify-content:center;padding-top:5px}#raydaHero .rh-scroll-icon i{width:2px;height:5px;background:var(--lime);border-radius:2px;animation:rhScroll 1.5s infinite}@keyframes rhScroll{to{transform:translateY(7px);opacity:0}}#raydaHero.rh-light{background:#e9e9df;color:#171b14}#raydaHero.rh-light .rh-shade{background:linear-gradient(90deg,rgba(245,246,236,.94),rgba(245,246,236,.78) 42%,rgba(245,246,236,.12)),linear-gradient(0deg,rgba(245,246,236,.5),transparent 40%)}#raydaHero.rh-light .rh-nav a,#raydaHero.rh-light .rh-description,#raydaHero.rh-light .rh-proof,#raydaHero.rh-light .rh-scroll{color:rgba(20,24,18,.8)}#raydaHero.rh-light .rh-proof strong{color:#171b14}#raydaHero.rh-light .rh-topbar{border-color:rgba(20,24,18,.2)}#raydaHero.rh-light .rh-arrow{color:#171b14;border-color:rgba(20,24,18,.3)}#raydaHero.rh-light .rh-btn-secondary{border-color:rgba(20,24,18,.4)}#raydaHero.rh-light .rh-thumb{color:#fff}#raydaHero .rh-mobile-open{display:flex!important}
@media(max-width:900px){#raydaHero .rh-topbar{padding:0 24px}#raydaHero .rh-nav{gap:16px}#raydaHero .rh-nav a{font-size:11px}#raydaHero .rh-content{padding-left:6vw;padding-right:6vw}#raydaHero .rh-bottom{grid-template-columns:1fr auto}#raydaHero .rh-thumbnails{display:none}#raydaHero .rh-scroll{grid-column:2;grid-row:1}}@media(max-width:640px){#raydaHero{height:auto;min-height:780px;height:100svh;max-height:950px}#raydaHero .rh-topbar{height:76px;padding:0 18px}#raydaHero .rh-brand-mark{width:36px;height:36px;font-size:21px}#raydaHero .rh-brand-copy strong{font-size:12px}#raydaHero .rh-brand-copy small{font-size:7px}#raydaHero .rh-nav{display:none;position:absolute;top:75px;left:0;right:0;background:#141811;padding:20px 24px;flex-direction:column;gap:18px}#raydaHero .rh-nav.rh-mobile-open{display:flex}#raydaHero .rh-top-actions{gap:8px}#raydaHero .rh-contact-link{font-size:11px}#raydaHero .rh-menu-toggle{display:block}#raydaHero .rh-content{min-height:calc(100% - 76px);padding:30px 22px 24px}#raydaHero .rh-kicker{font-size:8px;letter-spacing:.12em}#raydaHero .rh-copy{padding:28px 0 38px}#raydaHero h1{font-size:clamp(56px,15vw,88px)}#raydaHero .rh-description{max-width:330px;font-size:14px;margin:22px 0}#raydaHero .rh-proof{margin-top:27px}#raydaHero .rh-bottom{grid-template-columns:1fr;gap:18px}#raydaHero .rh-scroll{display:none}#raydaHero .rh-shade{background:linear-gradient(90deg,rgba(7,10,8,.84),rgba(7,10,8,.36)),linear-gradient(0deg,rgba(7,10,8,.75),transparent 60%)}#raydaHero.rh-light .rh-shade{background:linear-gradient(90deg,rgba(245,246,236,.94),rgba(245,246,236,.55)),linear-gradient(0deg,rgba(245,246,236,.65),transparent 60%)}}
@media(prefers-reduced-motion:reduce){#raydaHero *,#raydaHero *:before,#raydaHero *:after{animation-duration:.01ms!important;transition-duration:.01ms!important}}
</style>
<script>
(function(){
    const root=document.getElementById('raydaHero'); if(!root || root.dataset.ready==='1') return; root.dataset.ready='1';
    const slides=[...root.querySelectorAll('.rh-slide')], thumbs=[...root.querySelectorAll('.rh-thumb')], title=root.querySelector('#rhTitle'), desc=root.querySelector('#rhDescription'), kicker=root.querySelector('#rhKickerText'), index=root.querySelector('.rh-kicker-index'), progress=root.querySelector('.rh-progress span'), playBtn=root.querySelector('.rh-autoplay');
    const content=[
        {kicker:'CREATIVE STRATEGY · DIGITAL STORIES',title:'Make your<br><em>next move</em><br>matter<span class="rh-period">.</span>',desc:'We turn bold ideas into brands, experiences and digital stories people remember.'},
        {kicker:'EVENTS · CULTURE · CONNECTION',title:'Bring people<br><em>closer</em><br>together<span class="rh-period">.</span>',desc:'We create meaningful experiences that connect communities, spark conversation and make moments matter.'},
        {kicker:'CONTENT · IDENTITY · IMPACT',title:'Be seen.<br><em>Be heard.</em><br>Be felt<span class="rh-period">.</span>',desc:'From brand storytelling to creator tools, we help ambitious ideas find their audience and grow.'}
    ];
    let active=0,paused=false,timer=null;
    function resetProgress(){progress.classList.remove('is-running'); void progress.offsetWidth; if(!paused) progress.classList.add('is-running');}
    function show(n){active=(n+slides.length)%slides.length;slides.forEach((s,i)=>s.classList.toggle('is-active',i===active));thumbs.forEach((b,i)=>{b.classList.toggle('is-active',i===active);b.setAttribute('aria-pressed',i===active?'true':'false')});const c=content[active];kicker.textContent=c.kicker;title.innerHTML=c.title;desc.textContent=c.desc;index.textContent=String(active+1).padStart(2,'0')+' / 03';resetProgress();restartTimer();}
    function restartTimer(){if(timer) clearInterval(timer);if(!paused) timer=setInterval(()=>show(active+1),6000);}
    root.querySelector('.rh-prev').addEventListener('click',()=>show(active-1));root.querySelector('.rh-next').addEventListener('click',()=>show(active+1));thumbs.forEach((b)=>b.addEventListener('click',()=>show(Number(b.dataset.go))));
    playBtn.addEventListener('click',()=>{paused=!paused;playBtn.innerHTML=paused?'<i class="fa-solid fa-play"></i>':'<i class="fa-solid fa-pause"></i>';playBtn.setAttribute('aria-label',paused?'Play slideshow':'Pause slideshow');if(paused){clearInterval(timer);progress.classList.remove('is-running')}else{resetProgress();restartTimer()}});
    root.querySelector('.rh-theme-toggle').addEventListener('click',()=>{root.classList.toggle('rh-light');const icon=root.querySelector('.rh-theme-toggle i');icon.className=root.classList.contains('rh-light')?'fa-solid fa-moon':'fa-solid fa-sun'});
    const menu=root.querySelector('.rh-menu-toggle'),nav=root.querySelector('.rh-nav');menu.addEventListener('click',()=>{const open=nav.classList.toggle('rh-mobile-open');menu.setAttribute('aria-expanded',open?'true':'false');menu.innerHTML=open?'<i class="fa-solid fa-xmark"></i>':'<i class="fa-solid fa-bars"></i>'});nav.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{nav.classList.remove('rh-mobile-open');menu.setAttribute('aria-expanded','false')}));
    root.addEventListener('mouseenter',()=>{if(!paused){clearInterval(timer);progress.classList.remove('is-running')}});root.addEventListener('mouseleave',()=>{if(!paused){resetProgress();restartTimer()}});show(0);
})();
</script>


        {{-- ================= BRAND STRIP ================= --}}

        <section class="trust-strip">
            <div class="container trust-inner">
                <span>OUR CREATIVE WORLD</span>
                <span class="trust-brand">01. FILM & VIDEO</span>
                <span class="trust-brand">02. PHOTOGRAPHY</span>
                <span class="trust-brand">03. LIVE EXPERIENCES</span>
                <span class="trust-brand">04. CREATOR TOOLS</span>
            </div>
        </section>

        {{-- ================= PORTFOLIO ================= --}}

        <section class="section" id="portfolio">
            <div class="container">

                <div class="section-heading reveal">
                    <div>
                        <span class="eyebrow">Selected Work</span>
                        <h2>Ideas brought<br>to <span class="accent-text">life.</span></h2>
                    </div>

                    <p>
                        Every frame, every moment and every story is an
                        opportunity to create something worth remembering.
                    </p>
                </div>

                <div class="portfolio-grid">

                    <a href="#contact" class="portfolio-card large reveal">
                        <img src="https://images.unsplash.com/photo-1492619375914-88005aa9e8fb?auto=format&fit=crop&w=1200&q=85"
                             alt="Film and video production" loading="lazy">

                        <span class="portfolio-arrow">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </span>

                        <div class="portfolio-card-content">
                            <span>Film & Video</span>
                            <h3>Stories that move people.</h3>
                            <p>Creative direction, video production and visual storytelling.</p>
                        </div>
                    </a>

                    <a href="#contact" class="portfolio-card reveal">
                        <img src="https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=900&q=85"
                             alt="Photography and visual storytelling" loading="lazy">

                        <span class="portfolio-arrow">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </span>

                        <div class="portfolio-card-content">
                            <span>Photography</span>
                            <h3>Capture the feeling.</h3>
                            <p>Portraits, campaigns and brand imagery.</p>
                        </div>
                    </a>

                    <a href="#events" class="portfolio-card reveal">
                        <img src="https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=900&q=85"
                             alt="Live event production" loading="lazy">

                        <span class="portfolio-arrow">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </span>

                        <div class="portfolio-card-content">
                            <span>Events & Experiences</span>
                            <h3>Make moments matter.</h3>
                            <p>Event coverage, live experiences and creative activations.</p>
                        </div>
                    </a>

                </div>

                <div style="margin-top:30px;" class="reveal">
                    <a href="#contact" class="btn btn-outline">
                        Work With Rayda <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        </section>

        {{-- ================= SERVICES ================= --}}

        <section class="section section-soft" id="services">
            <div class="container">

                <div class="section-heading reveal">
                    <div>
                        <span class="eyebrow">What We Do</span>
                        <h2>Creative thinking.<br><span class="accent-text">Real impact.</span></h2>
                    </div>

                    <p>
                        From the first idea to the final delivery, we help
                        brands and individuals communicate with purpose.
                    </p>
                </div>

                <div class="services-grid">

                    <article class="service-card reveal">
                        <div class="service-icon">
                            <i class="fa-solid fa-video"></i>
                        </div>

                        <h3>Video Production</h3>

                        <p>
                            Brand films, promotional videos, interviews,
                            documentaries, reels and social media content.
                        </p>

                        <a href="#contact" class="service-link">
                            Book a production <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon">
                            <i class="fa-solid fa-camera"></i>
                        </div>

                        <h3>Photography</h3>

                        <p>
                            Professional portraits, product photography,
                            campaign visuals, events and lifestyle shoots.
                        </p>

                        <a href="#contact" class="service-link">
                            Book a photoshoot <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon">
                            <i class="fa-solid fa-calendar-star"></i>
                        </div>

                        <h3>Events & Coverage</h3>

                        <p>
                            Event media, live coverage, creative activations,
                            behind-the-scenes content and highlight films.
                        </p>

                        <a href="#contact" class="service-link">
                            Plan your event <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon">
                            <i class="fa-solid fa-pen-nib"></i>
                        </div>

                        <h3>Creative Direction</h3>

                        <p>
                            Campaign concepts, visual identities, content
                            planning and storytelling for growing brands.
                        </p>

                        <a href="#contact" class="service-link">
                            Discuss your idea <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon">
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>

                        <h3>Social Media Content</h3>

                        <p>
                            Short-form video, creator-led campaigns,
                            digital content and platform-ready visuals.
                        </p>

                        <a href="#contact" class="service-link">
                            Grow your content <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <h3>Creator Development</h3>

                        <p>
                            Creator resources, equipment guidance, community
                            connections and opportunities to build your craft.
                        </p>

                        <a href="#community" class="service-link">
                            Join the community <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </article>

                </div>
            </div>
        </section>

        {{-- ================= GADGET STORE ================= --}}

        <section class="section" id="store">
            <div class="container">

                <div class="section-heading reveal">
                    <div>
                        <span class="eyebrow">The Creator Store</span>
                        <h2>Your next idea<br>needs the <span class="accent-text">right tools.</span></h2>
                    </div>

                    <p>
                        Discover creator equipment designed to help you
                        capture, produce and share your ideas.
                    </p>
                </div>

                <div class="store-grid">

                    <article class="product-card reveal">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&w=800&q=85"
                                 alt="Creator camera equipment" loading="lazy">
                            <span class="product-tag">CREATOR ESSENTIAL</span>
                        </div>

                        <div class="product-details">
                            <h3>Rayda Creator Kit</h3>
                            <p>A starter equipment bundle for creators ready to make their first professional content.</p>

                            <div class="product-bottom">
                                <span class="product-price">₦<span class="price-value">0</span></span>

                                <button type="button" class="add-cart"
                                        data-id="creator-kit"
                                        data-name="Rayda Creator Kit"
                                        data-price="0"
                                        aria-label="Add Rayda Creator Kit to cart">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                    <article class="product-card reveal">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1593305841991-05c297ba4575?auto=format&fit=crop&w=800&q=85"
                                 alt="Creator audio and video accessories" loading="lazy">
                            <span class="product-tag">AUDIO & VIDEO</span>
                        </div>

                        <div class="product-details">
                            <h3>Content Creation Kit</h3>
                            <p>Build your production setup with practical accessories for content creation.</p>

                            <div class="product-bottom">
                                <span class="product-price">₦<span class="price-value">0</span></span>

                                <button type="button" class="add-cart"
                                        data-id="content-kit"
                                        data-name="Content Creation Kit"
                                        data-price="0"
                                        aria-label="Add Content Creation Kit to cart">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                    <article class="product-card reveal">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=800&q=85"
                                 alt="Camera gear for professional creators" loading="lazy">
                            <span class="product-tag">UPGRADE YOUR SETUP</span>
                        </div>

                        <div class="product-details">
                            <h3>Creator Pro Bundle</h3>
                            <p>A flexible bundle concept for creators who want to take their production further.</p>

                            <div class="product-bottom">
                                <span class="product-price">₦<span class="price-value">0</span></span>

                                <button type="button" class="add-cart"
                                        data-id="creator-pro"
                                        data-name="Creator Pro Bundle"
                                        data-price="0"
                                        aria-label="Add Creator Pro Bundle to cart">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                </div>

                <p class="text-muted" style="margin-top:18px;font-size:11px;">
                    Product prices and specifications are placeholders. Replace them with your actual products before enabling checkout.
                </p>

            </div>
        </section>

        {{-- ================= CREATOR CAMPAIGN ================= --}}

        <section class="section section-soft">
            <div class="container">
                <div class="feature-banner reveal">
                    <div class="feature-banner-content">
                        <span class="eyebrow">For the Next Generation</span>

                        <h2>Don't just watch<br>the story. <span class="accent-text">Create it.</span></h2>

                        <p>
                            Rayda connects creators with tools, ideas, creative
                            experiences and opportunities to turn their passion
                            into meaningful work.
                        </p>

                        <a href="#community" class="btn btn-green">
                            Become Part of Rayda
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= EVENTS ================= --}}

        <section class="section" id="events">
            <div class="container">

                <div class="section-heading reveal">
                    <div>
                        <span class="eyebrow">Stay Connected</span>
                        <h2>What's happening<br>in our <span class="accent-text">world.</span></h2>
                    </div>

                    <p>
                        Discover upcoming events, creator meetups, workshops
                        and experiences worth being part of.
                    </p>
                </div>

                <div class="updates-grid">

                    <div class="update-panel reveal">
                        <div class="update-panel-header">
                            <h3>Upcoming Events</h3>
                            <a href="#contact">All events <i class="fa-solid fa-arrow-right"></i></a>
                        </div>

                        <article class="update-item">
                            <div class="date-box">
                                <strong>--</strong>
                                <span>Date</span>
                            </div>

                            <div class="update-copy">
                                <span class="job-label">Creator Community</span>
                                <h4>Creator Meetups & Networking</h4>
                                <p>Connect with other creators, share ideas and explore collaborations.</p>
                                <a href="#community">Get event updates <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>

                        <article class="update-item">
                            <div class="date-box">
                                <strong>--</strong>
                                <span>Date</span>
                            </div>

                            <div class="update-copy">
                                <span class="job-label">Learning</span>
                                <h4>Media & Content Workshops</h4>
                                <p>Practical learning experiences for people looking to develop creative skills.</p>
                                <a href="#community">Join the mailing list <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>

                    {{-- ================= JOBS ================= --}}

                    <div class="update-panel" id="jobs">
                        <div class="update-panel-header">
                            <h3>Creator Opportunities</h3>
                            <a href="#community">Get updates <i class="fa-solid fa-arrow-right"></i></a>
                        </div>

                        <article class="update-item">
                            <div class="date-box">
                                <strong><i class="fa-solid fa-video"></i></strong>
                                <span>Gig</span>
                            </div>

                            <div class="update-copy">
                                <span class="job-label">Video & Production</span>
                                <h4>Freelance Videographers</h4>
                                <p>Opportunities for skilled visual storytellers to collaborate on media projects.</p>
                                <a href="#contact">Express interest <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>

                        <article class="update-item">
                            <div class="date-box">
                                <strong><i class="fa-solid fa-camera"></i></strong>
                                <span>Gig</span>
                            </div>

                            <div class="update-copy">
                                <span class="job-label">Photography</span>
                                <h4>Photographers & Content Creators</h4>
                                <p>Creative collaboration opportunities for photographers and digital creators.</p>
                                <a href="#contact">Express interest <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>

                    </div>
                </div>
            </div>
        </section>

        {{-- ================= COMMUNITY FORM ================= --}}

        <section class="section section-soft" id="community">
            <div class="container community-grid">

                <div class="community-copy reveal">
                    <span class="eyebrow">The Rayda Creator Community</span>

                    <h2>Good things happen when <span class="accent-text">creators connect.</span></h2>

                    <p>
                        Join our growing creator community to hear about events,
                        creative opportunities, equipment launches, workshops
                        and future community initiatives.
                    </p>

                    <ul class="community-benefits">
                        <li><i class="fa-solid fa-circle-check"></i> Creator opportunities and gigs</li>
                        <li><i class="fa-solid fa-circle-check"></i> Events, workshops and meetups</li>
                        <li><i class="fa-solid fa-circle-check"></i> New gear and creator resources</li>
                        <li><i class="fa-solid fa-circle-check"></i> A network of people making things happen</li>
                    </ul>
                </div>

                <div class="community-form reveal">
                    <h3>Join the community.</h3>
                    <p>Leave your details and stay in the loop.</p>

                    <div class="form-status" id="communityStatus" role="status"></div>

                    {{-- Connect this form to your Laravel POST route. --}}
                    <form id="communityForm" method="POST" action="#">
                        @csrf

                        <div class="form-group">
                            <label for="communityName">Full name</label>
                            <input type="text" class="form-control"
                                   id="communityName" name="name"
                                   placeholder="Your name" required>
                        </div>

                        <div class="form-group">
                            <label for="communityEmail">Email address</label>
                            <input type="email" class="form-control"
                                   id="communityEmail" name="email"
                                   placeholder="you@example.com" required>
                        </div>

                        <div class="form-group">
                            <label for="communityPhone">Phone number</label>
                            <input type="tel" class="form-control"
                                   id="communityPhone" name="phone"
                                   placeholder="Your phone number">
                        </div>

                        <div class="form-group">
                            <label for="creatorType">What do you create?</label>
                            <select class="form-control" id="creatorType"
                                    name="creator_type" required>
                                <option value="">Choose your creator type</option>
                                <option value="videographer">Videographer / Filmmaker</option>
                                <option value="photographer">Photographer</option>
                                <option value="content_creator">Content Creator</option>
                                <option value="designer">Designer</option>
                                <option value="influencer">Influencer</option>
                                <option value="musician">Musician / Artist</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary full-width">
                            Join the Community
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        <p class="form-note">
                            By joining, you agree to receive relevant Rayda updates.
                        </p>
                    </form>
                </div>

            </div>
        </section>

        {{-- ================= CONTACT ================= --}}

        <section class="section" id="contact">
            <div class="container contact-grid">

                <div class="contact-copy reveal">
                    <span class="eyebrow">Let's Work Together</span>

                    <h2>Have an idea?<br><span class="accent-text">Let's make it real.</span></h2>

                    <p>
                        Tell us what you are planning. Whether it is a brand
                        campaign, a production, an event or a collaboration,
                        we'd love to hear from you.
                    </p>

                    <div class="contact-detail">
                        <div class="contact-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                        <div>
                            <small>Email us</small>
                            <strong>hello@rayda.com</strong>
                        </div>
                    </div>

                    <div class="contact-detail">
                        <div class="contact-icon">
                            <i class="fa-solid fa-video"></i>
                        </div>

                        <div>
                            <small>Creative services</small>
                            <strong>Production, photography & events</strong>
                        </div>
                    </div>

                    <div class="contact-detail">
                        <div class="contact-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>

                        <div>
                            <small>Creator community</small>
                            <strong>Opportunities, resources & connections</strong>
                        </div>
                    </div>
                </div>

                <div class="contact-form reveal">
                    <div class="form-status" id="contactStatus" role="status"></div>

                    {{-- Connect this form to your Laravel POST route. --}}
                    <form id="contactForm" method="POST" action="#">
                        @csrf

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contactName">Your name</label>
                                <input class="form-control" id="contactName"
                                       name="name" type="text"
                                       placeholder="Full name" required>
                            </div>

                            <div class="form-group">
                                <label for="contactEmail">Email address</label>
                                <input class="form-control" id="contactEmail"
                                       name="email" type="email"
                                       placeholder="Email address" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contactService">What do you need?</label>
                            <select class="form-control" id="contactService"
                                    name="service" required>
                                <option value="">Select a service</option>
                                <option value="video">Video production</option>
                                <option value="photography">Photography</option>
                                <option value="event">Event coverage</option>
                                <option value="creative">Creative direction</option>
                                <option value="social">Social media content</option>
                                <option value="collaboration">Collaboration</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="contactMessage">Tell us about your project</label>
                            <textarea class="form-control" id="contactMessage"
                                      name="message"
                                      placeholder="Share a few details about your idea..."
                                      required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary full-width">
                            Send Enquiry <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>
                </div>

            </div>
        </section>

    </main>

    {{-- ================= FOOTER ================= --}}

    <footer class="site-footer">
        <div class="container">

            <div class="footer-top">

                <div class="footer-brand">
                    <a href="#home">
                        <img src="{{ asset('images/rayda-logo.png') }}"
                             alt="Rayda Global Agency"
                             loading="lazy"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">

                        <strong style="display:none;font-size:23px;">
                            RAYDA<span class="accent-text">.</span>
                        </strong>
                    </a>

                    <p>
                        Turning ideas into impact through creative production,
                        media services, creator tools and community.
                    </p>

                    <div class="social-links">
                        {{-- Replace # with your real social profile URLs. --}}
                        <a href="#" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h4>Explore</h4>
                    <a href="#portfolio">Our Portfolio</a>
                    <a href="#services">Services</a>
                    <a href="#store">Creator Store</a>
                    <a href="#events">Events</a>
                    <a href="#jobs">Creator Opportunities</a>
                </div>

                <div class="footer-column">
                    <h4>Get Involved</h4>
                    <a href="#community">Join the Community</a>
                    <a href="#contact">Book a Service</a>
                    <a href="#contact">Partner With Us</a>
                    <a href="#contact">Contact Rayda</a>
                </div>

            </div>

            <div class="footer-bottom">
                <span>&copy; <span id="currentYear"></span> Rayda Global Agency. All rights reserved.</span>
                <span>Turning Ideas into Impact.</span>
            </div>

        </div>
    </footer>

    {{-- ================= SHOPPING CART DRAWER ================= --}}

    <div class="cart-overlay" id="cartOverlay"></div>

    <aside class="cart-drawer" id="cartDrawer"
           aria-label="Shopping cart" aria-hidden="true">

        <div class="cart-header">
            <h3>Your bag</h3>
            <button type="button" class="cart-close" id="cartClose"
                    aria-label="Close cart">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="cart-empty">Your bag is empty.</div>
        </div>

        <div class="cart-footer">
            <div class="cart-total">
                <span>Subtotal</span>
                <span id="cartTotal">₦0</span>
            </div>

            <button type="button" class="btn btn-primary full-width"
                    id="checkoutButton">
                Continue to Checkout <i class="fa-solid fa-arrow-right"></i>
            </button>

            <p class="form-note">
                Checkout and payment are not connected yet.
            </p>
        </div>
    </aside>

    {{-- ================= JAVASCRIPT ================= --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ---------------- THEME SWITCH ---------------- */

            const root = document.documentElement;
            const themeToggle = document.getElementById('themeToggle');

            function setTheme(theme) {
                root.dataset.theme = theme;

                themeToggle.innerHTML = theme === 'light'
                    ? '<i class="fa-solid fa-moon"></i>'
                    : '<i class="fa-solid fa-sun"></i>';

                themeToggle.setAttribute(
                    'aria-label',
                    theme === 'light'
                        ? 'Switch to dark theme'
                        : 'Switch to light theme'
                );

                try {
                    localStorage.setItem('rayda-theme', theme);
                } catch (error) {
                    // The theme still works without local storage.
                }
            }

            let savedTheme = null;

            try {
                savedTheme = localStorage.getItem('rayda-theme');
            } catch (error) {}

            setTheme(
                savedTheme ||
                (window.matchMedia('(prefers-color-scheme: light)').matches
                    ? 'light'
                    : 'dark')
            );

            themeToggle.addEventListener('click', function () {
                setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark');
            });


            /* ---------------- MOBILE NAVIGATION ---------------- */

            const menuToggle = document.getElementById('menuToggle');
            const navLinks = document.getElementById('navLinks');

            menuToggle.addEventListener('click', function () {
                const isOpen = navLinks.classList.toggle('open');

                menuToggle.setAttribute('aria-expanded', String(isOpen));

                menuToggle.innerHTML = isOpen
                    ? '<i class="fa-solid fa-xmark"></i>'
                    : '<i class="fa-solid fa-bars"></i>';
            });

            navLinks.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    navLinks.classList.remove('open');
                    menuToggle.setAttribute('aria-expanded', 'false');
                    menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
                });
            });


            /* ---------------- CINEMATIC HERO ---------------- */

            const scenes = [
                {
                    main: 'https://images.unsplash.com/photo-1492619375914-88005aa9e8fb?auto=format&fit=crop&w=1100&q=85',
                    floating: 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=500&q=80',
                    caption: 'Stories in motion',
                    label: 'CREATIVE PRODUCTION',
                    background: 'https://images.unsplash.com/photo-1492619375914-88005aa9e8fb?auto=format&fit=crop&w=2200&q=85'
                },
                {
                    main: 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=1100&q=85',
                    floating: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=500&q=80',
                    caption: 'Every frame tells a story',
                    label: 'PHOTOGRAPHY & VISUALS',
                    background: 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=2200&q=85'
                },
                {
                    main: 'https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=1100&q=85',
                    floating: 'https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=500&q=80',
                    caption: 'Make moments matter',
                    label: 'EVENTS & EXPERIENCES',
                    background: 'https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=2200&q=85'
                }
            ];

            const mainImage = document.getElementById('heroMainImage');
            const floatImage = document.getElementById('heroFloatImage');
            const heroCaption = document.getElementById('heroImageCaption');
            const heroLabel = document.getElementById('heroProjectLabel');
            const heroNumber = document.getElementById('heroSceneNumber');
            const heroBackdrop = document.getElementById('heroBackdrop');
            const sceneButtons = document.querySelectorAll('.scene-btn');

            function changeScene(index) {
                const scene = scenes[index];

                if (!scene) return;

                sceneButtons.forEach(function (button, buttonIndex) {
                    button.classList.toggle('active', buttonIndex === index);
                });

                mainImage.style.opacity = '0';
                floatImage.style.opacity = '0';

                const mainPreload = new Image();
                const floatPreload = new Image();

                mainPreload.onload = function () {
                    mainImage.src = scene.main;
                    mainImage.style.opacity = '1';
                };

                mainPreload.onerror = function () {
                    mainImage.style.opacity = '1';
                };

                floatPreload.onload = function () {
                    floatImage.src = scene.floating;
                    floatImage.style.opacity = '1';
                };

                floatPreload.onerror = function () {
                    floatImage.style.opacity = '1';
                };

                mainPreload.src = scene.main;
                floatPreload.src = scene.floating;

                heroCaption.textContent = scene.caption;
                heroLabel.textContent = scene.label;
                heroNumber.textContent = '0' + (index + 1) + ' / 03';

                heroBackdrop.style.backgroundImage =
                    'url("' + scene.background + '")';
            }

            sceneButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    changeScene(Number(button.dataset.scene));
                });
            });


            /* ---------------- SUBTLE POINTER DEPTH ---------------- */

            const heroVisual = document.getElementById('heroVisual');
            const heroFloat = document.getElementById('heroFloat');
            const reduceMotion = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            );

            if (
                window.matchMedia('(pointer: fine)').matches &&
                !reduceMotion.matches
            ) {
                heroVisual.addEventListener('pointermove', function (event) {
                    const rect = heroVisual.getBoundingClientRect();

                    const x = (event.clientX - rect.left) / rect.width - .5;
                    const y = (event.clientY - rect.top) / rect.height - .5;

                    heroFloat.style.marginLeft = (x * 10) + 'px';
                    heroFloat.style.marginTop = (y * 10) + 'px';
                });

                heroVisual.addEventListener('pointerleave', function () {
                    heroFloat.style.marginLeft = '0';
                    heroFloat.style.marginTop = '0';
                });
            }


            /* ---------------- SCROLL REVEAL ---------------- */

            const revealElements = document.querySelectorAll('.reveal');

            if ('IntersectionObserver' in window && !reduceMotion.matches) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.12
                });

                revealElements.forEach(function (element) {
                    observer.observe(element);
                });
            } else {
                revealElements.forEach(function (element) {
                    element.classList.add('visible');
                });
            }


            /* ---------------- SHOPPING CART DEMO ---------------- */

            const cart = [];

            const cartButton = document.getElementById('cartButton');
            const cartDrawer = document.getElementById('cartDrawer');
            const cartOverlay = document.getElementById('cartOverlay');
            const cartClose = document.getElementById('cartClose');
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const cartTotal = document.getElementById('cartTotal');
            const checkoutButton = document.getElementById('checkoutButton');

            function formatNaira(amount) {
                return '₦' + Number(amount).toLocaleString('en-NG');
            }

            function openCart() {
                cartDrawer.classList.add('open');
                cartOverlay.classList.add('open');
                cartDrawer.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            function closeCart() {
                cartDrawer.classList.remove('open');
                cartOverlay.classList.remove('open');
                cartDrawer.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }

            function renderCart() {
                const quantity = cart.reduce(function (total, item) {
                    return total + item.quantity;
                }, 0);

                const total = cart.reduce(function (sum, item) {
                    return sum + item.price * item.quantity;
                }, 0);

                cartCount.textContent = quantity;
                cartTotal.textContent = formatNaira(total);

                if (cart.length === 0) {
                    cartItems.innerHTML =
                        '<div class="cart-empty">Your bag is empty.</div>';
                    return;
                }

                cartItems.innerHTML = cart.map(function (item) {
                    return `
                        <div class="cart-item">
                            <div>
                                <h4>${escapeHTML(item.name)}</h4>
                                <p>${formatNaira(item.price)} × ${item.quantity}</p>
                                <button class="cart-remove" type="button"
                                    data-remove="${escapeHTML(item.id)}">
                                    Remove
                                </button>
                            </div>
                            <strong>${formatNaira(item.price * item.quantity)}</strong>
                        </div>
                    `;
                }).join('');
            }

            function escapeHTML(value) {
                return String(value).replace(/[&<>"']/g, function (char) {
                    return {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#039;'
                    }[char];
                });
            }

            document.querySelectorAll('.add-cart').forEach(function (button) {
                button.addEventListener('click', function () {
                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const price = Number(button.dataset.price);

                    if (!price || price < 0) {
                        alert('This demo product has no price yet. Set its real price before adding it to the cart.');
                        return;
                    }

                    const existing = cart.find(function (item) {
                        return item.id === id;
                    });

                    if (existing) {
                        existing.quantity++;
                    } else {
                        cart.push({
                            id: id,
                            name: name,
                            price: price,
                            quantity: 1
                        });
                    }

                    renderCart();
                    openCart();
                });
            });

            cartItems.addEventListener('click', function (event) {
                const button = event.target.closest('[data-remove]');

                if (!button) return;

                const index = cart.findIndex(function (item) {
                    return item.id === button.dataset.remove;
                });

                if (index !== -1) {
                    cart.splice(index, 1);
                    renderCart();
                }
            });

            cartButton.addEventListener('click', openCart);
            cartClose.addEventListener('click', closeCart);
            cartOverlay.addEventListener('click', closeCart);

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeCart();
                }
            });

            checkoutButton.addEventListener('click', function () {
                alert('Checkout is not connected yet. Connect this button to your Laravel checkout route and payment gateway.');
            });


            /* ---------------- FORMS ---------------- */

            function showFormStatus(element, message) {
                element.textContent = message;
                element.style.display = 'block';
            }

            document.getElementById('communityForm').addEventListener(
                'submit',
                function (event) {
                    event.preventDefault();

                    showFormStatus(
                        document.getElementById('communityStatus'),
                        'The form UI is ready. Connect it to a Laravel route to save registrations.'
                    );
                }
            );

            document.getElementById('contactForm').addEventListener(
                'submit',
                function (event) {
                    event.preventDefault();

                    showFormStatus(
                        document.getElementById('contactStatus'),
                        'The form UI is ready. Connect it to a Laravel route to submit enquiries.'
                    );
                }
            );


            /* ---------------- FOOTER YEAR ---------------- */

            document.getElementById('currentYear').textContent =
                new Date().getFullYear();

            renderCart();

        });
    </script>

</body>
</html>
