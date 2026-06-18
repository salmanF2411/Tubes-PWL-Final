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
                    class="relative p-2 text-[#062f5f] hover:bg-[#eef4fb] rounded-lg transition-colors cursor-pointer">
                    <i class="fa-solid fa-bell text-xl"></i>
                    <span class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $notifCount }}</span>
                </button>

                <div
                    x-show="notifOpen"
                    x-cloak
                    x-transition
                    @click.outside="notifOpen = false"
                    class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-slate-200 z-50 max-h-96 overflow-y-auto">
                    <div class="px-4 py-3 border-b border-slate-100 bg-gradient-to-r from-[#eef4fb] via-white to-[#e8f7ff] flex items-center gap-2">
                        <i class="fa-solid fa-bell text-sm text-[#0f5fb8]"></i>
                        <p class="font-semibold text-slate-800">Notifikasi</p>
                    </div>

                    <div class="px-4 py-3 border-b border-slate-100 hover:bg-slate-100 transition cursor-pointer">
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-[#062f5f] rounded-full mt-1.5 flex-shrink-0"></div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-800">Stok Produk Terbatas</p>
                                <p class="text-xs text-slate-600">Minyak goreng premium tinggal 5 unit</p>
                                <p class="text-xs text-slate-400 mt-1">5 menit yang lalu</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-b border-slate-100 hover:bg-slate-100 transition cursor-pointer">
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-[#0f5fb8] rounded-full mt-1.5 flex-shrink-0"></div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-800">Transaksi Berhasil</p>
                                <p class="text-xs text-slate-600">Transaksi Rp 150.000 berhasil diproses</p>
                                <p class="text-xs text-slate-400 mt-1">15 menit yang lalu</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 border-b border-slate-100 hover:bg-slate-100 transition cursor-pointer">
                        <div class="flex gap-3">
                            <div class="w-2 h-2 bg-[#38bdf8] rounded-full mt-1.5 flex-shrink-0"></div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-slate-800">Transaksi Berhasil</p>
                                <p class="text-xs text-slate-600">Transaksi Rp 100.000 berhasil diproses</p>
                                <p class="text-xs text-slate-400 mt-1">20 menit yang lalu</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-2 border-t border-slate-100 bg-slate-50 text-center">
                        <a href="#" class="text-xs text-[#062f5f] hover:text-[#0f5fb8] font-semibold">Lihat semua notifikasi &rarr;</a>
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