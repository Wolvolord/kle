@extends('layouts.app')

@section('title', 'Anasayfa - kle')

@section('content')
<div class="dashboard-header" style="margin-bottom: 2rem;">
    <div>
        <h1 class="welcome-title">Hoş geldin, {{ Auth::user()->name }}</h1>
        <p class="welcome-subtitle">Ürün yönetimi ve katalog işlemlerini bu panelden takip edebilirsiniz.</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem; margin-bottom: 2.5rem;">
    <div class="card" style="margin: 0; padding: 1.5rem;">
        <div style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
            Toplam Ürün
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: var(--text-main); letter-spacing: -0.02em;">
            {{ $products->count() }}
        </div>
        <div style="font-size: 0.8125rem; color: var(--text-subtle); margin-top: 0.25rem;">
            Katalogda kayıtlı ürün sayısı
        </div>
    </div>

    <div class="card" style="margin: 0; padding: 1.5rem;">
        <div style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
            Hesap Durumu
        </div>
        <div style="font-size: 1.25rem; font-weight: 700; color: var(--success); margin-top: 0.35rem;">
            Aktif Oturum
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; color: var(--text-subtle); margin-top: 0.35rem;">
            <span id="user-email-text" data-email="{{ Auth::user()->email }}">{{ Auth::user()->email }}</span>
            <button type="button" id="toggle-email-btn" style="background: none; border: none; cursor: pointer; color: var(--text-muted); display: inline-flex; align-items: center; padding: 2px;" aria-label="E-postayı Gizle/Göster">
                <svg id="email-eye-open" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <svg id="email-eye-closed" style="display: none;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>
            </button>
        </div>
        <div style="font-size: 0.75rem; color: var(--text-subtle); margin-top: 0.35rem;">
            Kullanıcı Kodu: <span style="font-family: monospace; color: var(--text-muted);">{{ Auth::user()->user_code ?? 'Tanımlanmadı' }}</span>
        </div>
    </div>
</div>

<div class="card" style="padding: 2rem;">
    <div class="card-header" style="margin-bottom: 1.5rem; padding-bottom: 1rem;">
        <div>
            <h2 style="font-size: 1.375rem; margin: 0 0 0.25rem 0; color: var(--text-main);">Ürün Kataloğu</h2>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">Sistemde kayıtlı tüm ürünlerin güncel listesi</p>
        </div>
        <span style="font-size: 0.8125rem; font-weight: 600; color: var(--accent); background: var(--accent-soft); padding: 4px 12px; border-radius: var(--radius-full);">{{ $products->count() }} Ürün</span>
    </div>

    <div class="card-body" style="padding: 0;">
        @if ($products->count() > 0)
            <div class="product-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <div>
                            @if ($product->image)
                                <div style="margin: -1.25rem -1.25rem 1.25rem -1.25rem; height: 180px; overflow: hidden; border-top-left-radius: var(--radius-lg); border-top-right-radius: var(--radius-lg); background: var(--bg-subtle);">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            @else
                                <div style="margin: -1.25rem -1.25rem 1.25rem -1.25rem; height: 180px; overflow: hidden; border-top-left-radius: var(--radius-lg); border-top-right-radius: var(--radius-lg); background: var(--bg-subtle); display: flex; align-items: center; justify-content: center; color: var(--text-subtle);">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.45;">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                </div>
                            @endif

                            @if ($product->product_code)
                                <div style="font-family: monospace; font-size: 0.6875rem; color: var(--text-subtle); margin-bottom: 0.35rem;">
                                    Ürün Kodu: {{ $product->product_code }}
                                </div>
                            @endif

                            <div class="product-title">{{ $product->name }}</div>
                            <div class="product-price">{{ number_format($product->price, 2, ',', '.') }} ₺</div>
                            <p class="product-desc">{{ $product->description }}</p>
                        </div>

                        <div class="product-footer">
                            <span style="font-size: 0.75rem; color: var(--text-subtle);">
                                Ekleyen: <strong style="color: var(--text-main);">{{ $product->user ? $product->user->name : 'Bilinmiyor' }}</strong>
                            </span>
                            <a href="{{ route('products.show', $product->product_code ?? $product->id) }}" class="btn btn-secondary btn-sm">
                                İncele
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
                <h3>Henüz Eklenmiş Ürün Yok</h3>
                <p>Sisteme yeni ürünler eklediğinizde bu vitrinde listelenecek, düzenlenebilecek ve incelenebilecek.</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggle-email-btn');
        const emailText = document.getElementById('user-email-text');
        const eyeOpen = document.getElementById('email-eye-open');
        const eyeClosed = document.getElementById('email-eye-closed');
        if (!toggleBtn || !emailText) return;

        const realEmail = emailText.getAttribute('data-email');
        const maskedEmail = '••••••••••••';
        let isHidden = localStorage.getItem('user_email_hidden') === 'true';

        function render() {
            emailText.textContent = isHidden ? maskedEmail : realEmail;
            eyeOpen.style.display = isHidden ? 'none' : 'inline';
            eyeClosed.style.display = isHidden ? 'inline' : 'none';
        }

        render();

        toggleBtn.addEventListener('click', function () {
            isHidden = !isHidden;
            localStorage.setItem('user_email_hidden', isHidden ? 'true' : 'false');
            render();
        });
    });
</script>
@endsection
