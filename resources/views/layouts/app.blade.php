<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="color-scheme" content="light">
    <title>@yield('title', 'kle - Ürün Yönetim Sistemi')</title>
    <link rel="icon" type="image/png" href="/images/logo.png">
    <link rel="stylesheet" href="/css/style.css?v={{ file_exists(public_path('css/style.css')) ? filemtime(public_path('css/style.css')) : time() }}">
    @yield('styles')
</head>
<body>
    <header class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; text-decoration: none;">
                <img src="/images/logo.png" alt="kle" style="height: 38px; width: auto; object-fit: contain; transition: transform 0.2s ease;">
            </a>

            <nav class="nav-menu">
                @auth
                    <a href="{{ route('home') }}" style="font-size: 0.875rem; color: {{ request()->routeIs('home') ? 'var(--text-main)' : 'var(--text-muted)' }}; font-weight: {{ request()->routeIs('home') ? '600' : '500' }}; text-decoration: none; padding: 0.25rem 0.5rem;">Katalog</a>
                    <a href="{{ route('logs.index') }}" style="font-size: 0.875rem; color: {{ request()->routeIs('logs.index') ? 'var(--text-main)' : 'var(--text-muted)' }}; font-weight: {{ request()->routeIs('logs.index') ? '600' : '500' }}; text-decoration: none; padding: 0.25rem 0.5rem; display: inline-flex; align-items: center; gap: 0.35rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Loglar
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 0.35rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Yeni Ürün
                    </a>
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

    <main class="main-content">
        @foreach (['success', 'warning', 'error'] as $type)
            @if (session($type))
                @switch($type)
                    @case('success')
                        <div class="alert alert-success">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <div>{{ session($type) }}</div>
                        </div>
                        @break
                    @case('warning')
                        <div class="alert alert-warning">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <div>{{ session($type) }}</div>
                        </div>
                        @break
                    @default
                        <div class="alert alert-danger">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            <div>{{ session($type) }}</div>
                        </div>
                @endswitch
            @endif
        @endforeach

        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} <strong>kle</strong>. Tüm hakları saklıdır.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-password').forEach(function (btn) {
                btn.setAttribute('tabindex', '-1');
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');
                    const input = targetId ? document.getElementById(targetId) : this.closest('.password-wrapper').querySelector('input');
                    if (!input) return;

                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';

                    const eyeOpen = this.querySelector('.eye-open');
                    const eyeClosed = this.querySelector('.eye-closed');

                    if (eyeOpen && eyeClosed) {
                        eyeOpen.style.display = isPassword ? 'none' : 'block';
                        eyeClosed.style.display = isPassword ? 'block' : 'none';
                    }
                });
            });

            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        const passwordInput = document.getElementById('password');
                        if (passwordInput) {
                            e.preventDefault();
                            passwordInput.focus();
                        }
                    }
                });
            }

            const fullNameInput = document.getElementById('full_name');
            if (fullNameInput) {
                fullNameInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        const email = document.getElementById('email');
                        if (email) {
                            e.preventDefault();
                            email.focus();
                        }
                    }
                });
            }

            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            if (passwordInput && passwordConfirmInput) {
                passwordInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        passwordConfirmInput.focus();
                    }
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
