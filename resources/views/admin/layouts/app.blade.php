<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Mitra Abadi Metalindo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Barlow:wght@300;400;500;600;700&family=Share+Tech+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin-body">

<!-- Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <span class="sidebar-logo__mark">⬡</span>
            <div>
                <span class="sidebar-logo__name">PT Mitra Abadi Metalindo</span>
                <span class="sidebar-logo__sub">Admin Panel</span>
            </div>
        </div>
        <button class="sidebar-close" id="sidebarClose">✕</button>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-nav__section">
            <span class="sidebar-nav__label">MENU UTAMA</span>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-nav__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">⊞</span> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-nav__item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <span class="nav-icon">◈</span> Kelola Produk
            </a>
        </div>
        <div class="sidebar-nav__section">
            <span class="sidebar-nav__label">NAVIGASI</span>
            <a href="{{ url('/') }}" target="_blank" class="sidebar-nav__item">
                <span class="nav-icon">↗</span> Lihat Website
            </a>
            <a href="{{ route('admin.logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="sidebar-nav__item sidebar-nav__item--danger">
                <span class="nav-icon">⏻</span> Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user__avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div>
                <div class="sidebar-user__name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="sidebar-user__role">Administrator</div>
            </div>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Main Content -->
<div class="admin-main" id="adminMain">

    <!-- Top Bar -->
    <header class="admin-topbar">
        <div class="topbar-left">
            <button class="topbar-menu-btn" id="sidebarToggle">
                <span></span><span></span><span></span>
            </button>
            <div class="topbar-breadcrumb">
                <span>Admin</span>
                <span class="breadcrumb-sep">/</span>
                <span>@yield('breadcrumb', 'Dashboard')</span>
            </div>
        </div>
        <div class="topbar-right">
            <span class="topbar-date" id="topbarDate"></span>
            <a href="{{ url('/') }}" target="_blank" class="topbar-site-link">
                🌐 Lihat Website
            </a>
        </div>
    </header>

    <!-- Page Content -->
    <main class="admin-content">

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="alert alert--success" id="flashAlert">
            <span>✓</span> {{ session('success') }}
            <button class="alert-close" onclick="this.parentElement.remove()">✕</button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert--error" id="flashAlert">
            <span>✕</span> {{ session('error') }}
            <button class="alert-close" onclick="this.parentElement.remove()">✕</button>
        </div>
        @endif

        @yield('content')
    </main>

</div>

<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>