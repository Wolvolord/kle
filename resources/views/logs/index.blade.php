@extends('layouts.app')

@section('title', 'Aktivite Logları - kle')

@section('content')
<div style="max-width: 1280px; margin: 0 auto;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.75rem; margin: 0 0 0.35rem 0; color: var(--text-main); letter-spacing: -0.02em;">Aktivite ve İşlem Kayıtları</h1>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 0;">Sistemde gerçekleştirilen ürün işlemleri ve oturum hareketlerinin denetim günlüğü</p>
        </div>
        <div>
            <a href="{{ route('home') }}" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 0.375rem;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Kataloğa Dön
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="card" style="margin: 0; padding: 1.25rem;">
            <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                Toplam İşlem
            </div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--text-main);">
                {{ $stats['total'] }}
            </div>
        </div>

        <div class="card" style="margin: 0; padding: 1.25rem;">
            <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                Ürün Ekleme
            </div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--success);">
                {{ $stats['create'] }}
            </div>
        </div>

        <div class="card" style="margin: 0; padding: 1.25rem;">
            <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                Ürün Güncelleme
            </div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--accent);">
                {{ $stats['update'] }}
            </div>
        </div>

        <div class="card" style="margin: 0; padding: 1.25rem;">
            <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                Ürün Silme
            </div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--danger);">
                {{ $stats['delete'] }}
            </div>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-light); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; background: var(--bg-surface);">
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                @php
                    $currentAction = request('action', 'all');
                @endphp
                <a href="{{ route('logs.index', array_merge(request()->except('action', 'page'), ['action' => 'all'])) }}" class="btn btn-sm {{ $currentAction === 'all' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.4rem 0.85rem; font-size: 0.8125rem;">
                    Tümü
                </a>
                <a href="{{ route('logs.index', array_merge(request()->except('action', 'page'), ['action' => 'create'])) }}" class="btn btn-sm {{ $currentAction === 'create' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.4rem 0.85rem; font-size: 0.8125rem;">
                    Ekleme
                </a>
                <a href="{{ route('logs.index', array_merge(request()->except('action', 'page'), ['action' => 'update'])) }}" class="btn btn-sm {{ $currentAction === 'update' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.4rem 0.85rem; font-size: 0.8125rem;">
                    Güncelleme
                </a>
                <a href="{{ route('logs.index', array_merge(request()->except('action', 'page'), ['action' => 'delete'])) }}" class="btn btn-sm {{ $currentAction === 'delete' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.4rem 0.85rem; font-size: 0.8125rem;">
                    Silme
                </a>
                <a href="{{ route('logs.index', array_merge(request()->except('action', 'page'), ['action' => 'auth'])) }}" class="btn btn-sm {{ $currentAction === 'auth' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.4rem 0.85rem; font-size: 0.8125rem;">
                    Oturum
                </a>
            </div>

            <form method="GET" action="{{ route('logs.index') }}" style="margin: 0; display: flex; gap: 0.5rem; align-items: center;">
                @if(request('action'))
                    <input type="hidden" name="action" value="{{ request('action') }}">
                @endif
                <div style="position: relative;">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Loglarda veya kullanıcıda ara..." 
                        class="form-control" 
                        style="padding: 0.45rem 0.75rem 0.45rem 2rem; font-size: 0.8125rem; width: 240px;"
                    >
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 0.65rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); pointer-events: none;">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
                <button type="submit" class="btn btn-secondary btn-sm" style="padding: 0.45rem 0.75rem;">
                    Filtrele
                </button>
                @if(request('q') || (request('action') && request('action') !== 'all'))
                    <a href="{{ route('logs.index') }}" class="btn btn-secondary btn-sm" style="padding: 0.45rem 0.75rem; color: var(--text-muted);">
                        Sıfırla
                    </a>
                @endif
            </form>
        </div>

        @if ($logs->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: var(--bg-main); border-bottom: 1px solid var(--border-light); color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            <th style="padding: 1rem 1.5rem; font-weight: 600;">İşlem</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600;">Açıklama</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600;">Kullanıcı</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600;">IP Adresi</th>
                            <th style="padding: 1rem 1.5rem; font-weight: 600;">Tarih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr style="border-bottom: 1px solid var(--border-light); transition: background-color 0.15s ease;" onmouseover="this.style.backgroundColor='var(--bg-main)'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 1rem 1.5rem; vertical-align: top; white-space: nowrap;">
                                    @switch($log->action)
                                        @case('create')
                                            <span style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: var(--radius-full); background: #dcfce7; color: #166534;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                                Ürün Eklendi
                                            </span>
                                            @break
                                        @case('update')
                                            <span style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: var(--radius-full); background: #dbeafe; color: #1e40af;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                Güncellendi
                                            </span>
                                            @break
                                        @case('delete')
                                            <span style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: var(--radius-full); background: #fee2e2; color: #991b1b;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                Silindi
                                            </span>
                                            @break
                                        @case('login')
                                            <span style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: var(--radius-full); background: #f3e8ff; color: #6b21a8;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                                                Giriş Yapıldı
                                            </span>
                                            @break
                                        @case('logout')
                                            <span style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: var(--radius-full); background: #f1f5f9; color: #475569;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                                Çıkış Yapıldı
                                            </span>
                                            @break
                                        @case('register')
                                            <span style="display: inline-flex; align-items: center; gap: 0.35rem; font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: var(--radius-full); background: #fef3c7; color: #92400e;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                                Yeni Kayıt
                                            </span>
                                            @break
                                        @default
                                            <span style="font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: var(--radius-full); background: var(--bg-subtle); color: var(--text-main);">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                    @endswitch
                                </td>

                                <td style="padding: 1rem 1.5rem; vertical-align: top;">
                                    <div style="font-weight: 600; color: var(--text-main); margin-bottom: 0.25rem;">
                                        {{ $log->description }}
                                    </div>
                                    @if ($log->changes && is_array($log->changes) && count($log->changes) > 0)
                                        <details style="margin-top: 0.5rem; font-size: 0.75rem;">
                                            <summary style="cursor: pointer; color: var(--accent); font-weight: 600;">Değişiklik Ayrıntıları</summary>
                                            <div style="margin-top: 0.35rem; background: var(--bg-subtle); border-radius: var(--radius-sm); padding: 0.5rem 0.75rem; border: 1px solid var(--border-light);">
                                                @foreach ($log->changes as $field => $diff)
                                                    <div style="margin-bottom: 0.25rem;">
                                                        <strong style="color: var(--text-main); text-transform: capitalize;">{{ $field }}:</strong>
                                                        @if(is_array($diff) && isset($diff['old']) && isset($diff['new']))
                                                            <span style="color: var(--danger); text-decoration: line-through;">{{ Str::limit($diff['old'], 50) }}</span>
                                                            <span style="color: var(--text-muted); margin: 0 4px;">&rarr;</span>
                                                            <span style="color: var(--success); font-weight: 600;">{{ Str::limit($diff['new'], 50) }}</span>
                                                        @else
                                                            <span style="color: var(--text-main);">{{ json_encode($diff, JSON_UNESCAPED_UNICODE) }}</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </details>
                                    @endif
                                </td>

                                <td style="padding: 1rem 1.5rem; vertical-align: top; white-space: nowrap;">
                                    @if ($log->user)
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="width: 24px; height: 24px; border-radius: 50%; background: #cbd5e1; display: inline-flex; align-items: center; justify-content: center; font-size: 0.6875rem; font-weight: 700; color: var(--text-main);">
                                                {{ substr($log->user->name, 0, 1) }}
                                            </span>
                                            <div>
                                                <div style="font-weight: 600; color: var(--text-main); line-height: 1.2;">{{ $log->user->name }}</div>
                                                @if($log->user->user_code)
                                                    <div style="font-family: monospace; font-size: 0.6875rem; color: var(--text-subtle);">ID: {{ $log->user->user_code }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span style="color: var(--text-subtle);">Sistem / Silinmiş Kullanıcı</span>
                                    @endif
                                </td>

                                <td style="padding: 1rem 1.5rem; vertical-align: top; font-family: monospace; font-size: 0.75rem; color: var(--text-muted); white-space: nowrap;">
                                    {{ $log->ip_address ?? '—' }}
                                </td>

                                <td style="padding: 1rem 1.5rem; vertical-align: top; white-space: nowrap;">
                                    <div style="font-weight: 600; color: var(--text-main); font-size: 0.8125rem;">
                                        {{ $log->created_at->format('d.m.Y H:i') }}
                                    </div>
                                    <div style="font-size: 0.75rem; color: var(--text-subtle);">
                                        {{ $log->created_at->diffForHumans() }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($logs->hasPages())
                <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 0.8125rem; color: var(--text-muted);">
                        Toplam <strong>{{ $logs->total() }}</strong> kayıttan <strong>{{ $logs->firstItem() }}</strong> - <strong>{{ $logs->lastItem() }}</strong> arası gösteriliyor
                    </div>
                    <div>
                        {{ $logs->links() }}
                    </div>
                </div>
            @endif
        @else
            <div style="padding: 3.5rem 1.5rem; text-align: center; color: var(--text-muted);">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 0.75rem; opacity: 0.5;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <div style="font-size: 1rem; font-weight: 600; color: var(--text-main); margin-bottom: 0.25rem;">Kayıt Bulunamadı</div>
                <div style="font-size: 0.875rem;">Seçilen filtrelere uygun herhangi bir işlem kaydı bulunmamaktadır.</div>
            </div>
        @endif
    </div>
</div>
@endsection
