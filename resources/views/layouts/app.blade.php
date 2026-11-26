<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KITAME - Katalog Informasi Talenta & UMKM Medan')</title>

    <!-- Google Fonts: Plus Jakarta Sans & Newsreader for editorial elegance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400..700;1,6..72,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #F9F6F0;
            color: #2B2118;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-editorial {
            font-family: 'Newsreader', Georgia, serif;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-cream text-espresso antialiased">

    @php
        $isAdminArea = request()->routeIs('admin.*');
    @endphp

    @unless($isAdminArea)
        <!-- Main Navigation Bar -->
        <header class="sticky top-0 z-40 bg-cream/90 backdrop-blur-md border-b border-espresso/10 transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">

                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                            <img src="{{ asset('images/logo-kitame.jpg') }}" alt="KITAME - Katalog Informasi Talenta & UMKM Medan" class="h-14 w-14 rounded-lg object-cover shadow-sm transition group-hover:shadow-md">
                        </a>
                    </div>

                    <!-- Center Navigation Links -->
                    <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-espresso/80">
                        <a href="{{ route('umkm.index') }}" class="hover:text-emerald-700 transition {{ request()->routeIs('umkm.*') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : '' }}">
                            Direktori UMKM
                        </a>
                        <a href="{{ route('talents.index') }}" class="hover:text-emerald-700 transition {{ request()->routeIs('talents.*') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : '' }}">
                            Medan Talent Hub
                        </a>
                        <a href="{{ route('announcements.index') }}" class="hover:text-emerald-700 transition {{ request()->routeIs('announcements.*') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : '' }}">
                            Pengadaan Pemko
                        </a>
                        <a href="{{ route('home') }}#tentang" class="hover:text-emerald-700 transition">
                            Tentang Kami
                        </a>
                    </nav>

                    <!-- Right Action Buttons (Functional Masuk & Daftar) -->
                    <div class="flex items-center space-x-3">
                        @auth
                            @php
                                $userApps = Auth::user()->applications()->with('announcement')->latest()->take(5)->get();
                                $hasUpdates = $userApps->whereIn('status', ['accepted', 'reviewed', 'rejected'])->isNotEmpty();
                            @endphp

                            <!-- Notification Bell Dropdown -->
                            <div class="relative">
                                <button type="button"
                                        onclick="document.getElementById('notif-dropdown').classList.toggle('hidden')"
                                        class="relative p-2 rounded-full border border-espresso/15 bg-white hover:bg-cream text-espresso/70 hover:text-espresso transition shadow-sm"
                                        title="Notifikasi Pengajuan Minat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                    @if($userApps->isNotEmpty())
                                        <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full {{ $hasUpdates ? 'bg-emerald-600 animate-pulse' : 'bg-amber-500' }}"></span>
                                    @endif
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="notif-dropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 rounded-2xl bg-white border border-espresso/15 shadow-xl z-50 overflow-hidden text-espresso">
                                    <div class="px-4 py-3 bg-cream/70 border-b border-espresso/10 flex items-center justify-between">
                                        <span class="text-xs font-bold uppercase tracking-wider text-espresso">Notifikasi Pengajuan</span>
                                        <span class="text-[10px] text-espresso/50">{{ $userApps->count() }} pengajuan</span>
                                    </div>
                                    <div class="divide-y divide-espresso/10 max-h-80 overflow-y-auto">
                                        @forelse($userApps as $nApp)
                                            <a href="{{ route('announcements.my_applications') }}" class="block p-3.5 hover:bg-cream/50 transition">
                                                <div class="flex items-center justify-between gap-2 mb-1">
                                                    <span class="text-[10px] font-bold uppercase {{ $nApp->announcement->type === 'procurement' ? 'text-amber-800' : 'text-blue-800' }}">
                                                        {{ $nApp->announcement->type === 'procurement' ? 'Pengadaan' : 'Lowongan' }}
                                                    </span>
                                                    @if($nApp->status === 'accepted')
                                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">✅ Diterima</span>
                                                    @elseif($nApp->status === 'reviewed')
                                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 text-blue-800">🔍 Ditinjau</span>
                                                    @elseif($nApp->status === 'rejected')
                                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-100 text-rose-800">❌ Belum Terpilih</span>
                                                    @else
                                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">⏳ Menunggu</span>
                                                    @endif
                                                </div>
                                                <p class="text-xs font-semibold text-espresso line-clamp-1">{{ $nApp->announcement->title }}</p>
                                                <p class="text-[11px] text-espresso/55 mt-0.5">{{ $nApp->announcement->agency }} · {{ $nApp->updated_at->diffForHumans() }}</p>
                                            </a>
                                        @empty
                                            <div class="p-6 text-center text-xs text-espresso/60">
                                                Belum ada pengajuan minat yang dikirimkan.
                                            </div>
                                        @endforelse
                                    </div>
                                    <div class="p-2.5 bg-cream/50 border-t border-espresso/10 text-center">
                                        <a href="{{ route('announcements.my_applications') }}" class="text-xs font-bold text-emerald-800 hover:underline">
                                            Lihat Semua Status Lamaran Saya →
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="relative group">
                                <div class="flex items-center gap-2.5 rounded-full border border-espresso/10 bg-white px-2.5 py-1.5 shadow-sm transition hover:border-espresso/25">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div class="hidden text-left sm:block">
                                        <div class="text-[11px] font-semibold leading-none text-espresso line-clamp-1">{{ Auth::user()->name }}</div>
                                        <div class="mt-0.5 text-[9px] uppercase tracking-[0.12em] text-espresso/55">{{ str_replace('_', ' ', Auth::user()->role) }}</div>
                                    </div>

                                    <div class="flex items-center gap-1.5">
                                        @if (Auth::user()->role === 'umkm')
                                            <a href="{{ route('umkm.manage') }}" class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 transition hover:bg-emerald-100 whitespace-nowrap">
                                                Profil
                                            </a>
                                        @elseif (Auth::user()->role === 'talent')
                                            <a href="{{ route('talent.profile') }}" class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 transition hover:bg-emerald-100 whitespace-nowrap">
                                                Profil
                                            </a>
                                        @elseif (Auth::user()->role === 'admin_pemko')
                                            <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold text-emerald-700 transition hover:bg-emerald-100 whitespace-nowrap">
                                                Admin
                                            </a>
                                        @endif

                                        <form method="POST" action="{{ route('logout') }}" class="inline">
                                            @csrf
                                            <button type="submit" title="Keluar" class="rounded-full border border-red-200 bg-red-50 px-2.5 py-1 text-[10px] font-semibold text-red-600 transition hover:bg-red-100 hover:text-red-700">
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <button type="button" onclick="openLoginModal()" class="px-5 py-2.5 rounded-full text-sm font-medium text-espresso hover:bg-espresso/5 transition border border-transparent hover:border-espresso/15">
                                Masuk
                            </button>
                            <button type="button" onclick="openRegisterModal()" class="px-5 py-2.5 rounded-full text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm hover:shadow">
                                Daftar
                            </button>
                        @endauth
                    </div>

                </div>
            </div>

            <!-- Mobile Navigation Row -->
            <div class="md:hidden flex items-center justify-around py-2.5 border-t border-espresso/10 bg-cream/95 text-xs font-medium text-espresso/70">
                <a href="{{ route('umkm.index') }}" class="{{ request()->routeIs('umkm.*') ? 'text-emerald-700 font-bold' : '' }}">UMKM</a>
                <a href="{{ route('talents.index') }}" class="{{ request()->routeIs('talents.*') ? 'text-emerald-700 font-bold' : '' }}">Talenta</a>
                <a href="{{ route('announcements.index') }}" class="{{ request()->routeIs('announcements.index') ? 'text-emerald-700 font-bold' : '' }}">Pengadaan</a>
                <a href="{{ route('home') }}#tentang">Tentang</a>
            </div>
        </header>

        @auth
            @php
                $acceptedNotification = Auth::user()->applications()->with('announcement')->where('status', 'accepted')->latest()->first();
            @endphp
            @if($acceptedNotification)
                <div class="bg-emerald-700 text-white px-4 py-2.5 text-xs shadow-sm">
                    <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span class="text-base">🎉</span>
                            <span><strong>Kabar Baik:</strong> Pengajuan Anda untuk <strong>"{{ $acceptedNotification->announcement->title }}"</strong> telah <strong>Disetujui</strong> oleh {{ $acceptedNotification->announcement->agency }}!</span>
                        </div>
                        <a href="{{ route('announcements.my_applications') }}" class="underline font-bold hover:text-emerald-100 shrink-0">Lihat Status Lamaran →</a>
                    </div>
                </div>
            @endif
        @endauth
    @endunless

    <!-- Global Notification Banner / Flash Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border-b border-emerald-200 px-4 py-3 text-sm text-emerald-800 flex items-center justify-between">
            <div class="max-w-7xl mx-auto w-full flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-b border-red-200 px-4 py-3 text-sm text-red-800">
            <div class="max-w-7xl mx-auto">
                <p class="font-semibold mb-1">Perhatian:</p>
                <ul class="list-disc list-inside text-xs space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-grow flex flex-col">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-espresso text-cream pt-16 pb-12 mt-auto border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-white/10">

                <!-- Col 1: Brand & Gov Identity -->
                <div class="md:col-span-1 space-y-4">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo-kitame.jpg') }}" alt="KITAME - Katalog Informasi Talenta & UMKM Medan" class="h-12 w-12 rounded-lg object-cover">
                    </div>
                    <p class="text-cream/70 text-sm leading-relaxed">
                        Katalog Informasi Talenta & UMKM Medan — Kanal resmi non-transaksional Pemerintah Kota Medan untuk mempertemukan potensi usaha lokal dan talenta profesional dengan kebutuhan pengadaan daerah serta warga.
                    </p>
                    <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-xs text-cream/80">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Non-Commercial G2C & G2B Hub</span>
                    </div>
                </div>

                <!-- Col 2: Direktori & Layanan -->
                <div>
                    <h4 class="text-white font-semibold text-sm tracking-wider uppercase mb-4">Direktori Publik</h4>
                    <ul class="space-y-2.5 text-sm text-cream/70">
                        <li><a href="{{ route('umkm.index') }}" class="hover:text-white transition">Katalog Pelaku Usaha UMKM</a></li>
                        <li><a href="{{ route('umkm.index', ['verified' => 1]) }}" class="hover:text-white transition">Pelaku Usaha E-Katalog Pemko</a></li>
                        <li><a href="{{ route('talents.index') }}" class="hover:text-white transition">Medan Talent Hub</a></li>
                        <li><a href="{{ route('talents.index', ['certified' => 1]) }}" class="hover:text-white transition">Talenta Tersertifikasi Disnaker</a></li>
                        <li><a href="{{ route('announcements.index') }}" class="hover:text-white transition">Pengumuman Pengadaan Pemko</a></li>
                    </ul>
                </div>

                <!-- Col 3: Regulasi & Kebijakan -->
                <div>
                    <h4 class="text-white font-semibold text-sm tracking-wider uppercase mb-4">Kebijakan & Transparansi</h4>
                    <ul class="space-y-2.5 text-sm text-cream/70">
                        <li><span class="hover:text-white cursor-pointer">Pakta Integritas Non-Transaksional</span></li>
                        <li><span class="hover:text-white cursor-pointer">Verifikasi NIB via OSS RBA</span></li>
                        <li><span class="hover:text-white cursor-pointer">Verifikasi NIK Disdukcapil</span></li>
                        <li><span class="hover:text-white cursor-pointer">Standar Sertifikasi Disnaker Medan</span></li>
                        <li><span class="hover:text-white cursor-pointer">Bebas Pungutan & Komisi Transaksi</span></li>
                    </ul>
                </div>

                <!-- Col 4: Sekretariat & Kontak Layanan -->
                <div class="space-y-3">
                    <h4 class="text-white font-semibold text-sm tracking-wider uppercase mb-4">Sekretariat Pelayanan</h4>
                    <p class="text-cream/70 text-sm leading-relaxed">
                        Balai Kota Medan, Jl. Kapten Maulana Lubis No. 2, Petisah Tengah, Kec. Medan Petisah, Kota Medan, Sumatera Utara 20112
                    </p>
                    <div class="pt-2 text-xs text-cream/70 space-y-1">
                        <p><strong class="text-white">Email Dukungan:</strong> ppid@pemkomedan.go.id</p>
                        <p><strong class="text-white">Helpdesk WhatsApp:</strong> +62 811-6001-001</p>
                        <p><strong class="text-white">Jam Operasional:</strong> Senin – Jumat, 08.00 – 16.00 WIB</p>
                    </div>
                </div>

            </div>

            <!-- Bottom Disclaimer -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-cream/50 gap-4">
                <p>© 2026 Pemerintah Kota Medan. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="text-center sm:text-right">
                    KITAME tidak memfasilitasi transaksi pembayaran langsung ataupun keranjang belanja (No Cart / Checkout). Seluruh kesepakatan berlangsung langsung secara transparan antar-pihak.
                </p>
            </div>
        </div>
    </footer>

    <!-- MODAL MASUK (LOGIN) -->
    <div id="loginModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-8 shadow-2xl border border-espresso/10 relative transition-all">
            <button onclick="closeLoginModal()" class="absolute top-5 right-5 text-espresso/40 hover:text-espresso text-xl">
                ✕
            </button>
            <div class="mb-6">
                <img src="{{ asset('images/logo-kitame.jpg') }}" alt="Logo KITAME" class="mb-3 h-12 w-12 rounded-lg object-cover">
                <h3 class="text-2xl font-bold text-espresso tracking-tight">Masuk ke Portal KITAME</h3>
                <p class="text-espresso/60 text-sm mt-1">Akses akun UMKM, Talenta, atau Verifikator Pemko Medan</p>
            </div>

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-espresso uppercase tracking-wider mb-1.5">Alamat Email Resmi</label>
                    <input type="email" name="email" required placeholder="nama@instansi.go.id atau email usaha" class="w-full px-4 py-3 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-semibold text-espresso uppercase tracking-wider">Kata Sandi</label>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                </div>
                <div class="flex items-center justify-between text-xs text-espresso/70 pt-1">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-emerald-600 focus:ring-emerald-500">
                        <span>Ingat saya di peramban ini</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="font-semibold text-emerald-700 hover:underline">Lupa kata sandi?</a>
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-espresso text-cream font-semibold hover:bg-espresso-soft transition shadow text-sm mt-2">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-espresso/10 text-center text-xs text-espresso/70">
                Belum memiliki akun terdaftar?
                <button type="button" onclick="closeLoginModal(); openRegisterModal();" class="text-emerald-700 font-bold hover:underline">
                    Daftar di sini
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL DAFTAR (REGISTER) -->
    <div id="registerModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl max-w-lg w-full p-8 shadow-2xl border border-espresso/10 relative my-8">
            <button onclick="closeRegisterModal()" class="absolute top-5 right-5 text-espresso/40 hover:text-espresso text-xl">
                ✕
            </button>
            <div class="mb-5">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg mb-3">
                    +
                </div>
                <h3 class="text-2xl font-bold text-espresso tracking-tight">Pendaftaran Akun Baru</h3>
                <p class="text-espresso/60 text-sm mt-1">Daftarkan usaha atau keahlian Anda untuk terhubung dengan ekosistem Kota Medan</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-espresso uppercase tracking-wider mb-1.5">Pilih Kategori Pendaftar</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex flex-col items-center p-3 rounded-xl border border-espresso/20 cursor-pointer hover:border-emerald-600 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50 text-center">
                            <input type="radio" name="role" value="umkm" checked class="sr-only">
                            <span class="text-sm font-bold text-espresso">Pelaku UMKM</span>
                            <span class="text-[10px] text-espresso/60 mt-0.5">Punya Produk / NIB</span>
                        </label>
                        <label class="flex flex-col items-center p-3 rounded-xl border border-espresso/20 cursor-pointer hover:border-emerald-600 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50 text-center">
                            <input type="radio" name="role" value="talent" class="sr-only">
                            <span class="text-sm font-bold text-espresso">Talenta / Jasa</span>
                            <span class="text-[10px] text-espresso/60 mt-0.5">Profesional / Ahli</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-espresso uppercase tracking-wider mb-1.5">Nama Lengkap / Nama Badan Usaha</label>
                    <input type="text" name="name" required placeholder="Contoh: Bolu Meranti / Rizky Siregar" class="w-full px-4 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-espresso uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input type="email" name="email" required placeholder="email@domain.com" class="w-full px-4 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-espresso uppercase tracking-wider mb-1.5">WhatsApp Aktif</label>
                        <input type="text" name="phone" required placeholder="081234567890" class="w-full px-4 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-espresso uppercase tracking-wider mb-1.5">Kata Sandi</label>
                        <input type="password" name="password" required placeholder="Min. 8 karakter" class="w-full px-4 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-espresso uppercase tracking-wider mb-1.5">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi sandi" class="w-full px-4 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition shadow text-sm">
                        Daftar Akun KITAME Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-5 pt-4 border-t border-espresso/10 text-center text-xs text-espresso/70">
                Sudah memiliki akun?
                <button type="button" onclick="closeRegisterModal(); openLoginModal();" class="text-espresso font-bold hover:underline">
                    Masuk ke sini
                </button>
            </div>
        </div>
    </div>

    <!-- Interactive Modal Scripts -->
    <script>
        function openLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
        }
        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }
        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
        }
        function closeRegisterModal() {
            document.getElementById('registerModal').classList.add('hidden');
        }
        // Close modal on background click
        window.onclick = function(event) {
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');
            if (event.target === loginModal) {
                closeLoginModal();
            }
            if (event.target === registerModal) {
                closeRegisterModal();
            }
        }

        @if(session('auth_required'))
            openLoginModal();
        @endif
    </script>

    @stack('scripts')
</body>
</html>