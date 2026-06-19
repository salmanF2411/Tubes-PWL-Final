@extends('layouts.layoutAdminPanel')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Notifikasi</h2>
        <p class="text-sm text-slate-500 mt-1">Aktivitas transaksi, produk, dan stok yang perlu Anda ketahui.</p>
    </div>

    @if(auth()->user()->unreadNotifications()->exists())
        <form method="POST" action="{{ route('notifikasi.read-all') }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#062f5f] text-sm font-semibold text-white hover:bg-[#0f5fb8] transition">
                <i class="fa-solid fa-check-double"></i>
                Tandai semua dibaca
            </button>
        </form>
    @endif
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    @forelse($notifications as $notification)
        @php
            $category = $notification->data['category'] ?? 'info';
            [$icon, $iconClass] = match($category) {
                'transaction' => ['fa-receipt', 'bg-emerald-100 text-emerald-600'],
                'product' => ['fa-box', 'bg-sky-100 text-sky-600'],
                'stock' => ['fa-boxes-stacked', 'bg-blue-100 text-blue-600'],
                'low_stock' => ['fa-triangle-exclamation', 'bg-amber-100 text-amber-600'],
                'stock_transfer' => ['fa-truck-fast', 'bg-violet-100 text-violet-600'],
                default => ['fa-bell', 'bg-slate-100 text-slate-600'],
            };
        @endphp
        <div class="p-5 border-b border-slate-100 last:border-b-0 {{ $notification->read_at ? '' : 'bg-blue-50/40' }}">
            <div class="flex items-start gap-4">
                <div class="h-10 w-10 rounded-xl {{ $iconClass }} flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid {{ $icon }}"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <a href="{{ route('notifikasi.open', $notification->id) }}" class="font-semibold text-slate-900 hover:text-[#0f5fb8]">
                                {{ $notification->data['title'] ?? 'Notifikasi' }}
                            </a>
                            <p class="text-sm text-slate-600 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                            <p class="text-xs text-slate-400 mt-2">{{ $notification->created_at->locale('id')->diffForHumans() }}</p>
                        </div>

                        @if(!$notification->read_at)
                            <form method="POST" action="{{ route('notifikasi.read', $notification->id) }}" class="flex-shrink-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-semibold text-[#0f5fb8] hover:underline">
                                    Tandai dibaca
                                </button>
                            </form>
                        @else
                            <span class="text-xs font-medium text-slate-400 flex-shrink-0">
                                <i class="fa-solid fa-check-double mr-1"></i>Sudah dibaca
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="px-6 py-16 text-center">
            <i class="fa-regular fa-bell-slash text-4xl text-slate-300"></i>
            <h3 class="font-semibold text-slate-700 mt-4">Belum ada notifikasi</h3>
            <p class="text-sm text-slate-500 mt-1">Aktivitas baru akan muncul otomatis di halaman ini.</p>
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $notifications->links() }}
</div>
@endsection
