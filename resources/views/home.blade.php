@extends('layouts.app')

@section('title', 'Anasayfa - kle')

@section('content')
<div class="dashboard-header">
    <div>
        <h1 class="welcome-title">Hoş geldin, {{ Auth::user()->name }} 👋</h1>
        <p class="welcome-subtitle">Ürün yönetimi ve katalog işlemlerini bu panelden takip edebilirsiniz.</p>
    </div>
    <div>
        <a href="#new-product" class="btn btn-primary" onclick="alert('Ürün ekleme özelliği bir sonraki adımda eklenecektir.'); return false;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Yeni Ürün Ekle
        </a>
    </div>
</div>

{{-- Bilgi Kartları / İstatistikler --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div class="card" style="margin: 0; padding: 1.25rem;">
        <div style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
            Toplam Ürün
        </div>
        <div style="font-size: 1.75rem; font-weight: 700; color: var(--text-main);">
            0
        </div>
        <div style="font-size: 0.8125rem; color: var(--text-subtle); margin-top: 0.25rem;">
            Katalogda kayıtlı ürün sayısı
        </div>
    </div>

    <div class="card" style="margin: 0; padding: 1.25rem;">
        <div style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
            Hesap Durumu
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.25rem; font-weight: 700; color: var(--success); margin-top: 0.35rem;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: var(--success);"></span>
            Aktif Oturum
        </div>
        <div style="font-size: 0.8125rem; color: var(--text-subtle); margin-top: 0.25rem;">
            {{ Auth::user()->email }}
        </div>
    </div>
</div>

{{-- Ürün Listesi Bölümü --}}
<div class="card">
    <div class="card-header">
        <h2 style="font-size: 1.125rem; margin: 0;">Ürün Kataloğu</h2>
        <span style="font-size: 0.8125rem; color: var(--text-muted);">0 Ürün</span>
    </div>

    <div class="card-body">
        <div class="empty-state">
            <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
            <h3>Henüz Eklenmiş Ürün Yok</h3>
            <p>Sisteme yeni ürünler eklediğinizde bu vitrinde listelenecek, düzenlenebilecek ve incelenebilecek.</p>
        </div>
    </div>
</div>
@endsection
