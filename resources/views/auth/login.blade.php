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

    <style>
        .login-shell {
            min-height: 100vh;
            background: #f7fbff;
        }

        .login-hero {
            display: none;
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(140deg, rgba(3, 24, 54, 0.98), rgba(5, 52, 91, 0.94) 58%, rgba(2, 127, 126, 0.9)),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(0deg, rgba(255, 255, 255, 0.035) 1px, transparent 1px);
            background-size: auto, 84px 84px, 84px 84px;
        }

        .login-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0.25;
            background:
                linear-gradient(115deg, transparent 0 44%, rgba(255, 255, 255, 0.18) 45%, transparent 46%),
                repeating-linear-gradient(100deg, transparent 0 42px, rgba(255, 255, 255, 0.08) 44px, transparent 48px);
        }

        .login-hero::after {
            content: "";
            position: absolute;
            left: -12%;
            right: -8%;
            bottom: -18%;
            height: 42%;
            border-radius: 55% 45% 0 0;
            background: linear-gradient(120deg, rgba(16, 185, 129, 0.62), rgba(34, 211, 238, 0.26));
            transform: rotate(-7deg);
        }

        .login-dot-pattern {
            position: absolute;
            width: 150px;
            height: 150px;
            background-image: radial-gradient(rgba(255, 255, 255, 0.22) 1.5px, transparent 1.5px);
            background-size: 18px 18px;
        }

        .login-cart-watermark {
            position: absolute;
            right: 8%;
            top: 27%;
            width: 330px;
            height: 330px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 999px;
            display: grid;
            place-items: center;
            color: rgba(255, 255, 255, 0.16);
        }

        .login-cart-watermark::before {
            content: "";
            position: absolute;
            inset: 26px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: inherit;
        }

        .login-form-side {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background:
                radial-gradient(circle at 82% 5%, rgba(37, 99, 235, 0.08), transparent 24%),
                linear-gradient(135deg, #ffffff, #f5f9ff);
        }

        .login-form-side::before {
            content: "";
            position: absolute;
            top: 0;
            right: 7%;
            width: 140px;
            height: 140px;
            opacity: 0.45;
            background-image: radial-gradient(rgba(15, 95, 184, 0.18) 1.5px, transparent 1.5px);
            background-size: 16px 16px;
        }

        .login-form-side::after {
            content: "";
            position: absolute;
            right: -70px;
            top: 14%;
            width: 260px;
            height: 520px;
            border: 1px solid rgba(15, 95, 184, 0.08);
            border-left-width: 0;
            border-radius: 50%;
            transform: rotate(10deg);
        }

        .login-card {
            box-shadow: 0 22px 70px rgba(15, 23, 42, 0.12);
        }

        .password-input::-ms-reveal,
        .password-input::-ms-clear {
            display: none;
        }

        @media (min-width: 980px) {
            .login-shell {
                display: grid;
                grid-template-columns: minmax(0, 1.04fr) minmax(520px, 0.96fr);
            }

            .login-hero {
                display: block;
            }
        }
    </style>
</head>

<body class="min-h-screen font-sans text-slate-900">
    @php
        $brandLogo = file_exists(public_path('img/logo_minimarket.jpg'))
            ? 'img/logo_minimarket.jpg'
            : 'img/logo_minimarket.png';
    @endphp

    <main class="login-shell">
        <section class="login-hero text-white">
            <div class="login-dot-pattern right-10 top-36"></div>
            <div class="login-cart-watermark">
                <i class="fa-solid fa-cart-shopping text-[150px]"></i>
            </div>

            <div class="relative z-10 flex min-h-screen flex-col justify-between px-10 py-8 xl:px-12">
                <div class="flex items-center gap-4">
                    <div class="brand-logo-frame h-14 w-14 overflow-hidden rounded-2xl p-1.5">
                        <img src="{{ asset($brandLogo) }}" alt="Logo Jayusman Minimarket" class="brand-logo-image">
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight">Jayusman Minimarket</h1>
                        <p class="mt-1 text-base font-medium text-white/82">Retail Management System</p>
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

                    <div class="mt-6 inline-flex max-w-md items-center gap-4 rounded-2xl border border-white/18 bg-white/10 px-5 py-3.5 shadow-2xl shadow-black/10 backdrop-blur">
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
                    <div class="rounded-2xl border border-white/18 bg-white/10 p-5 shadow-xl shadow-black/10 backdrop-blur">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#39d98a]">
                            <i class="fa-solid fa-store text-xl"></i>
                        </div>
                        <p class="text-2xl font-extrabold">5</p>
                        <p class="mt-1 text-lg font-extrabold">Cabang Aktif</p>
                        <p class="mt-2 text-sm text-white/75">Tersebar & Terhubung</p>
                    </div>
                    <div class="rounded-2xl border border-white/18 bg-white/10 p-5 shadow-xl shadow-black/10 backdrop-blur">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#ffd23f] text-[#062f5f]">
                            <i class="fa-solid fa-chart-column text-xl"></i>
                        </div>
                        <p class="text-xl font-extrabold">Real-time</p>
                        <p class="mt-1 text-lg font-extrabold">Transaksi</p>
                        <p class="mt-2 text-sm text-white/75">Update instan setiap saat</p>
                    </div>
                    <div class="rounded-2xl border border-white/18 bg-white/10 p-5 shadow-xl shadow-black/10 backdrop-blur">
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

        <section class="login-form-side flex items-center justify-center px-5 py-10">
            <div class="relative z-10 w-full max-w-xl">
                <div class="mb-8 flex items-center gap-4 lg:hidden">
                    <div class="brand-logo-frame h-14 w-14 overflow-hidden rounded-2xl p-1.5">
                        <img src="{{ asset($brandLogo) }}" alt="Logo Jayusman Minimarket" class="brand-logo-image">
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-[#062f5f]">Jayusman Minimarket</h1>
                        <p class="text-sm font-medium text-slate-500">Retail Management System</p>
                    </div>
                </div>

                <div class="login-card rounded-3xl border border-slate-200/80 bg-white/95 px-8 py-7 backdrop-blur md:px-10">
                    <div class="mb-6 text-center">
                        <div class="brand-logo-frame mx-auto mb-5 h-20 w-20 overflow-hidden rounded-3xl p-2.5">
                            <img src="{{ asset($brandLogo) }}" alt="Logo Jayusman Minimarket" class="brand-logo-image">
                        </div>
                        <h2 class="text-3xl font-extrabold tracking-tight text-[#062f5f]">Masuk ke Dashboard</h2>
                        <p class="mt-3 text-sm font-medium text-slate-500">Selamat datang dan bekerja dengan jujur</p>
                    </div>

                    @if(session('success'))
                        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                            <i class="fa-solid fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-3.5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-bold text-[#0b1f3f]">Email</label>
                            <div class="relative">
                                <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-12 pr-4 text-sm font-medium outline-none transition placeholder:text-slate-400 focus:border-[#0f5fb8] focus:ring-4 focus:ring-[#0f5fb8]/10 @error('email') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                                    placeholder="Masukkan email Anda"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus>
                            </div>
                            @error('email')
                                <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-bold text-[#0b1f3f]">Password</label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="password-input w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-12 pr-12 text-sm font-medium outline-none transition placeholder:text-slate-400 focus:border-[#0f5fb8] focus:ring-4 focus:ring-[#0f5fb8]/10 @error('password') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
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
                            @error('password')
                                <span class="mt-2 block text-xs font-medium text-red-600">{{ $message }}</span>
                            @enderror
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
                            type="submit"
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

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');
        const togglePasswordIcon = document.getElementById('toggle-password-icon');

        togglePassword?.addEventListener('click', () => {
            const shouldShowPassword = passwordInput.type === 'password';

            passwordInput.type = shouldShowPassword ? 'text' : 'password';
            togglePassword.setAttribute('aria-label', shouldShowPassword ? 'Sembunyikan password' : 'Tampilkan password');
            togglePassword.setAttribute('aria-pressed', String(shouldShowPassword));
            togglePasswordIcon.classList.toggle('fa-eye', !shouldShowPassword);
            togglePasswordIcon.classList.toggle('fa-eye-slash', shouldShowPassword);
        });
    </script>
</body>

</html>