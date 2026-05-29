<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin_new.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('head')
</head>
<body class="admin-new">

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('images/logo_small.svg') }}" alt="DV55">
                <span class="sidebar-logo-text">DV55</span>
                <span class="sidebar-badge">Адмін</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-title">Управління</div>
            <a href="{{ url('/admin') }}" class="{{ request()->is('admin') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                </span>
                Курси
            </a>
            <a href="{{ url('/tests') }}" class="{{ request()->is('tests') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                </span>
                Тести
            </a>
            <a href="{{ url('/users') }}" class="{{ request()->is('users') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </span>
                Користувачі
            </a>

            <div class="sidebar-section-title" style="margin-top:16px">Навігація</div>
            <a href="{{ url('/cabinet') }}">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
                </span>
                Вигляд слухача
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                <div>
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">Адміністратор</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16,17 21,12 16,7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Вийти
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="admin-main">
        <!-- Topbar -->
        <header class="admin-topbar">
            <button id="sidebarToggle" style="display:none;background:none;border:none;cursor:pointer;color:var(--text-primary);padding:4px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <span class="topbar-title">@yield('topbar-title', 'Адмін-панель')</span>
            <div class="topbar-actions">
                <span class="theme-icon" id="themeIcon" title="Toggle theme">🌙</span>
                <button class="theme-toggle" id="themeToggle" title="Toggle dark/light mode">
                    <span class="theme-toggle-thumb"></span>
                </button>
            </div>
        </header>

        <!-- Page content -->
        <div class="admin-content">
            @if(session('success'))
                <div id="successToast" style="display:none">{{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</div>

<!-- Toast container -->
<div class="toast-container" id="toastContainer"></div>

<script>
// Theme management
(function(){
    const saved = localStorage.getItem('adminTheme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
    if(saved === 'dark') document.getElementById('themeIcon').textContent = '☀️';
})();

document.getElementById('themeToggle').addEventListener('click', function(){
    const current = document.documentElement.getAttribute('data-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('adminTheme', next);
    document.getElementById('themeIcon').textContent = next === 'dark' ? '☀️' : '🌙';
});
document.getElementById('themeIcon').addEventListener('click', function(){
    document.getElementById('themeToggle').click();
});

// CSRF setup
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

// Toast helper
function showToast(msg, type='success'){
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'toast ' + type;
    const icon = type === 'success' ? '✓' : '✕';
    toast.innerHTML = '<span style="font-size:1rem">' + icon + '</span> ' + msg;
    container.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 0.4s'; setTimeout(() => toast.remove(), 400); }, 3500);
}

// Show success flash
const successEl = document.getElementById('successToast');
if(successEl) showToast(successEl.textContent.trim());

// Mobile sidebar
const toggle = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('adminSidebar');
if(window.innerWidth <= 768) toggle.style.display = 'block';
window.addEventListener('resize', () => { toggle.style.display = window.innerWidth <= 768 ? 'block' : 'none'; });
toggle.addEventListener('click', () => sidebar.classList.toggle('mobile-open'));
</script>

@yield('scripts')

</body>
</html>
