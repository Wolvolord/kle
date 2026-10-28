@extends('layouts.app')

@section('title', 'Ürünü Düzenle - ' . $product->name . ' - kle')

@section('content')
<div style="max-width: 1240px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('products.show', $product->product_code ?? $product->id) }}" style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.875rem; text-decoration: none; color: var(--text-muted);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Ürün Detayına Dön
        </a>
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

    <div style="display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(320px, 0.9fr); gap: 2rem; align-items: start;">
        <div class="card" style="margin-bottom: 0; padding: 2rem;">
            <div style="margin-bottom: 1.75rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
                <span style="font-size: 0.75rem; font-weight: 600; color: var(--accent); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.25rem;">Düzenleme Paneli</span>
                <h1 style="font-size: 1.5rem; margin: 0; color: var(--text-main);">Ürün Bilgilerini Güncelle</h1>
            </div>

            <form method="POST" action="{{ route('products.update', $product->product_code ?? $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem; margin-bottom: 1.25rem;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="name" class="form-label">Ürün Adı</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-control" 
                            placeholder="Örn: Mekanik Klavye" 
                            value="{{ old('name', $product->name) }}" 
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
                            placeholder="Örn: 1250.50" 
                            value="{{ old('price', $product->price) }}" 
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
                        placeholder="Ürünün özelliklerini, teknik detaylarını ve notlarını buraya serbestçe yazabilirsiniz..." 
                        required
                    >{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label for="image" class="form-label">Ürün Görseli</label>
                    <div style="display: flex; gap: 1.25rem; align-items: center;">
                        <div id="image-preview-container" style="width: 80px; height: 80px; border-radius: var(--radius-md); border: 2px dashed var(--border-light); background: var(--bg-subtle); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                            @if ($product->image)
                                <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" alt="Önizleme" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <svg id="image-placeholder-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-subtle);">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                                <img id="image-preview" src="" alt="Önizleme" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                            @endif
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
                                Yeni görsel seçerseniz eski görsel otomatik silinerek güncellenecektir.
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 0.75rem; padding-top: 1.25rem; border-top: 1px solid var(--border-light);">
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        Değişiklikleri Kaydet
                    </button>
                    <a href="{{ route('products.show', $product->product_code ?? $product->id) }}" class="btn btn-secondary">
                        Vazgeç
                    </a>
                </div>
            </form>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="card" style="margin-bottom: 0; padding: 1.5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
                    <span style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Katalog Kartı Canlı Önizleme</span>
                    <span style="font-size: 0.6875rem; background: var(--accent-soft); color: var(--accent); padding: 2px 8px; border-radius: var(--radius-full); font-weight: 600;">Canlı</span>
                </div>
                
                <div style="background: var(--bg-main); border: 1px dashed var(--border-light); border-radius: var(--radius-lg); padding: 1.25rem;">
                    <div id="preview-image-box" style="margin: -1.25rem -1.25rem 1rem -1.25rem; height: 160px; overflow: hidden; border-top-left-radius: var(--radius-lg); border-top-right-radius: var(--radius-lg); background: var(--bg-subtle); display: flex; align-items: center; justify-content: center;">
                        @if ($product->image)
                            <img id="preview-card-img" src="{{ asset('storage/' . $product->image) }}" alt="Görsel Önizleme" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <svg id="preview-card-placeholder" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-subtle); opacity: 0.45;">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <img id="preview-card-img" src="" alt="Görsel Önizleme" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div style="font-family: monospace; font-size: 0.6875rem; color: var(--text-subtle); margin-bottom: 0.25rem;">
                        Ürün Kodu: {{ $product->product_code }}
                    </div>
                    <div id="preview-title" style="font-size: 1.125rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.35rem; word-break: break-word;">
                        {{ $product->name }}
                    </div>
                    <div id="preview-price" style="font-size: 1.25rem; font-weight: 700; color: var(--accent); margin-bottom: 0.75rem;">
                        {{ number_format($product->price, 2, ',', '.') }} ₺
                    </div>
                    <p id="preview-desc" style="font-size: 0.875rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.25rem; word-break: break-word; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $product->description }}
                    </p>
                    <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.75rem; border-top: 1px solid var(--border-light); font-size: 0.75rem; color: var(--text-subtle);">
                        <span>Ekleyen: <strong style="color: var(--text-main);">{{ $product->user ? $product->user->name : 'Bilinmiyor' }}</strong></span>
                        <span class="btn btn-secondary btn-sm" style="pointer-events: none; opacity: 0.7; padding: 2px 8px; font-size: 0.6875rem;">İncele</span>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom: 0; padding: 1.5rem;">
                <div style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.5rem;">
                    Sistem Bilgileri
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.875rem; font-size: 0.8125rem;">
                    <div>
                        <div style="color: var(--text-subtle); font-size: 0.75rem; margin-bottom: 2px;">Ürün Kodu</div>
                        <div style="font-family: monospace; font-weight: 600; color: var(--text-main); background: var(--bg-subtle); padding: 4px 8px; border-radius: var(--radius-sm); border: 1px solid var(--border-light); display: inline-block;">
                            {{ $product->product_code ?? 'Tanımsız' }}
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--text-subtle); font-size: 0.75rem; margin-bottom: 2px;">Oluşturan Kullanıcı</div>
                        <div style="color: var(--text-main); font-weight: 600;">
                            {{ $product->user ? $product->user->name : 'Bilinmiyor' }}
                            @if($product->user && $product->user->user_code)
                                <span style="font-family: monospace; font-size: 0.75rem; color: var(--text-muted); font-weight: normal;">({{ $product->user->user_code }})</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--text-subtle); font-size: 0.75rem; margin-bottom: 2px;">İlk Oluşturulma</div>
                        <div style="color: var(--text-main);">
                            {{ $product->created_at->format('d.m.Y H:i') }}
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--text-subtle); font-size: 0.75rem; margin-bottom: 2px;">Son Güncelleme</div>
                        <div style="color: var(--text-main);">
                            {{ $product->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('name');
        const priceInput = document.getElementById('price');
        const descInput = document.getElementById('description');
        const imgInput = document.getElementById('image');
        const charCounter = document.getElementById('char-counter');

        const prevTitle = document.getElementById('preview-title');
        const prevPrice = document.getElementById('preview-price');
        const prevDesc = document.getElementById('preview-desc');
        const previewCardImg = document.getElementById('preview-card-img');
        const previewCardPlaceholder = document.getElementById('preview-card-placeholder');
        const formPreviewImg = document.getElementById('image-preview');
        const formPlaceholderIcon = document.getElementById('image-placeholder-icon');

        if (descInput && charCounter) {
            function updateCounter() {
                charCounter.textContent = descInput.value.length + ' karakter';
            }
            descInput.addEventListener('input', updateCounter);
            updateCounter();
        }

        if (nameInput && prevTitle) {
            nameInput.addEventListener('input', function () {
                prevTitle.textContent = this.value.trim() || 'Ürün Adı';
            });
        }

        if (priceInput && prevPrice) {
            priceInput.addEventListener('input', function () {
                const val = parseFloat(this.value);
                if (!isNaN(val)) {
                    prevPrice.textContent = val.toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' ₺';
                } else {
                    prevPrice.textContent = '0,00 ₺';
                }
            });
        }

        if (descInput && prevDesc) {
            descInput.addEventListener('input', function () {
                prevDesc.textContent = this.value.trim() || 'Ürün açıklaması burada yer alacak...';
            });
        }

        if (imgInput) {
            imgInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (previewCardImg) {
                            previewCardImg.src = e.target.result;
                            previewCardImg.style.display = 'block';
                            if (previewCardPlaceholder) previewCardPlaceholder.style.display = 'none';
                        }
                        if (formPreviewImg) {
                            formPreviewImg.src = e.target.result;
                            formPreviewImg.style.display = 'block';
                            if (formPlaceholderIcon) formPlaceholderIcon.style.display = 'none';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endsection
