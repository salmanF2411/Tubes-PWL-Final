<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jayusman Minimarket</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-['Inter'] text-slate-900">
    <main class="min-h-screen bg-[#f7fbff] lg:grid lg:grid-cols-[minmax(0,1.04fr)_minmax(520px,0.96fr)]">

        <section class="relative hidden min-h-screen overflow-hidden bg-gradient-to-br from-[#031836] via-[#05345b] to-[#027f7e] text-white lg:block">

            <div class="absolute inset-0 opacity-25 bg-[linear-gradient(115deg,transparent_0_44%,rgba(255,255,255,0.18)_45%,transparent_46%)]"></div>

            <div class="absolute inset-0 opacity-30 bg-[linear-gradient(90deg,rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(0deg,rgba(255,255,255,0.035)_1px,transparent_1px)] bg-[size:84px_84px]"></div>

            <div class="absolute right-10 top-36 h-[150px] w-[150px] bg-[radial-gradient(rgba(255,255,255,0.22)_1.5px,transparent_1.5px)] bg-[size:18px_18px]"></div>

            <div class="absolute bottom-[-18%] left-[-12%] right-[-8%] h-[42%] rotate-[-7deg] rounded-t-[55%] bg-gradient-to-r from-emerald-500/60 to-cyan-400/25"></div>

            <div class="absolute right-[8%] top-[27%] grid h-[330px] w-[330px] place-items-center rounded-full border border-white/15 text-white/15">
                <div class="absolute inset-[26px] rounded-full border border-white/10"></div>
                <i class="fa-solid fa-cart-shopping text-[150px]"></i>
            </div>

            <div class="relative z-10 flex min-h-screen flex-col justify-between px-10 py-8 xl:px-12">
                <div class="flex items-center gap-4">
                    <div class="h-14 w-14 overflow-hidden rounded-2xl bg-white p-1.5 shadow-lg">
                        <img src="{{ asset('img/logo_minimarket.png') }}" alt="Logo Jayusman Minimarket" class="h-full w-full rounded-xl object-contain">
                    </div>

                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight">Jayusman Minimarket</h1>
                        <p class="mt-1 text-base font-medium text-white/80">Retail Management System</p>
                    </div>
                </div>

                <div class="max-w-2xl">
                    <h2 class="text-5xl font-extrabold leading-[1.08] tracking-tight">
                        Kelola Minimarket
                        <span class="block text-[#39d98a]">Lebih Mudah</span>
                    </h2>

                    <div class="mt-5 h-2 w-24 rounded-full bg-[#ffd23f]"></div>

                    <p class="mt-6 max-w-xl text-base font-medium leading-7 text-white/90">
                        Pantau transaksi, stok barang, laporan cabang, dan aktivitas kasir secara
                        <span class="whitespace-nowrap font-extrabold text-[#39d98a]">real-time</span>
                        dari satu sistem terpusat.
                    </p>

                    <div class="mt-6 inline-flex max-w-md items-center gap-4 rounded-2xl border border-white/20 bg-white/10 px-5 py-3.5 shadow-2xl shadow-black/10 backdrop-blur">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#39d98a] text-white shadow-lg shadow-emerald-950/20">
                            <i class="fa-solid fa-building-shield text-xl"></i>
                        </div>

                        <div>
                            <p class="font-extrabold text-[#39d98a]">Monitoring 5 Cabang</p>
                            <p class="mt-1 text-sm font-semibold text-white">Semua cabang terhubung dalam satu sistem</p>
                        </div>
                    </div>
                </div>

                <div class="grid max-w-3xl grid-cols-3 gap-4">
                    <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-xl shadow-black/10 backdrop-blur">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#39d98a]">
                            <i class="fa-solid fa-store text-xl"></i>
                        </div>
                        <p class="text-2xl font-extrabold">5</p>
                        <p class="mt-1 text-lg font-extrabold">Cabang Aktif</p>
                        <p class="mt-2 text-sm text-white/75">Tersebar & Terhubung</p>
                    </div>

                    <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-xl shadow-black/10 backdrop-blur">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#ffd23f] text-[#062f5f]">
                            <i class="fa-solid fa-chart-column text-xl"></i>
                        </div>
                        <p class="text-xl font-extrabold">Real-time</p>
                        <p class="mt-1 text-lg font-extrabold">Transaksi</p>
                        <p class="mt-2 text-sm text-white/75">Update instan setiap saat</p>
                    </div>

                    <div class="rounded-2xl border border-white/20 bg-white/10 p-5 shadow-xl shadow-black/10 backdrop-blur">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#43a7ff]">
                            <i class="fa-solid fa-cube text-xl"></i>
                        </div>
                        <p class="text-xl font-extrabold">Stok</p>
                        <p class="mt-1 text-lg font-extrabold">per Cabang</p>
                        <p class="mt-2 text-sm text-white/75">Kontrol stok akurat</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative flex min-h-screen items-center justify-center overflow-hidden bg-[radial-gradient(circle_at_82%_5%,rgba(37,99,235,0.08),transparent_24%),linear-gradient(135deg,#ffffff,#f5f9ff)] px-5 py-10">

            <div class="absolute right-[7%] top-0 h-[140px] w-[140px] opacity-45 bg-[radial-gradient(rgba(15,95,184,0.18)_1.5px,transparent_1.5px)] bg-[size:16px_16px]"></div>

            <div class="absolute right-[-70px] top-[14%] h-[520px] w-[260px] rotate-[10deg] rounded-[50%] border border-l-0 border-[#0f5fb8]/10"></div>

            <div class="relative z-10 w-full max-w-xl">
                <div class="mb-8 flex items-center gap-4 lg:hidden">
                    <div class="h-14 w-14 overflow-hidden rounded-2xl bg-white p-1.5 shadow-lg">
                        <img src="{{ asset('img/logo_minimarket.png') }}" alt="Logo Jayusman Minimarket" class="h-full w-full rounded-xl object-contain">
                    </div>

                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-[#062f5f]">Jayusman Minimarket</h1>
                        <p class="text-sm font-medium text-slate-500">Retail Management System</p>
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200/80 bg-white/95 px-8 py-7 shadow-[0_22px_70px_rgba(15,23,42,0.12)] backdrop-blur md:px-10">
                    <div class="mb-6 text-center">
                        <div class="mx-auto mb-5 h-20 w-20 overflow-hidden rounded-3xl bg-white p-2.5 shadow-lg">
                            <img src="{{ asset('img/logo_minimarket.png') }}" alt="Logo Jayusman Minimarket" class="h-full w-full rounded-2xl object-contain">
                        </div>

                        <h2 class="text-3xl font-extrabold tracking-tight text-[#062f5f]">Masuk ke Dashboard</h2>
                        <p class="mt-3 text-sm font-medium text-slate-500">Selamat datang dan bekerja dengan jujur</p>
                    </div>

                    <form action="#" method="POST" class="space-y-3.5">
                        <div>
                            <label for="email" class="mb-2 block text-sm font-bold text-[#0b1f3f]">Email</label>

                            <div class="relative">
                                <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-12 pr-4 text-sm font-medium outline-none transition placeholder:text-slate-400 focus:border-[#0f5fb8] focus:ring-4 focus:ring-[#0f5fb8]/10"
                                    placeholder="Masukkan email Anda"
                                    required
                                    autofocus>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-bold text-[#0b1f3f]">Password</label>

                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-12 pr-12 text-sm font-medium outline-none transition placeholder:text-slate-400 focus:border-[#0f5fb8] focus:ring-4 focus:ring-[#0f5fb8]/10"
                                    placeholder="Masukkan password Anda"
                                    required>

                                <button
                                    type="button"
                                    id="toggle-password"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 transition hover:text-[#0f5fb8] focus:outline-none"
                                    aria-label="Tampilkan password"
                                    aria-pressed="false">
                                    <i id="toggle-password-icon" class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <label for="remember" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                class="h-4 w-4 rounded border-slate-300 text-[#0f5fb8] focus:ring-[#0f5fb8]">
                            Ingat saya
                        </label>

                        <button
                            type="button"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#062f5f] px-4 py-3 text-base font-extrabold text-white shadow-lg shadow-[#062f5f]/20 transition hover:bg-[#0f5fb8] focus:outline-none focus:ring-4 focus:ring-[#0f5fb8]/20">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Masuk ke Dashboard
                        </button>
                    </form>

                    <div class="my-5 flex items-center gap-4 text-sm font-medium text-slate-400">
                        <div class="h-px flex-1 bg-slate-200"></div>
                        <span>atau</span>
                        <div class="h-px flex-1 bg-slate-200"></div>
                    </div>

                    <p class="text-center text-sm font-medium text-slate-600">
                        <i class="fa-solid fa-shield-halved mr-2 text-[#0f5fb8]"></i>
                        Butuh bantuan?
                        <span class="font-bold text-[#16b978]">Hubungi Administrator</span>
                    </p>
                </div>

                <p class="mt-6 text-center text-sm font-medium text-slate-500">
                    &copy; 2026 Jayusman Minimarket. All rights reserved.
                </p>
            </div>
        </section>
    </main>
</body>

</html>