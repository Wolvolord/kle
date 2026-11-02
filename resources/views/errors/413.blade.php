@extends('layouts.app')

@section('title', 'Dosya Boyutu Çok Büyük (413) - kle')

@section('content')
<div style="max-width: 560px; margin: 4rem auto; text-align: center;">
    <div class="card" style="padding: 3rem 2rem;">
        <div style="width: 68px; height: 68px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        
        <h1 style="font-size: 1.5rem; margin-bottom: 0.75rem; color: var(--text-main); font-weight: 700;">
            Dosya Boyutu Çok Büyük (413)
        </h1>
        
        <p style="color: var(--text-muted); font-size: 0.9375rem; margin-bottom: 2rem; line-height: 1.6;">
            Yüklemeye çalıştığınız görsel boyutu sunucu sınırını aşıyor. Lütfen en fazla <strong>10 MB</strong> boyutunda bir görsel seçip tekrar deneyin.
        </p>

        <div style="display: flex; gap: 0.75rem; justify-content: center;">
            <a href="javascript:history.back()" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 0.35rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Geri Dön
            </a>
            <a href="{{ route('home') }}" class="btn btn-primary">
                Kataloğa Dön
            </a>
        </div>
    </div>
</div>
@endsection

