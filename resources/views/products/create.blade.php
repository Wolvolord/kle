@extends('layouts.app')

@section('title', 'Yeni Ürün Ekle - kle')

@section('content')
<div style="max-width: 640px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.875rem; text-decoration: none; color: var(--text-muted);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Anasayfaya Dön
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h1 style="font-size: 1.25rem; margin: 0;">Yeni Ürün Ekle</h1>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Ürün Adı</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control" 
                        placeholder="Örn: Mekanik Klavye" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Ürün Fiyatı (₺)</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        min="0" 
                        id="price" 
                        name="price" 
                        class="form-control" 
                        placeholder="Örn: 1250.50" 
                        value="{{ old('price') }}" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Ürün Açıklaması</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        class="form-control" 
                        rows="4" 
                        placeholder="Ürünün özelliklerini ve detaylarını buraya yazın..." 
                        required
                    >{{ old('description') }}</textarea>
                </div>

                <div style="display: flex; align-items: center; gap: 0.75rem; margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary">
                        Ürünü Kaydet
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        Vazgeç
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
