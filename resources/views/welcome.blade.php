<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rayda Global Agency | Turning Ideas into Impact</title>
    <meta name="description" content="Rayda Global Agency delivers creative media production, photography, video, events, creator gadgets and opportunities for creators.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --bg: #0b0e14;
            --surface: #131822;
            --surface-2: #1b2230;
            --text: #f7f8fc;
            --muted: #a5adbc;
            --accent: #667dff;
            --green: #58d6a3;
            --lime: #c7f36b;
            --border: rgba(255,255,255,.11);
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
            --shadow: 0 18px 55px rgba(20,32,59,.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; scroll-padding-top: 90px; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.65;
            overflow-x: hidden;
        }

        a { color: inherit; text-decoration: none; }
        button, input, textarea, select { font: inherit; }
        button { cursor: pointer; }
        img { display: block; max-width: 100%; }

        .container {
            width: min(var(--container), calc(100% - 48px));
            margin-inline: auto;
        }

        .section { padding: 100px 0; }
        .section-soft { background: var(--surface); }

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

        .text-muted { color: var(--muted); }
        .accent-text { color: var(--green); }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 47px;
            padding: 12px 20px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            transition: transform .2s, background .2s, border-color .2s;
        }

        .btn:hover { transform: translateY(-2px); }

        .btn-primary { color: #fff; background: var(--accent); }
        .btn-primary:hover { background: #5068ef; }

        .btn-outline {
            border-color: var(--border);
            color: var(--text);
            background: transparent;
        }

        .btn-outline:hover { border-color: var(--green); }

        .btn-green {
            color: #081810;
            background: var(--green);
        }

        .full-width { width: 100%; }

        /* Hero */
        .hero {
            position: relative;
            min-height: min(880px, 100svh);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #10130e;
            color: #fff;
            isolation: isolate;
        }

        .hero-backdrop {
            position: absolute;
            inset: 0;
            z-index: -2;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: scale(1.08);
            transition: opacity 1s ease, transform 7s ease;
        }

        .hero-slide.active {
            opacity: 1;
            transform: scale(1);
        }

        .hero-shade {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(7,10,8,.9), rgba(7,10,8,.62) 42%, rgba(7,10,8,.12)),
                linear-gradient(0deg, rgba(7,10,8,.75), transparent 45%, rgba(7,10,8,.2));
        }

        .hero-grain {
            position: absolute;
            inset: 0;
            opacity: .1;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.24'/%3E%3C/svg%3E");
        }

        .hero-top {
            position: relative;
            z-index: 3;
            min-height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 clamp(22px, 5vw, 80px);
            border-bottom: 1px solid rgba(255,255,255,.16);
        }

        .hero-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .hero-brand-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border: 1px solid var(--lime);
            border-radius: 50%;
            color: var(--lime);
            font: 800 22px Georgia, serif;
        }

        .hero-brand-copy strong {
            display: block;
            font-size: 15px;
            letter-spacing: .2em;
        }

        .hero-brand-copy small {
            display: block;
            font-size: 8px;
            letter-spacing: .23em;
            opacity: .7;
        }

        .hero-nav {
            display: flex;
            align-items: center;
            gap: clamp(16px, 2.6vw, 42px);
        }

        .hero-nav a {
            color: rgba(255,255,255,.8);
            font-size: 12px;
            font-weight: 600;
        }

        .hero-nav a:hover { color: var(--lime); }

        .hero-actions-top {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .hero-theme,
        .hero-menu {
            border: 0;
            background: transparent;
            color: var(--lime);
            padding: 9px;
        }

        .hero-contact {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-size: 12px;
            font-weight: 650;
        }

        .hero-contact i { color: var(--lime); }

        .hero-menu { display: none; color: #fff; }

        .hero-body {
            position: relative;
            z-index: 3;
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: clamp(30px, 5vh, 60px) clamp(22px, 7vw, 120px) 30px;
        }

        .hero-kicker {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,.8);
            font-size: 9px;
            letter-spacing: .2em;
        }

        .hero-kicker-line {
            width: 30px;
            height: 1px;
            background: var(--lime);
        }

        .hero-kicker-index {
            margin-left: 10px;
            color: var(--lime);
        }

        .hero-copy {
            max-width: 760px;
            margin: auto 0;
            padding: 30px 0 40px;
        }

        .hero-eyebrow {
            margin: 0 0 22px;
            color: var(--lime);
            font-size: 10px;
            font-weight: 650;
            letter-spacing: .22em;
        }

        .hero h1 {
            font-size: clamp(54px, 8vw, 118px);
            line-height: .9;
            letter-spacing: -.07em;
            font-weight: 650;
        }

        .hero h1 em {
            font-family: Georgia, serif;
            font-weight: 400;
            color: var(--lime);
        }

        .hero-period { color: var(--lime); }

        .hero-description {
            max-width: 420px;
            margin: 26px 0;
            color: rgba(255,255,255,.78);
            font-size: 15px;
            line-height: 1.7;
        }

        .hero-ctas {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 22px;
        }

        .hero-btn {
            min-height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            font-size: 12px;
            font-weight: 700;
            transition: transform .25s;
        }

        .hero-btn:hover { transform: translateY(-3px); }

        .hero-btn-primary {
            padding: 6px 7px 6px 22px;
            background: var(--lime);
            color: #151910;
        }

        .hero-btn-primary span {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            background: #172015;
            color: var(--lime);
        }

        .hero-btn-secondary {
            min-height: 42px;
            gap: 14px;
            border-bottom: 1px solid rgba(255,255,255,.45);
            color: #fff;
        }

        .hero-btn-secondary i { color: var(--lime); }

        .hero-bottom {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: end;
            gap: 20px;
            margin-top: auto;
        }

        .hero-controls {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .hero-arrow {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            color: #fff;
            background: rgba(0,0,0,.15);
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 50%;
        }

        .hero-arrow:hover {
            background: var(--lime);
            border-color: var(--lime);
            color: #151910;
        }

        .hero-progress {
            width: 78px;
            height: 2px;
            overflow: hidden;
            background: rgba(255,255,255,.25);
        }

        .hero-progress span {
            display: block;
            width: 0;
            height: 100%;
            background: var(--lime);
        }

        .hero-progress span.running {
            animation: progress 6s linear forwards;
        }

        .hero-autoplay {
            border: 0;
            background: transparent;
            color: rgba(255,255,255,.8);
            padding: 8px;
        }

        .hero-dots {
            display: flex;
            gap: 8px;
        }

        .hero-dot {
            width: 36px;
            height: 4px;
            border: 0;
            border-radius: 999px;
            background: rgba(255,255,255,.28);
        }

        .hero-dot.active { background: var(--lime); }

        /* Trust strip */
        .trust-strip {
            padding: 26px 0;
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
        }

        /* Portfolio */
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
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .7s;
        }

        .portfolio-card:hover img { transform: scale(1.06); }

        .portfolio-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(0,0,0,.86), transparent 70%);
        }

        .portfolio-content {
            position: absolute;
            z-index: 2;
            right: 24px;
            bottom: 24px;
            left: 24px;
            color: #fff;
        }

        .portfolio-content span {
            color: #8de6c1;
            font-size: 10px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .portfolio-content h3 {
            margin-top: 7px;
            font-size: clamp(22px, 3vw, 31px);
        }

        .portfolio-content p {
            margin-top: 5px;
            color: #d2d6df;
            font-size: 12px;
        }

        .portfolio-arrow {
            position: absolute;
            z-index: 3;
            top: 18px;
            right: 18px;
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            color: #fff;
            border: 1px solid rgba(255,255,255,.5);
            border-radius: 50%;
        }

        .portfolio-card:hover .portfolio-arrow {
            background: var(--green);
            color: #0b0e14;
        }

        /* Services */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
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
            margin-bottom: 26px;
            color: var(--green);
            background: var(--surface-2);
            border-radius: 13px;
            font-size: 21px;
        }

        .service-card h3 { margin-bottom: 12px; font-size: 21px; }

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

        /* Store */
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

        .product-card:hover .product-image img { transform: scale(1.06); }

        .product-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 6px 10px;
            color: #081810;
            background: var(--green);
            border-radius: 5px;
            font-size: 9px;
            font-weight: 700;
        }

        .product-details { padding: 23px; }
        .product-details h3 { font-size: 20px; }

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
            margin-top: 20px;
        }

        .product-price { font-size: 18px; font-weight: 700; }

        .add-cart {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            color: #fff;
            background: var(--accent);
            border: 0;
            border-radius: 10px;
        }

        .add-cart:hover {
            background: var(--green);
            color: #081810;
        }

        /* Campaign */
        .feature-banner {
            position: relative;
            overflow: hidden;
            padding: 65px;
            color: #fff;
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
            box-shadow: 0 0 0 40px rgba(88,214,163,.04), 0 0 0 80px rgba(88,214,163,.03);
        }

        .feature-content { position: relative; z-index: 1; max-width: 700px; }
        .feature-banner h2 { margin-bottom: 17px; }

        .feature-banner p {
            max-width: 570px;
            color: #c5ccd9;
            font-size: 14px;
        }

        .feature-banner .btn { margin-top: 26px; }

        /* Updates */
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

        .update-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .update-header h3 { font-size: 23px; }
        .update-header a { color: var(--green); font-size: 11px; font-weight: 700; }

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
            border-radius: 10px;
        }

        .date-box strong {
            display: block;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 22px;
        }

        .date-box span {
            color: var(--green);
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .update-copy h4 { font-size: 16px; }

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

        /* Community */
        .community-grid {
            display: grid;
            grid-template-columns: 1fr .9fr;
            gap: 60px;
            align-items: center;
        }

        .community-copy h2 { max-width: 570px; }

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
            list-style: none;
        }

        .community-benefits li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
        }

        .community-benefits i { color: var(--green); }

        .community-form {
            padding: 30px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .community-form h3 { margin-bottom: 8px; font-size: 24px; }

        .community-form > p {
            margin-bottom: 23px;
            color: var(--muted);
            font-size: 12px;
        }

        .form-group { margin-bottom: 16px; }

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
            border-radius: 8px;
            outline: none;
            font-size: 13px;
        }

        .form-control:focus { border-color: var(--accent); }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
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
            border-radius: 8px;
            font-size: 12px;
        }

        /* Contact */
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

        /* Footer */
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
        }

        .social-links a:hover {
            color: #081810;
            background: var(--green);
        }

        .footer-column h4 { margin-bottom: 18px; font-size: 14px; }

        .footer-column a {
            display: block;
            margin-bottom: 12px;
            color: var(--muted);
            font-size: 12px;
        }

        .footer-column a:hover { color: var(--green); }

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

        /* Cart */
        .cart-overlay {
            position: fixed;
            z-index: 1999;
            inset: 0;
            display: none;
            background: rgba(0,0,0,.6);
        }

        .cart-overlay.open { display: block; }

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
            background: var(--surface);
            box-shadow: var(--shadow);
            transform: translateX(105%);
            transition: transform .3s;
        }

        .cart-drawer.open { transform: translateX(0); }

        .cart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border);
        }

        .cart-header h3 { font-size: 22px; }

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

        .cart-item h4 { font-size: 13px; }

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

        /* Reveal */
        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes progress {
            to { width: 100%; }
        }

        @media (max-width: 1050px) {
            .hero-nav { gap: 14px; }
            .hero-nav a { font-size: 11px; }
            .hero-contact { display: none; }
        }

        @media (max-width: 820px) {
            .section { padding: 75px 0; }

            .hero-menu { display: block; }

            .hero-nav {
                position: absolute;
                top: 88px;
                left: 0;
                right: 0;
                z-index: 10;
                display: none;
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                padding: 12px 24px 20px;
                background: #141811;
                border-bottom: 1px solid rgba(255,255,255,.15);
            }

            .hero-nav.open { display: flex; }

            .hero-nav a {
                padding: 13px 0;
                border-bottom: 1px solid rgba(255,255,255,.12);
                font-size: 13px;
            }

            .portfolio-grid,
            .updates-grid,
            .community-grid,
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .portfolio-card.large {
                grid-row: auto;
                min-height: 420px;
            }

            .services-grid,
            .store-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-top {
                grid-template-columns: 1fr 1fr;
            }

            .footer-brand { grid-column: span 2; }
        }

        @media (max-width: 560px) {
            .container { width: calc(100% - 32px); }

            .section { padding: 60px 0; }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
                margin-bottom: 28px;
            }

            h2 { font-size: 35px; letter-spacing: -1.2px; }

            .hero h1 {
                font-size: clamp(50px, 13vw, 76px);
                letter-spacing: -.05em;
            }

            .hero-ctas { flex-direction: column; align-items: stretch; }
            .hero-btn { width: 100%; }

            .hero-bottom {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .portfolio-grid,
            .services-grid,
            .store-grid,
            .updates-grid {
                grid-template-columns: 1fr;
            }

            .form-row { grid-template-columns: 1fr; }

            .footer-top {
                grid-template-columns: 1fr 1fr;
                gap: 28px 18px;
            }

            .footer-brand { grid-column: span 2; }

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
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>
<body>

    <main>
        {{-- HERO --}}
        <section class="hero" id="home" aria-label="Rayda Global Agency">
            <div class="hero-backdrop" aria-hidden="true">
                <div class="hero-slide active" style="background-image:url('https://images.unsplash.com/photo-1492619375914-88005aa9e8fb?auto=format&fit=crop&w=2200&q=85');"></div>
                <div class="hero-slide" style="background-image:url('https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=2200&q=85');"></div>
                <div class="hero-slide" style="background-image:url('https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=2200&q=85');"></div>
                <div class="hero-shade"></div>
                <div class="hero-grain"></div>
            </div>

            <div class="hero-top">
                <a class="hero-brand" href="{{ url('/') }}">
                    <span class="hero-brand-mark">R</span>
                    <span class="hero-brand-copy">
                        <strong>RAYDA</strong>
                        <small>GLOBAL AGENCY</small>
                    </span>
                </a>

                <nav class="hero-nav" id="heroNav">
                    <a href="#portfolio">Work</a>
                    <a href="#services">Services</a>
                    <a href="#store">Creator Kits</a>
                    <a href="#events">Events</a>
                    <a href="#jobs">Opportunities</a>
                    <a href="#community">Community</a>
                </nav>

                <div class="hero-actions-top">
                    <button class="hero-theme" id="themeToggle" type="button" aria-label="Toggle theme">
                        <i class="fa-solid fa-sun"></i>
                    </button>

                    <button class="cart-button" id="cartButton" type="button" aria-label="Open shopping cart"
                            style="position:relative;width:41px;height:41px;display:grid;place-items:center;color:#fff;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.25);border-radius:50%;">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span id="cartCount" style="position:absolute;top:-4px;right:-4px;min-width:18px;height:18px;display:grid;place-items:center;background:var(--lime);color:#151910;border-radius:20px;font-size:10px;font-weight:700;">0</span>
                    </button>

                    <a class="hero-contact" href="#contact">
                        Let’s talk
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>

                    <button class="hero-menu" id="menuToggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>

            <div class="hero-body">
                <div class="hero-kicker">
                    <span class="hero-kicker-line"></span>
                    <span id="heroKicker">CREATIVE STRATEGY · DIGITAL STORIES</span>
                    <span class="hero-kicker-index" id="heroIndex">01 / 03</span>
                </div>

                <div class="hero-copy">
                    <p class="hero-eyebrow">IDEAS DESERVE TO MAKE AN IMPACT.</p>

                    <h1 id="heroTitle">
                        Make your<br>
                        <em>next move</em><br>
                        matter<span class="hero-period">.</span>
                    </h1>

                    <p class="hero-description" id="heroDescription">
                        We turn bold ideas into brands, experiences and digital stories people remember.
                    </p>

                    <div class="hero-ctas">
                        <a class="hero-btn hero-btn-primary" href="#store">
                            Shop Gadget Kit
                            <span><i class="fa-solid fa-arrow-up-right"></i></span>
                        </a>

                        <a class="hero-btn hero-btn-secondary" href="#contact">
                            Book Media Services
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="hero-bottom">
                    <div class="hero-controls">
                        <button class="hero-arrow" id="prevSlide" type="button" aria-label="Previous slide">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>

                        <button class="hero-arrow" id="nextSlide" type="button" aria-label="Next slide">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        <div class="hero-progress">
                            <span id="heroProgress"></span>
                        </div>

                        <button class="hero-autoplay" id="autoplayToggle" type="button" aria-label="Pause slideshow">
                            <i class="fa-solid fa-pause"></i>
                        </button>
                    </div>

                    <div class="hero-dots" id="heroDots">
                        <button class="hero-dot active" type="button" aria-label="Show slide 1"></button>
                        <button class="hero-dot" type="button" aria-label="Show slide 2"></button>
                        <button class="hero-dot" type="button" aria-label="Show slide 3"></button>
                    </div>
                </div>
            </div>
        </section>

        {{-- TRUST STRIP --}}
        <section class="trust-strip">
            <div class="container trust-inner">
                <span>OUR CREATIVE WORLD</span>
                <span class="trust-brand">01. Film & Video</span>
                <span class="trust-brand">02. Photography</span>
                <span class="trust-brand">03. Live Experiences</span>
                <span class="trust-brand">04. Creator Tools</span>
            </div>
        </section>

        {{-- PORTFOLIO --}}
        <section class="section" id="portfolio">
            <div class="container">
                <div class="section-heading reveal">
                    <div>
                        <span class="eyebrow">Selected Work</span>
                        <h2>Ideas brought<br>to <span class="accent-text">life.</span></h2>
                    </div>
                    <p>Every frame, every moment and every story is an opportunity to create something worth remembering.</p>
                </div>

                <div class="portfolio-grid">
                    <a href="#contact" class="portfolio-card large reveal">
                        <img src="https://images.unsplash.com/photo-1492619375914-88005aa9e8fb?auto=format&fit=crop&w=1200&q=85" alt="Film and video production" loading="lazy">
                        <span class="portfolio-arrow"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>

                        <div class="portfolio-content">
                            <span>Film & Video</span>
                            <h3>Stories that move people.</h3>
                            <p>Creative direction, video production and visual storytelling.</p>
                        </div>
                    </a>

                    <a href="#contact" class="portfolio-card reveal">
                        <img src="https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=900&q=85" alt="Photography and visual storytelling" loading="lazy">
                        <span class="portfolio-arrow"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>

                        <div class="portfolio-content">
                            <span>Photography</span>
                            <h3>Capture the feeling.</h3>
                            <p>Portraits, campaigns and brand imagery.</p>
                        </div>
                    </a>

                    <a href="#events" class="portfolio-card reveal">
                        <img src="https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=900&q=85" alt="Live event production" loading="lazy">
                        <span class="portfolio-arrow"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>

                        <div class="portfolio-content">
                            <span>Events & Experiences</span>
                            <h3>Make moments matter.</h3>
                            <p>Event coverage, live experiences and creative activations.</p>
                        </div>
                    </a>
                </div>

                <div style="margin-top:30px;" class="reveal">
                    <a href="#contact" class="btn btn-outline">Work With Rayda <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </section>

        {{-- SERVICES --}}
        <section class="section section-soft" id="services">
            <div class="container">
                <div class="section-heading reveal">
                    <div>
                        <span class="eyebrow">What We Do</span>
                        <h2>Creative thinking.<br><span class="accent-text">Real impact.</span></h2>
                    </div>
                    <p>From the first idea to the final delivery, we help brands and individuals communicate with purpose.</p>
                </div>

                <div class="services-grid">
                    <article class="service-card reveal">
                        <div class="service-icon"><i class="fa-solid fa-video"></i></div>
                        <h3>Video Production</h3>
                        <p>Brand films, promotional videos, interviews, documentaries, reels and social media content.</p>
                        <a href="#contact" class="service-link">Book a production <i class="fa-solid fa-arrow-right"></i></a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon"><i class="fa-solid fa-camera"></i></div>
                        <h3>Photography</h3>
                        <p>Professional portraits, product photography, campaign visuals, events and lifestyle shoots.</p>
                        <a href="#contact" class="service-link">Book a photoshoot <i class="fa-solid fa-arrow-right"></i></a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon"><i class="fa-solid fa-calendar-days"></i></div>
                        <h3>Events & Coverage</h3>
                        <p>Event media, live coverage, creative activations, behind-the-scenes content and highlight films.</p>
                        <a href="#contact" class="service-link">Plan your event <i class="fa-solid fa-arrow-right"></i></a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon"><i class="fa-solid fa-pen-nib"></i></div>
                        <h3>Creative Direction</h3>
                        <p>Campaign concepts, visual identities, content planning and storytelling for growing brands.</p>
                        <a href="#contact" class="service-link">Discuss your idea <i class="fa-solid fa-arrow-right"></i></a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon"><i class="fa-solid fa-share-nodes"></i></div>
                        <h3>Social Media Content</h3>
                        <p>Short-form video, creator-led campaigns, digital content and platform-ready visuals.</p>
                        <a href="#contact" class="service-link">Grow your content <i class="fa-solid fa-arrow-right"></i></a>
                    </article>

                    <article class="service-card reveal">
                        <div class="service-icon"><i class="fa-solid fa-users"></i></div>
                        <h3>Creator Development</h3>
                        <p>Creator resources, equipment guidance, community connections and opportunities to build your craft.</p>
                        <a href="#community" class="service-link">Join the community <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                </div>
            </div>
        </section>

        {{-- STORE --}}
        <section class="section" id="store">
            <div class="container">
                <div class="section-heading reveal">
                    <div>
                        <span class="eyebrow">The Creator Store</span>
                        <h2>Your next idea<br>needs the <span class="accent-text">right tools.</span></h2>
                    </div>
                    <p>Discover creator equipment designed to help you capture, produce and share your ideas.</p>
                </div>

                <div class="store-grid">
                    <article class="product-card reveal">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&w=800&q=85" alt="Creator camera equipment" loading="lazy">
                            <span class="product-tag">CREATOR ESSENTIAL</span>
                        </div>

                        <div class="product-details">
                            <h3>Rayda Creator Kit</h3>
                            <p>A starter equipment bundle for creators ready to make professional content.</p>

                            <div class="product-bottom">
                                <span class="product-price">₦<span class="price-value">0</span></span>

                                <button type="button" class="add-cart" data-id="creator-kit" data-name="Rayda Creator Kit" data-price="0" aria-label="Add Rayda Creator Kit to cart">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                    <article class="product-card reveal">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1593305841991-05c297ba4575?auto=format&fit=crop&w=800&q=85" alt="Creator audio and video accessories" loading="lazy">
                            <span class="product-tag">AUDIO & VIDEO</span>
                        </div>

                        <div class="product-details">
                            <h3>Content Creation Kit</h3>
                            <p>Build your production setup with practical accessories for content creation.</p>

                            <div class="product-bottom">
                                <span class="product-price">₦<span class="price-value">0</span></span>

                                <button type="button" class="add-cart" data-id="content-kit" data-name="Content Creation Kit" data-price="0" aria-label="Add Content Creation Kit to cart">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </article>

                    <article class="product-card reveal">
                        <div class="product-image">
                            <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=800&q=85" alt="Camera gear for professional creators" loading="lazy">
                            <span class="product-tag">UPGRADE YOUR SETUP</span>
                        </div>

                        <div class="product-details">
                            <h3>Creator Pro Bundle</h3>
                            <p>A flexible bundle concept for creators who want to take production further.</p>

                            <div class="product-bottom">
                                <span class="product-price">₦<span class="price-value">0</span></span>

                                <button type="button" class="add-cart" data-id="creator-pro" data-name="Creator Pro Bundle" data-price="0" aria-label="Add Creator Pro Bundle to cart">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        {{-- CAMPAIGN --}}
        <section class="section section-soft">
            <div class="container">
                <div class="feature-banner reveal">
                    <div class="feature-content">
                        <span class="eyebrow">For the Next Generation</span>
                        <h2>Don’t just watch<br>the story. <span class="accent-text">Create it.</span></h2>
                        <p>Rayda connects creators with tools, ideas, creative experiences and opportunities to turn passion into meaningful work.</p>
                        <a href="#community" class="btn btn-green">Become Part of Rayda <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        {{-- EVENTS + JOBS --}}
        <section class="section" id="events">
            <div class="container">
                <div class="section-heading reveal">
                    <div>
                        <span class="eyebrow">Stay Connected</span>
                        <h2>What’s happening<br>in our <span class="accent-text">world.</span></h2>
                    </div>
                    <p>Discover upcoming events, creator meetups, workshops and experiences worth being part of.</p>
                </div>

                <div class="updates-grid">
                    <div class="update-panel reveal">
                        <div class="update-header">
                            <h3>Upcoming Events</h3>
                            <a href="#community">Get updates <i class="fa-solid fa-arrow-right"></i></a>
                        </div>

                        <article class="update-item">
                            <div class="date-box"><strong>--</strong><span>Date</span></div>
                            <div class="update-copy">
                                <span class="job-label">Creator Community</span>
                                <h4>Creator Meetups & Networking</h4>
                                <p>Connect with other creators, share ideas and explore collaborations.</p>
                                <a href="#community">Get event updates <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>

                        <article class="update-item">
                            <div class="date-box"><strong>--</strong><span>Date</span></div>
                            <div class="update-copy">
                                <span class="job-label">Learning</span>
                                <h4>Media & Content Workshops</h4>
                                <p>Practical learning experiences for people looking to develop creative skills.</p>
                                <a href="#community">Join the mailing list <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>

                    <div class="update-panel" id="jobs">
                        <div class="update-header">
                            <h3>Creator Opportunities</h3>
                            <a href="#community">Get updates <i class="fa-solid fa-arrow-right"></i></a>
                        </div>

                        <article class="update-item">
                            <div class="date-box"><strong><i class="fa-solid fa-video"></i></strong><span>Gig</span></div>
                            <div class="update-copy">
                                <span class="job-label">Video & Production</span>
                                <h4>Freelance Videographers</h4>
                                <p>Opportunities for skilled visual storytellers to collaborate on media projects.</p>
                                <a href="#contact">Express interest <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>

                        <article class="update-item">
                            <div class="date-box"><strong><i class="fa-solid fa-camera"></i></strong><span>Gig</span></div>
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

        {{-- COMMUNITY --}}
        <section class="section section-soft" id="community">
            <div class="container community-grid">
                <div class="community-copy reveal">
                    <span class="eyebrow">The Rayda Creator Community</span>
                    <h2>Good things happen when <span class="accent-text">creators connect.</span></h2>
                    <p>Join our growing creator community to hear about events, creative opportunities, equipment launches, workshops and future initiatives.</p>

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

                    <form id="communityForm" method="POST" action="#">
                        @csrf

                        <div class="form-group">
                            <label for="communityName">Full name</label>
                            <input class="form-control" id="communityName" name="name" type="text" placeholder="Your name" required>
                        </div>

                        <div class="form-group">
                            <label for="communityEmail">Email address</label>
                            <input class="form-control" id="communityEmail" name="email" type="email" placeholder="you@example.com" required>
                        </div>

                        <div class="form-group">
                            <label for="communityPhone">Phone number</label>
                            <input class="form-control" id="communityPhone" name="phone" type="tel" placeholder="Your phone number">
                        </div>

                        <div class="form-group">
                            <label for="creatorType">What do you create?</label>
                            <select class="form-control" id="creatorType" name="creator_type" required>
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
                            Join the Community <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        <p class="form-note">By joining, you agree to receive relevant Rayda updates.</p>
                    </form>
                </div>
            </div>
        </section>

        {{-- CONTACT --}}
        <section class="section" id="contact">
            <div class="container contact-grid">
                <div class="contact-copy reveal">
                    <span class="eyebrow">Let’s Work Together</span>
                    <h2>Have an idea?<br><span class="accent-text">Let’s make it real.</span></h2>
                    <p>Tell us what you are planning. Whether it is a brand campaign, a production, an event or a collaboration, we’d love to hear from you.</p>

                    <div class="contact-detail">
                        <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <small>Email us</small>
                            <strong>hello@rayda.com</strong>
                        </div>
                    </div>

                    <div class="contact-detail">
                        <div class="contact-icon"><i class="fa-solid fa-video"></i></div>
                        <div>
                            <small>Creative services</small>
                            <strong>Production, photography & events</strong>
                        </div>
                    </div>
                </div>

                <div class="contact-form reveal">
                    <div class="form-status" id="contactStatus" role="status"></div>

                    <form id="contactForm" method="POST" action="#">
                        @csrf

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contactName">Your name</label>
                                <input class="form-control" id="contactName" name="name" type="text" placeholder="Full name" required>
                            </div>

                            <div class="form-group">
                                <label for="contactEmail">Email address</label>
                                <input class="form-control" id="contactEmail" name="email" type="email" placeholder="Email address" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contactService">What do you need?</label>
                            <select class="form-control" id="contactService" name="service" required>
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
                            <textarea class="form-control" id="contactMessage" name="message" placeholder="Share a few details about your idea..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary full-width">
                            Send Enquiry <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <strong style="font-family:'Space Grotesk',sans-serif;font-size:23px;">
                        RAYDA<span class="accent-text">.</span>
                    </strong>

                    <p>Turning ideas into impact through creative production, media services, creator tools and community.</p>

                    <div class="social-links">
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

    {{-- CART --}}
    <div class="cart-overlay" id="cartOverlay"></div>

    <aside class="cart-drawer" id="cartDrawer" aria-label="Shopping cart" aria-hidden="true">
        <div class="cart-header">
            <h3>Your bag</h3>
            <button type="button" class="cart-close" id="cartClose" aria-label="Close cart">
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

            <button type="button" class="btn btn-primary full-width" id="checkoutButton">
                Continue to Checkout <i class="fa-solid fa-arrow-right"></i>
            </button>

            <p class="form-note">Checkout and payment are not connected yet.</p>
        </div>
    </aside>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const root = document.documentElement;
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            /* Theme */
            const themeToggle = document.getElementById('themeToggle');

            function setTheme(theme) {
                root.dataset.theme = theme;
                themeToggle.innerHTML = theme === 'light'
                    ? '<i class="fa-solid fa-moon"></i>'
                    : '<i class="fa-solid fa-sun"></i>';

                try { localStorage.setItem('rayda-theme', theme); } catch (e) {}
            }

            let savedTheme = null;
            try { savedTheme = localStorage.getItem('rayda-theme'); } catch (e) {}

            setTheme(savedTheme || (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark'));

            themeToggle.addEventListener('click', function () {
                setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark');
            });

            /* Mobile nav */
            const menuToggle = document.getElementById('menuToggle');
            const heroNav = document.getElementById('heroNav');

            menuToggle.addEventListener('click', function () {
                const open = heroNav.classList.toggle('open');
                menuToggle.setAttribute('aria-expanded', String(open));
                menuToggle.innerHTML = open ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-bars"></i>';
            });

            heroNav.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    heroNav.classList.remove('open');
                    menuToggle.setAttribute('aria-expanded', 'false');
                    menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
                });
            });

            /* Hero slider */
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');
            const kicker = document.getElementById('heroKicker');
            const title = document.getElementById('heroTitle');
            const description = document.getElementById('heroDescription');
            const indexLabel = document.getElementById('heroIndex');
            const progress = document.getElementById('heroProgress');
            const autoplayButton = document.getElementById('autoplayToggle');

            const heroContent = [
                {
                    kicker: 'CREATIVE STRATEGY · DIGITAL STORIES',
                    title: 'Make your<br><em>next move</em><br>matter<span class="hero-period">.</span>',
                    description: 'We turn bold ideas into brands, experiences and digital stories people remember.'
                },
                {
                    kicker: 'PHOTOGRAPHY · VISUAL IDENTITY',
                    title: 'Be seen.<br><em>Be heard.</em><br>Be felt<span class="hero-period">.</span>',
                    description: 'From brand storytelling to creator tools, we help ambitious ideas find their audience.'
                },
                {
                    kicker: 'EVENTS · CULTURE · CONNECTION',
                    title: 'Bring people<br><em>closer</em><br>together<span class="hero-period">.</span>',
                    description: 'We create meaningful experiences that connect communities and make moments matter.'
                }
            ];

            let currentSlide = 0;
            let paused = false;
            let sliderTimer = null;

            function resetProgress() {
                progress.classList.remove('running');
                void progress.offsetWidth;

                if (!paused) {
                    progress.classList.add('running');
                }
            }

            function showSlide(index) {
                currentSlide = (index + slides.length) % slides.length;

                slides.forEach(function (slide, i) {
                    slide.classList.toggle('active', i === currentSlide);
                });

                dots.forEach(function (dot, i) {
                    dot.classList.toggle('active', i === currentSlide);
                });

                const content = heroContent[currentSlide];
                kicker.textContent = content.kicker;
                title.innerHTML = content.title;
                description.textContent = content.description;
                indexLabel.textContent = String(currentSlide + 1).padStart(2, '0') + ' / 03';

                resetProgress();
                restartSlider();
            }

            function restartSlider() {
                clearInterval(sliderTimer);

                if (!paused && !reduceMotion) {
                    sliderTimer = setInterval(function () {
                        showSlide(currentSlide + 1);
                    }, 6000);
                }
            }

            document.getElementById('prevSlide').addEventListener('click', function () {
                showSlide(currentSlide - 1);
            });

            document.getElementById('nextSlide').addEventListener('click', function () {
                showSlide(currentSlide + 1);
            });

            dots.forEach(function (dot, index) {
                dot.addEventListener('click', function () {
                    showSlide(index);
                });
            });

            autoplayButton.addEventListener('click', function () {
                paused = !paused;

                autoplayButton.innerHTML = paused
                    ? '<i class="fa-solid fa-play"></i>'
                    : '<i class="fa-solid fa-pause"></i>';

                autoplayButton.setAttribute('aria-label', paused ? 'Play slideshow' : 'Pause slideshow');

                if (paused) {
                    clearInterval(sliderTimer);
                    progress.classList.remove('running');
                } else {
                    resetProgress();
                    restartSlider();
                }
            });

            showSlide(0);

            /* Reveal */
            const revealElements = document.querySelectorAll('.reveal');

            if ('IntersectionObserver' in window && !reduceMotion) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: .12 });

                revealElements.forEach(function (element) {
                    observer.observe(element);
                });
            } else {
                revealElements.forEach(function (element) {
                    element.classList.add('visible');
                });
            }

            /* Cart */
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

                if (!cart.length) {
                    cartItems.innerHTML = '<div class="cart-empty">Your bag is empty.</div>';
                    return;
                }

                cartItems.innerHTML = cart.map(function (item) {
                    return `
                        <div class="cart-item">
                            <div>
                                <h4>${escapeHTML(item.name)}</h4>
                                <p>${formatNaira(item.price)} × ${item.quantity}</p>
                                <button class="cart-remove" type="button" data-remove="${escapeHTML(item.id)}">Remove</button>
                            </div>
                            <strong>${formatNaira(item.price * item.quantity)}</strong>
                        </div>
                    `;
                }).join('');
            }

            document.querySelectorAll('.add-cart').forEach(function (button) {
                button.addEventListener('click', function () {
                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const price = Number(button.dataset.price);

                    if (!price) {
                        alert('Set a real product price before enabling the cart.');
                        return;
                    }

                    const existing = cart.find(function (item) {
                        return item.id === id;
                    });

                    if (existing) {
                        existing.quantity++;
                    } else {
                        cart.push({ id, name, price, quantity: 1 });
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
                if (event.key === 'Escape') closeCart();
            });

            checkoutButton.addEventListener('click', function () {
                alert('Connect this button to your Laravel checkout route and payment gateway.');
            });

            /* Forms */
            function showStatus(element, message) {
                element.textContent = message;
                element.style.display = 'block';
            }

            document.getElementById('communityForm').addEventListener('submit', function (event) {
                event.preventDefault();
                showStatus(document.getElementById('communityStatus'), 'Connect this form to your Laravel community-registration route.');
            });

            document.getElementById('contactForm').addEventListener('submit', function (event) {
                event.preventDefault();
                showStatus(document.getElementById('contactStatus'), 'Connect this form to your Laravel contact-enquiry route.');
            });

            document.getElementById('currentYear').textContent = new Date().getFullYear();
            renderCart();
        });
    </script>

</body>
</html>
