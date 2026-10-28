@extends('layouts.app')

@section('title', 'Yeni Ürün Ekle - kle')

@section('content')
<div style="max-width: 860px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.875rem; text-decoration: none; color: var(--text-muted);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kataloğa Dön
        </a>
    </div>

    <div class="card" style="padding: 2rem;">
        <div style="margin-bottom: 1.75rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
            <h1 style="font-size: 1.5rem; margin: 0 0 0.25rem 0; color: var(--text-main);">Yeni Ürün Ekle</h1>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">Kataloğa dahil etmek istediğiniz ürünün detaylarını ve görselini aşağıdan tanımlayabilirsiniz.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 1.75rem;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <div>
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem; margin-bottom: 1.25rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="name" class="form-label">Ürün Adı</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control" 
                        placeholder="Örn: Kablosuz Mekanik Klavye" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.375rem;">
                        <label for="price" class="form-label" style="margin-bottom: 0;">Ürün Fiyatı (₺)</label>
                        <span style="font-size: 0.75rem; color: var(--text-subtle);">Maks. 10.000.000 ₺</span>
                    </div>
                    <input 
                        type="number" 
                        step="0.01" 
                        min="0.01" 
                        max="10000000" 
                        id="price" 
                        name="price" 
                        class="form-control" 
                        placeholder="Örn: 2450.00" 
                        value="{{ old('price') }}" 
                        required
                    >
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.375rem;">
                    <label for="description" class="form-label" style="margin-bottom: 0;">Ürün Açıklaması</label>
                    <span id="char-counter" style="font-size: 0.75rem; color: var(--text-subtle);">0 karakter</span>
                </div>
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-control" 
                    rows="7" 
                    placeholder="Ürünün teknik detayları, kullanım alanları, paket içeriği veya garanti koşulları gibi bilgileri buraya serbestçe yazabilirsiniz..." 
                    required
                >{{ old('description') }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="image" class="form-label">Ürün Görseli</label>
                <div style="display: flex; gap: 1.25rem; align-items: center;">
                    <div id="image-preview-container" style="width: 96px; height: 96px; border-radius: var(--radius-md); border: 2px dashed var(--border-light); background: var(--bg-subtle); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                        <svg id="image-placeholder-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-subtle);">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        <img id="image-preview" src="" alt="Önizleme" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="flex: 1;">
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            class="form-control" 
                            accept="image/png, image/jpeg, image/jpg, image/webp"
                        >
                        <div style="font-size: 0.75rem; color: var(--text-subtle); margin-top: 0.35rem;">
                            PNG, JPG, JPEG veya WEBP formatında, maksimum 2 MB dosya yükleyebilirsiniz.
                        </div>
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem; padding-top: 1.25rem; border-top: 1px solid var(--border-light);">
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Ürünü Kaydet
                </button>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    Vazgeç
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const descInput = document.getElementById('description');
        const charCounter = document.getElementById('char-counter');
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const placeholderIcon = document.getElementById('image-placeholder-icon');

        if (descInput && charCounter) {
            function updateCounter() {
                const len = descInput.value.length;
                charCounter.textContent = len + ' karakter';
            }
            descInput.addEventListener('input', updateCounter);
            updateCounter();
        }

        if (imageInput && imagePreview && placeholderIcon) {
            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        placeholderIcon.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    placeholderIcon.style.display = 'block';
                }
            });
        }
    });
</script>
@endsection
