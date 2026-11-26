@extends('layouts.app')

@section('title', 'KITAME - Temukan Talenta & Peluang UMKM Medan')

@section('content')
<!-- HERO SECTION -->
<section class="relative pt-12 pb-20 md:pt-20 md:pb-28 overflow-hidden">
    <!-- Subtle Background Accents -->
    <div class="absolute inset-0 pointer-events-none opacity-40">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-emerald-100/50 blur-3xl"></div>
        <div class="absolute top-1/2 -left-24 w-80 h-80 rounded-full bg-terracotta/10 blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl mx-auto text-center space-y-5">



            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-espresso leading-[1.15]">
                Temukan Talenta & <br class="hidden sm:inline">
                <span class="font-editorial italic font-normal text-terracotta-dark">Peluang UMKM</span> Medan!
            </h1>

            <!-- Subheadline -->


            <!-- Quick Trust Metric Badges -->
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2 text-xs font-medium text-espresso/70">
                <div class="flex items-center space-x-1.5 bg-white/80 px-3 py-1 rounded-full border border-espresso/10">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    <span>Direktori UMKM Lokal</span>
                </div>
                <div class="flex items-center space-x-1.5 bg-white/80 px-3 py-1 rounded-full border border-espresso/10">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    <span>Profil Talenta Lokal</span>
                </div>
                <div class="flex items-center space-x-1.5 bg-white/80 px-3 py-1 rounded-full border border-espresso/10">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    <span>0% Biaya Platform (Bebas Komisi)</span>
                </div>
            </div>

        </div>

        <!-- SEARCH BAR (Three Inline Fields + Solid Green Action Button) -->
        <div class="max-w-4xl mx-auto mt-10">
            <form action="{{ route('umkm.index') }}" method="GET" class="bg-white p-3 rounded-2xl sm:rounded-3xl shadow-xl shadow-espresso/5 border border-espresso/10">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-center">

                    <!-- Field 1: Keyword Search -->
                    <div class="md:col-span-5 px-3 py-2">
                        <label class="block text-[10px] font-bold text-espresso/50 uppercase tracking-wider mb-0.5">Pencarian Usaha / Keahlian</label>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-espresso/40 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari keahlian, produk, atau nama usaha..." class="w-full text-sm font-medium text-espresso placeholder-espresso/40 bg-transparent focus:outline-none">
                        </div>
                    </div>

                    <div class="hidden md:block h-10 w-px bg-espresso/10"></div>

                    <!-- Field 2: Category Dropdown -->
                    <div class="md:col-span-3 px-3 py-2">
                        <label class="block text-[10px] font-bold text-espresso/50 uppercase tracking-wider mb-0.5">Pilih Kategori</label>
                        <select name="category" class="w-full text-sm font-medium text-espresso bg-transparent focus:outline-none cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat['name'] }}">{{ $cat['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="hidden md:block h-10 w-px bg-espresso/10"></div>

                    <!-- Field 3: Kecamatan Dropdown -->
                    <div class="md:col-span-2 px-3 py-2">
                        <label class="block text-[10px] font-bold text-espresso/50 uppercase tracking-wider mb-0.5">Pilih Kecamatan</label>
                        <select name="kecamatan" class="w-full text-sm font-medium text-espresso bg-transparent focus:outline-none cursor-pointer">
                            <option value="">21 Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec }}">{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div class="md:col-span-2 p-1">
                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition shadow flex items-center justify-center space-x-2">
                            <span>Cari</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </div>
</section>

<!-- CATEGORIES GRID ("Katalog & Kategori Utama" - 8 Cards) -->
<section class="py-16 bg-cream border-t border-espresso/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold text-terracotta uppercase tracking-widest">Eksplorasi Sektor</span>
                <h2 class="text-3xl font-bold tracking-tight text-espresso mt-1">Katalog & Kategori Utama</h2>
                <p class="text-espresso/60 text-sm mt-1">Pilihan sektor unggulan UMKM binaan dan klaster talenta Kota Medan</p>
            </div>
            <a href="{{ route('umkm.index') }}" class="hidden md:inline-flex items-center space-x-2 text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition">
                <span>Lihat Seluruh Katalog</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('umkm.index', ['category' => $category['name']]) }}" class="group relative rounded-2xl overflow-hidden aspect-[4/3] shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-end p-6 border border-white/20">
                    <!-- Background Image -->
                    <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <!-- Dark Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-espresso via-espresso/60 to-transparent"></div>

                    <!-- Content -->
                    <div class="relative z-10 text-white">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-lg font-bold group-hover:text-emerald-300 transition">{{ $category['name'] }}</h3>
                            <span class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition transform translate-x-1 group-hover:translate-x-0">
                                →
                            </span>
                        </div>
                        <p class="text-xs text-cream/80 line-clamp-2 leading-relaxed">
                            {{ $category['description'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>

<!-- HOW IT WORKS SECTION (3-Step Icon Process) -->
<section class="py-20 bg-white border-y border-espresso/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Alur Pelayanan Warga & Pelaku Usaha</span>
            <h2 class="text-3xl font-bold tracking-tight text-espresso mt-1">Transparansi Informasi Tiga Langkah</h2>
            <p class="text-espresso/60 text-sm mt-2">Mendukung ekosistem ekonomi lokal Medan yang adil, kredibel, dan tanpa perantara berbayar.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">

            <!-- Step 1 -->
            <div class="bg-cream/40 rounded-2xl p-8 border border-espresso/10 relative group hover:border-espresso/30 transition">
                <div class="w-12 h-12 rounded-xl bg-espresso text-cream flex items-center justify-center font-bold text-lg mb-6 shadow-sm">
                    1
                </div>
                <h3 class="text-xl font-bold text-espresso mb-3">Daftar & Verifikasi NIK/NIB</h3>
                <p class="text-espresso/70 text-sm leading-relaxed">
                    Pelaku usaha mendaftarkan NIB resmi OSS RBA, dan talenta pekerja mandiri memvalidasi NIK KTP Medan serta bukti sertifikasi kompetensi dari Disnaker / BNSP.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-cream/40 rounded-2xl p-8 border border-espresso/10 relative group hover:border-espresso/30 transition">
                <div class="w-12 h-12 rounded-xl bg-terracotta text-white flex items-center justify-center font-bold text-lg mb-6 shadow-sm">
                    2
                </div>
                <h3 class="text-xl font-bold text-espresso mb-3">Cari Direktori atau Pengadaan</h3>
                <p class="text-espresso/70 text-sm leading-relaxed">
                    Masyarakat dan instansi menelusuri katalog profil usaha, sedangkan penyedia meninjau kebutuhan paket pengadaan serta lowongan proyek yang diumumkan dinas.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-cream/40 rounded-2xl p-8 border border-espresso/10 relative group hover:border-espresso/30 transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg mb-6 shadow-sm">
                    3
                </div>
                <h3 class="text-xl font-bold text-espresso mb-3">Kolaborasi Langsung Tanpa Komisi</h3>
                <p class="text-espresso/70 text-sm leading-relaxed">
                    Hubungi produsen langsung melalui kontak resmi WhatsApp/Email, atau ajukan surat minat secara resmi ke panitia dinas tanpa potongan komisi sepeser pun.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- FEATURED UMKM SECTION (3-Column Grid, Zero Cart / Checkout) -->
<section class="py-20 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span>Tersertifikasi OSS & E-Katalog</span>
                </div>
                <h2 class="text-3xl font-bold tracking-tight text-espresso">Pelaku UMKM Pilihan Medan</h2>
                <p class="text-espresso/60 text-sm mt-1">Siap bekerjasama untuk kebutuhan konsumsi kantor, cinderamata, dan cinderamata khas daerah</p>
            </div>
            <a href="{{ route('umkm.index') }}" class="mt-4 md:mt-0 inline-flex items-center space-x-2 text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                <span>Buka Seluruh Direktori UMKM</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredUmkms as $umkm)
                <div class="bg-white rounded-2xl border border-espresso/10 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col group">
                    <!-- Thumbnail with Badge -->
                    <div class="relative h-48 overflow-hidden bg-cream-dark">
                        @if($umkm->cover_image_url)
                            <img src="{{ $umkm->cover_image_url }}" alt="{{ $umkm->business_name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-cream text-espresso/40 text-sm font-semibold">Foto usaha belum tersedia</div>
                        @endif
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5 items-start">
                            <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-600 text-white shadow-sm">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                {{ $umkm->e_catalog_pemko ? 'Terdaftar E-Katalog Pemko' : 'Profil UMKM' }}
                            </span>
                            @if($umkm->e_catalog_pemko)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                    ★ E-Katalog Pemko
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="flex items-center space-x-2 text-xs text-espresso/60 mb-2">
                            <span class="font-semibold text-terracotta">{{ $umkm->category }}</span>
                            <span>•</span>
                            <span>{{ $umkm->kecamatan }}</span>
                        </div>

                        <h3 class="text-xl font-bold text-espresso mb-2 group-hover:text-emerald-700 transition">
                            <a href="{{ route('umkm.show', $umkm) }}">{{ $umkm->business_name }}</a>
                        </h3>

                        <p class="text-espresso/70 text-xs leading-relaxed line-clamp-2 mb-4">
                            {{ $umkm->description }}
                        </p>

                        <!-- Product Snippet -->
                        @if($umkm->products->count() > 0)
                            <div class="mb-5 pt-3 border-t border-espresso/5">
                                <span class="text-[10px] font-bold text-espresso/50 uppercase tracking-wider block mb-1.5">Katalog Produk Tersedia:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($umkm->products->take(2) as $prod)
                                        <span class="text-[11px] bg-cream px-2 py-1 rounded-md text-espresso/80 border border-espresso/10">
                                            {{ $prod->name }}
                                        </span>
                                    @endforeach
                                    @if($umkm->products->count() > 2)
                                        <span class="text-[11px] bg-cream px-1.5 py-1 rounded-md text-espresso/50">
                                            +{{ $umkm->products->count() - 2 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Action Button (Strictly Outlined Non-Transactional "Lihat Detail Profil") -->
                        <div class="mt-auto pt-2">
                            <a href="{{ route('umkm.show', $umkm) }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 rounded-xl border border-espresso/20 text-espresso text-sm font-semibold hover:bg-espresso hover:text-white transition">
                                <span>Lihat Detail Profil</span>
                                <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- MEDAN TALENT HUB PREVIEW -->
<section class="py-20 bg-white border-t border-espresso/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-semibold mb-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>Disnaker & Disdukcapil Validated</span>
                </div>
                <h2 class="text-3xl font-bold tracking-tight text-espresso">Medan Talent Hub</h2>
                <p class="text-espresso/60 text-sm mt-1">Tenaga ahli profesional terverifikasi kependudukan dan kompetensi resmi Kota Medan</p>
            </div>
            <a href="{{ route('talents.index') }}" class="mt-4 md:mt-0 inline-flex items-center space-x-2 text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                <span>Jelajahi Semua Talenta</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredTalents as $talent)
                <div class="bg-cream/40 rounded-2xl p-6 border border-espresso/10 hover:border-espresso/30 transition flex flex-col">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-espresso text-cream font-bold text-lg flex items-center justify-center flex-shrink-0">
                            {{ strtoupper(substr($talent->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-espresso leading-snug line-clamp-1">{{ $talent->user->name }}</h3>
                            <span class="text-[11px] text-terracotta font-semibold">{{ $talent->category }}</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-1.5 mb-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                            Profil Talenta
                        </span>
                        @if($talent->disnaker_certified)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-100 text-blue-800">
                                Disnaker Certified
                            </span>
                        @endif
                    </div>

                    <p class="text-xs text-espresso/70 leading-relaxed line-clamp-3 mb-4 flex-grow">
                        {{ $talent->bio }}
                    </p>

                    <div class="pt-3 border-t border-espresso/5 text-xs text-espresso/60 flex items-center justify-between mb-4">
                        <span>{{ $talent->kecamatan }}</span>
                        <a href="{{ $talent->portfolio_url }}" target="_blank" class="text-emerald-700 font-semibold hover:underline">
                            Portofolio ↗
                        </a>
                    </div>

                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $talent->user->phone) }}" target="_blank" class="w-full text-center py-2 px-3 rounded-xl bg-white border border-espresso/20 text-xs font-semibold text-espresso hover:bg-espresso hover:text-white transition">
                        Hubungi Talenta
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- LATEST PROCUREMENT & JOB VACANCIES SECTION -->
<section class="py-20 bg-cream border-t border-espresso/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-bold text-terracotta uppercase tracking-widest">Peluang Kerja Sama</span>
                <h2 class="text-3xl font-bold tracking-tight text-espresso mt-1">Pengadaan & Proyek Pemko</h2>
                <p class="text-espresso/60 text-sm mt-1">Informasi terbuka paket kebutuhan barang, konsumsi, dan tenaga ahli OPD Kota Medan</p>
            </div>
            <a href="{{ route('announcements.index') }}" class="mt-4 md:mt-0 inline-flex items-center space-x-2 text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                <span>Buka Papan Pengumuman Lengkap</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <div class="space-y-4">
            @foreach($latestAnnouncements as $ann)
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-espresso/10 hover:border-espresso/30 transition shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2 max-w-3xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $ann->type === 'procurement' ? 'bg-amber-100 text-amber-900' : 'bg-blue-100 text-blue-900' }}">
                                {{ $ann->type === 'procurement' ? 'Pengadaan UMKM / Katering' : 'Lowongan Proyek Talenta' }}
                            </span>
                            <span class="text-xs font-semibold text-espresso/60">
                                {{ $ann->agency }}
                            </span>
                            <span class="text-xs text-espresso/40">• {{ $ann->location }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-espresso hover:text-emerald-700 transition">
                            <a href="{{ route('announcements.apply', $ann) }}">{{ $ann->title }}</a>
                        </h3>
                        <p class="text-xs text-espresso/70 line-clamp-2 leading-relaxed">
                            {{ $ann->description }}
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row md:flex-col items-start sm:items-center md:items-end justify-between gap-3 flex-shrink-0 border-t md:border-t-0 pt-4 md:pt-0 border-espresso/10">
                        <div class="text-left md:text-right">
                            <div class="text-xs text-espresso/50">Estimasi Pagu Anggaran</div>
                            <div class="text-base font-bold text-emerald-700">{{ $ann->budget_estimate }}</div>
                            <div class="text-[11px] text-red-600 font-medium">Batas: {{ $ann->deadline->format('d M Y') }}</div>
                        </div>
                        <a href="{{ route('announcements.apply', $ann) }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-espresso text-cream text-xs font-semibold hover:bg-espresso-soft transition shadow-sm">
                            <span>Ajukan Minat & Lihat Detail</span>
                            <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- ABOUT SECTION -->
<section id="tentang" class="py-20 bg-espresso text-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-emerald-400">
                    <span>Komitmen Pemerintahan Terbuka</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-white leading-tight">
                    Mewujudkan Kemandirian Ekonomi Warga Kota Medan Berbasis Informasi Lokal.
                </h2>
                <p class="text-cream/80 text-sm leading-relaxed">
                    KITAME (Katalog Informasi Talenta & UMKM Medan) dihadirkan sebagai jembatan informasi resmi yang bebas intervensi komersial pihak ketiga. Kami tidak menarik persentase keuntungan, tidak memungut biaya langganan, dan tidak memonopoli jalur transaksi.
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 pt-4 border-t border-white/10 text-center">
                    <div>
                        <div class="text-3xl font-extrabold text-white">{{ $stats['umkm_count'] }}+</div>
                        <div class="text-xs text-cream/60 mt-1">UMKM Terdaftar</div>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-white">{{ $stats['talent_count'] }}+</div>
                        <div class="text-xs text-cream/60 mt-1">Profil Talenta</div>
                    </div>
                    <div>
                        <div class="text-3xl font-extrabold text-white">{{ $stats['kecamatan_count'] }}</div>
                        <div class="text-xs text-cream/60 mt-1">Kecamatan Aktif</div>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 p-8 rounded-3xl border border-white/10 space-y-4">
                <h3 class="text-xl font-bold text-white">Prinsip Pokok Layanan KITAME:</h3>
                <ul class="space-y-3 text-sm text-cream/80">
                    <li class="flex items-start space-x-3">
                        <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 text-xs mt-0.5">✓</span>
                        <span><strong>Bebas Kartel & Monopoli:</strong> Seluruh UMKM ber-NIB mendapatkan kesempatan eksposur yang setara di hadapan instansi dan masyarakat.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 text-xs mt-0.5">✓</span>
                        <span><strong>Verifikasi Sahih Bertingkat:</strong> Validasi data NIB terintegrasi sistem OSS dan NIK KTP terverifikasi Disdukcapil Kota Medan.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center flex-shrink-0 text-xs mt-0.5">✓</span>
                        <span><strong>Efisiensi Anggaran APBD:</strong> Mempermudah PPK dan Pejabat Pengadaan dinas menemukan rekanan lokal tanpa perantara mahal.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
