@extends('layouts.app')

@section('title', $product->name . ' - kle')

@section('content')
<div style="max-width: 760px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 0.375rem; font-size: 0.875rem; text-decoration: none; color: var(--text-muted);">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Kataloğa Dön
        </a>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap;">
            <div>
                <span style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.25rem;">
                    Ürün Detayı @if($product->product_code)&bull; <span style="font-family: monospace; font-size: 0.75rem;">Kod: {{ $product->product_code }}</span>@endif
                </span>
                <h1 style="font-size: 1.5rem; margin: 0; color: var(--text-main);">{{ $product->name }}</h1>
            </div>
            <div style="font-size: 1.625rem; font-weight: 700; color: var(--text-main); white-space: nowrap;">
                {{ number_format($product->price, 2, ',', '.') }} ₺
            </div>
        </div>

        <div class="card-body">
            <div style="margin-bottom: 1.5rem;">
                <div style="font-size: 0.8125rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                    Açıklama
                </div>
                <div style="font-size: 0.9375rem; color: var(--text-main); line-height: 1.7; background: var(--bg-subtle); padding: 1.25rem; border-radius: var(--radius-sm); border: 1px solid var(--border-light); white-space: pre-line;">
                    {{ $product->description }}
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: var(--radius-sm); padding: 1rem;">
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">
                        Ekleyen Kullanıcı
                    </div>
                    <div style="font-size: 0.9375rem; font-weight: 600; color: var(--text-main);">
                        {{ $product->user ? $product->user->name : 'Bilinmiyor' }}
                    </div>
                    @if ($product->user && $product->user->user_code)
                        <div style="font-size: 0.75rem; font-family: monospace; color: var(--text-subtle); margin-top: 0.25rem;">
                            ID: {{ $product->user->user_code }}
                        </div>
                    @endif
                </div>

                <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: var(--radius-sm); padding: 1rem;">
                    <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">
                        Eklenme Tarihi
                    </div>
                    <div style="font-size: 0.9375rem; font-weight: 600; color: var(--text-main);">
                        {{ $product->created_at->format('d.m.Y H:i') }}
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-subtle); margin-top: 0.25rem;">
                        {{ $product->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border-light); padding-top: 1.5rem; gap: 1rem; flex-wrap: wrap;">
                <div style="display: flex; gap: 0.75rem;">
                    <a href="{{ route('products.edit', $product->product_code ?? $product->id) }}" class="btn btn-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Düzenle
                    </a>
                </div>

                <button type="button" class="btn btn-danger" id="open-delete-modal-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    Ürünü Sil
                </button>
            </div>
        </div>
    </div>
</div>

<div id="delete-modal" class="modal-backdrop">
    <div class="modal-dialog">
        <div class="modal-title">Ürünü Silmek İstiyor musunuz?</div>
        <div class="modal-desc">
            <strong>"{{ $product->name }}"</strong> adlı ürün sistemden kalıcı olarak silinecektir. Bu işlem geri alınamaz.
        </div>
        <div class="modal-actions">
            <button type="button" id="close-delete-modal-btn" class="btn btn-secondary" style="width: 100%;">
                Vazgeç
            </button>
            <form method="POST" action="{{ route('products.destroy', $product->product_code ?? $product->id) }}" style="margin: 0; width: 100%;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%; background-color: var(--danger); color: #fff; border-color: var(--danger);">
                    Evet, Sil
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('delete-modal');
        const openBtn = document.getElementById('open-delete-modal-btn');
        const closeBtn = document.getElementById('close-delete-modal-btn');

        if (!modal || !openBtn || !closeBtn) return;

        function openModal() {
            modal.classList.add('is-active');
        }

        function closeModal() {
            modal.classList.remove('is-active');
        }

        openBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) {
                closeModal();
            }
        });
    });
</script>
@endsection
