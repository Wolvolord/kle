<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'kle - Ürün Yönetim Sistemi')</title>
    <link rel="stylesheet" href="/css/style.css">
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="navbar-container">
            <a href="/" class="brand">
                <span class="brand-icon">k</span>
                <span>kle</span>
            </a>

            <nav class="nav-menu">
                @auth
                    <div class="user-badge">
                        <span class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="/logout" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">Çıkış Yap</button>
                    </form>
                @else
                    <a href="/login" class="btn btn-secondary btn-sm">Giriş Yap</a>
                    <a href="/register" class="btn btn-primary btn-sm">Kayıt Ol</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Container -->
    <main class="main-content">
        {{-- Flash Mesajları --}}
        @if (session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <div>{{ session('warning') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} <strong>kle</strong>. Tüm hakları saklıdır.</p>
    </footer>

    @yield('scripts')
</body>
</html>
