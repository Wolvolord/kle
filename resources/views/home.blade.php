@extends('layouts.app')

@section('title', 'Anasayfa - kle')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="welcome-title">Hoş geldin, {{ Auth::user()->name }}</h1>
        <p class="welcome-subtitle">Ürün yönetimi ve katalog işlemlerini bu panelden takip edebilirsiniz.</p>
    </div>
    <div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Yeni Ürün Ekle
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div class="card" style="margin: 0; padding: 1.25rem;">
        <div style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
            Toplam Ürün
        </div>
        <div style="font-size: 1.75rem; font-weight: 700; color: var(--text-main);">
            {{ $products->count() }}
        </div>
        <div style="font-size: 0.8125rem; color: var(--text-subtle); margin-top: 0.25rem;">
            Katalogda kayıtlı ürün sayısı
        </div>
    </div>

    <div class="card" style="margin: 0; padding: 1.25rem;">
        <div style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
            Hesap Durumu
        </div>
        <div style="font-size: 1.25rem; font-weight: 700; color: var(--success); margin-top: 0.35rem;">
            Aktif Oturum
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; color: var(--text-subtle); margin-top: 0.25rem;">
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
            ID: <span style="font-family: monospace; color: var(--text-muted);">{{ Auth::user()->user_code ?? 'Tanımlanmadı' }}</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 style="font-size: 1.125rem; margin: 0;">Ürün Kataloğu</h2>
        <span style="font-size: 0.8125rem; color: var(--text-muted);">{{ $products->count() }} Ürün</span>
    </div>

    <div class="card-body">
        @if ($products->count() > 0)
            <div class="product-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <div>
                            <div class="product-title">{{ $product->name }}</div>
                            <div class="product-price">{{ number_format($product->price, 2, ',', '.') }} ₺</div>
                            <p class="product-desc">{{ Str::limit($product->description, 100) }}</p>
                        </div>
                        <div class="product-footer">
                            <span>Ekleyen: <strong>{{ $product->user ? $product->user->name : 'Bilinmiyor' }}</strong> @if($product->user && $product->user->user_code)<span style="color: var(--text-subtle); font-size: 0.75rem;">({{ $product->user->user_code }})</span>@endif</span>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary btn-sm">İncele</a>
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
