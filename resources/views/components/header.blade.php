@php
    $brandLogo = file_exists(public_path('img/logo_minimarket.jpg'))
        ? 'img/logo_minimarket.jpg'
        : 'img/logo_minimarket.png';
@endphp

<header class="relative bg-white text-slate-800 shadow-sm border-b border-slate-200">
    <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-[#062f5f] via-[#0f5fb8] to-[#38bdf8]"></div>
    <div class="px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <div class="brand-logo-frame h-14 w-14 overflow-hidden rounded-2xl p-1.5">
                <img src="{{ asset($brandLogo) }}" alt="Logo Jayusman Minimarket" class="brand-logo-image">
            </div>
            <div>
                <h1 class="brand-heading text-2xl font-extrabold tracking-tight">Jayusman Minimarket</h1>
                <p class="text-xs text-slate-500 font-bold">Management System</p>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <div class="hidden lg:flex items-center bg-slate-50 rounded-lg px-4 py-2 border border-slate-200 hover:border-[#0f5fb8] transition-colors max-w-xs">
                <input
                    type="text"
                    placeholder="Cari produk, kategori..."
                    class="bg-transparent outline-none text-sm text-slate-700 placeholder-slate-400 w-full focus:ring-0">
                <i class="fa-solid fa-search text-slate-400 ml-2"></i>
            </div>

            <div class="relative" x-data="{ notifOpen: false }">
                <button
                    @click="notifOpen = !notifOpen"
                    aria-label="Buka notifikasi"
                    class="relative p-2 text-[#062f5f] hover:bg-[#eef4fb] rounded-lg transition-colors cursor-pointer">
                    <i class="fa-solid fa-bell text-xl"></i>
                    @if($notifCount > 0)
                        <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 bg-red-500 text-white text-[10px] rounded-full flex items-center justify-center font-bold">{{ $notifCount > 99 ? '99+' : $notifCount }}</span>
                    @endif
                </button>

                <div
                    x-show="notifOpen"
                    x-cloak
                    x-transition
                    @click.outside="notifOpen = false"
                    class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-slate-200 z-50 max-h-96 overflow-y-auto">
                    <div class="px-4 py-3 border-b border-slate-100 bg-gradient-to-r from-[#eef4fb] via-white to-[#e8f7ff] flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-bell text-sm text-[#0f5fb8]"></i>
                            <p class="font-semibold text-slate-800">Notifikasi</p>
                        </div>
                        @if($notifCount > 0)
                            <form method="POST" action="{{ route('notifikasi.read-all') }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-[11px] font-semibold text-[#0f5fb8] hover:underline">Baca semua</button>
                            </form>
                        @endif
                    </div>

                    @forelse($notifications as $notification)
                        @php
                            $category = $notification->data['category'] ?? 'info';
                            $dotClass = match($category) {
                                'low_stock' => 'bg-amber-500',
                                'transaction' => 'bg-emerald-500',
                                'stock_transfer' => 'bg-violet-500',
                                'product' => 'bg-sky-500',
                                'stock' => 'bg-blue-500',
                                default => 'bg-slate-500',
                            };
                        @endphp
                        <a href="{{ route('notifikasi.open', $notification->id) }}"
                            class="block px-4 py-3 border-b border-slate-100 hover:bg-slate-50 transition {{ $notification->read_at ? 'opacity-70' : 'bg-blue-50/40' }}">
                            <div class="flex gap-3">
                                <div class="w-2 h-2 {{ $notification->read_at ? 'bg-slate-300' : $dotClass }} rounded-full mt-1.5 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                                    <p class="text-xs text-slate-600 mt-0.5 line-clamp-2">{{ $notification->data['message'] ?? '' }}</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ $notification->created_at->locale('id')->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <i class="fa-regular fa-bell-slash text-2xl text-slate-300"></i>
                            <p class="text-sm text-slate-500 mt-2">Belum ada notifikasi.</p>
                        </div>
                    @endforelse

                    <div class="px-4 py-2 border-t border-slate-100 bg-slate-50 text-center">
                        <a href="{{ route('notifikasi.index') }}" class="text-xs text-[#062f5f] hover:text-[#0f5fb8] font-semibold">Lihat semua notifikasi &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex flex-col items-end">
                <span class="text-sm font-medium">{{ auth()->user()->name ?? $user }}</span>
                <span class="text-xs text-slate-500 font-bold">
                    @if(auth()->check())
                        {{ auth()->user()->role_label }}
                    @else
                        Guest
                    @endif
                </span>
            </div>

            <div class="relative" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="w-10 h-10 rounded-full flex items-center justify-center hover:shadow-lg transition cursor-pointer border-2 border-[#38bdf8]/70 overflow-hidden">
                    <img src="{{ asset('img/fotosaya.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                </button>

                <div
                    x-show="open"
                    x-cloak
                    x-transition
                    @click.outside="open = false"
                    class="absolute right-0 mt-3 w-45 bg-white text-slate-800 rounded-xl shadow-2xl py-2 z-50 border border-[#062f5f]/15">

                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50">
                        <p class="font-semibold text-slate-800">{{ auth()->user()->name ?? 'Guest' }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->email ?? '-' }}</p>
                    </div>

                    <a href="#"
                        class="flex items-center gap-3 px-4 py-2 hover:bg-slate-100 transition cursor-pointer">
                        <i class="fa-solid fa-user text-slate-600 w-4"></i>
                        <span>Profile</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="w-full text-left flex items-center gap-3 px-4 py-2 hover:bg-red-50 transition text-red-600 cursor-pointer border-t border-slate-100 mt-1">
                            <i class="fa-solid fa-sign-out-alt w-4"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
