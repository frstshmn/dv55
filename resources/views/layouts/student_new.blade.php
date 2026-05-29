<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DV55 | @yield('title', 'Кабінет')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/student_new.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('head')
</head>
<body class="student-body">

<header class="student-header">
    <div class="student-header-inner">
        <a href="/cabinet" class="student-logo">
            <img src="{{ asset('images/logo_small.svg') }}" alt="DV55">
            <span>DV55</span>
        </a>
        <div class="student-header-center">
            @yield('header-center')
        </div>
        <div class="student-header-right">
            <span class="student-user-name">{{ Auth::user()->name }}</span>
            @if(Auth::user()->is_admin)
            <a href="{{ url('/admin') }}" class="student-admin-link">Адмін-панель</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="margin:0">
                @csrf
                <button type="submit" class="student-logout-btn">Вийти</button>
            </form>
        </div>
    </div>
</header>

@yield('content')

<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
</script>
@yield('scripts')
</body>
</html>
