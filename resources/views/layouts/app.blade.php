<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT. Mitra Abadi Metalindo – Distributor Besi & Baja SNI')</title>
    <meta name="description" content="PT Mitra Abadi Metalindo adalah distributor besi dan baja yang berkomitmen menyediakan material konstruksi dengan kualitas terbaik, pelayanan cepat, dan harga kompetitif.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:ital,wght@0,300;0,400;0,600;0,700;1,300&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/iron.css') }}">
    @stack('styles')
</head>
<body>

<div class="noise-overlay"></div>

<!-- Navigation -->
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="{{ url('/') }}" class="nav-logo">
            <span class="logo-mark">⬡</span>
            <span class="logo-text">MITRA ABADI <span class="logo-accent">METALINDO</span></span>
        </a>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ url('/products') }}" class="nav-link {{ request()->is('product*') ? 'active' : '' }}">Product</a></li>
            <li><a href="{{ url('/about-us') }}" class="nav-link {{ request()->is('about-us') ? 'active' : '' }}">About Us</a></li>
            <li><a href="{{ url('/contact-us') }}" class="nav-link {{ request()->is('contact-us') ? 'active' : '' }}">Contact Us</a></li>
        </ul>
        <a href="https://wa.me/6281130556500?text=Halo%20kak,%20kami%20ada%20kebutuhan%20urgent%20untuk%20besi%20dan%20baja%20konstruksi.%20bisa%20segera%20menghubungi%20kontak%20saya?"
           target="_blank" rel="noopener" class="nav-cta">WhatsApp Kami</a>
        <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span><span></span><span></span>
        </button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/products') }}">Product</a>
        <a href="{{ url('/about-us') }}">About Us</a>
        <a href="{{ url('/contact-us') }}">Contact Us</a>
    </div>
</nav>

@yield('content')

<!-- Footer -->
<footer class="footer">
    <div class="footer-grid">
        <div class="footer-brand">
            <div class="footer-logo">
                <span class="logo-mark">⬡</span>
                <span class="logo-text">MITRA ABADI <span class="logo-accent">METALINDO</span></span>
            </div>
            <p class="footer-tagline">
                PT Mitra Abadi Metalindo adalah perusahaan distributor besi dan baja yang berkomitmen menyediakan material konstruksi dan industri dengan kualitas terbaik, pelayanan cepat, dan harga kompetitif.
            </p>
            <div class="footer-socials">
                <a href="#" aria-label="Instagram">IG</a>
                <a href="https://wa.me/6281130556500" aria-label="WhatsApp" target="_blank" rel="noopener">WA</a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ url('/contact-us') }}">Contact Us</a></li>
                <li><a href="{{ url('/about-us') }}">About Us</a></li>
                <li><a href="{{ url('/product') }}">Product</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Get In Touch</h4>
            <ul class="contact-list">
                <li><span>✉</span> ptmitraabadimetalindo@yahoo.com</li>
                <li><span>📞</span> 031 359 75 111 / 031 359 75 999</li>
                <li><span>📍</span> Gedung Graha Pacifik Lt. 8, Surabaya, Jawa Timur 60271</li>
                <li><span>⏱</span> Senin – Jum'at: 09.30 – 17.00 WIB</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p class="footer-copy">© PT. Mitra Abadi Metalindo {{ date('Y') }}. Hak Cipta Dilindungi.</p>
        <p class="footer-mono">DISTRIBUTOR BESI & BAJA SNI</p>
    </div>
</footer>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/6281130556500?text=Halo%20kak,%20kami%20ada%20kebutuhan%20urgent%20untuk%20besi%20dan%20baja%20konstruksi.%20bisa%20segera%20menghubungi%20kontak%20saya?"
   class="wa-float" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="28" height="28" fill="white">
        <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
    </svg>
</a>

<script src="{{ asset('js/iron.js') }}"></script>
@stack('scripts')
</body>
</html>