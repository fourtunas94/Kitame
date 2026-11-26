@extends('layouts.app')

@section('title', 'Direktori UMKM & E-Katalog Lokal - KITAME Kota Medan')

@section('content')
<!-- HEADER SECTION -->
<section class="py-12 bg-cream border-b border-espresso/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                <span>Katalog Non-Transaksional Resmi</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-espresso">
                Direktori UMKM & E-Katalog Lokal Medan
            </h1>
            <p class="text-espresso/70 text-base mt-2 leading-relaxed">
                Temukan profil usaha mikro, kecil, dan menengah di Kota Medan. Informasi legalitas ditampilkan berdasarkan data yang dimasukkan pemilik usaha dan belum diverifikasi otomatis.
            </p>
        </div>
    </div>
</section>

<!-- ADVANCED FILTER BAR -->
<section class="py-6 bg-white border-b border-espresso/10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('umkm.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">

                <!-- Keyword Search -->
                <div class="md:col-span-4">
                    <div class="relative">
                        <svg class="w-4 h-4 text-espresso/40 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari usaha, olahan, atau nama..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                    </div>
                </div>

                <!-- Category Dropdown -->
                <div class="md:col-span-3">
                    <select name="category" class="w-full px-3 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30 cursor-pointer">
                        <option value="">Semua Kategori Usaha</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kecamatan Dropdown -->
                <div class="md:col-span-3">
                    <select name="kecamatan" class="w-full px-3 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30 cursor-pointer">
                        <option value="">Seluruh Kecamatan (21)</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="md:col-span-2 flex items-center space-x-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-espresso text-cream hover:bg-espresso-soft text-sm font-semibold transition">
                        Terapkan
                    </button>
                    @if(request()->hasAny(['keyword', 'category', 'kecamatan', 'verified']))
                        <a href="{{ route('umkm.index') }}" title="Reset Filter" class="p-2.5 rounded-xl border border-espresso/20 text-espresso hover:bg-espresso/5 transition">
                            ✕
                        </a>
                    @endif
                </div>

            </div>

            <!-- Checkbox Bar -->
            <div class="flex items-center space-x-6 text-xs text-espresso/80 pt-1">
                <label class="inline-flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="verified" value="1" {{ request('verified') == '1' ? 'checked' : '' }} onchange="this.form.submit()" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span class="font-medium">Hanya Tampilkan Terverifikasi E-Katalog Pemko Medan</span>
                </label>
                <span class="text-espresso/40">|</span>
                <span class="text-espresso/60">Ditemukan <strong>{{ $umkms->total() }}</strong> pelaku UMKM</span>
            </div>
        </form>
    </div>
</section>

<!-- 3-COLUMN GRID OF UMKM CARDS -->
<section class="py-12 bg-cream flex-grow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($umkms->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($umkms as $umkm)
                    <div class="bg-white rounded-2xl border border-espresso/10 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col group">

                        <!-- Thumbnail & Badges -->
                        <div class="relative h-52 overflow-hidden bg-cream-dark">
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

                            <div class="absolute bottom-3 right-3 px-2 py-1 rounded bg-black/60 backdrop-blur-sm text-[10px] text-white font-medium">
                                NIB: {{ substr($umkm->nib, 0, 7) }}••••
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-grow flex flex-col">
                            <div class="flex items-center space-x-2 text-xs text-espresso/60 mb-2">
                                <span class="font-semibold text-terracotta">{{ $umkm->category }}</span>
                                <span>•</span>
                                <span>{{ $umkm->kecamatan }}</span>
                            </div>

                            <h3 class="text-xl font-bold text-espresso mb-2 group-hover:text-emerald-700 transition">
                                <a href="{{ route('umkm.show', $umkm) }}">{{ $umkm->business_name }}</a>
                            </h3>

                            <p class="text-espresso/70 text-xs leading-relaxed line-clamp-3 mb-4">
                                {{ $umkm->description }}
                            </p>

                            <!-- Product Showcase Preview -->
                            @if($umkm->products->count() > 0)
                                <div class="mb-5 pt-3 border-t border-espresso/5">
                                    <span class="text-[10px] font-bold text-espresso/50 uppercase tracking-wider block mb-1.5">Katalog Produk Terdaftar:</span>
                                    <div class="space-y-1">
                                        @foreach($umkm->products->take(2) as $prod)
                                            <div class="flex items-center text-xs text-espresso/80 truncate">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 mr-2 flex-shrink-0"></span>
                                                <span class="truncate">{{ $prod->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Action Buttons: Strictly Non-Transactional Outlined "Lihat Detail Profil" + Direct WhatsApp Link -->
                            <div class="mt-auto pt-4 border-t border-espresso/10 grid grid-cols-2 gap-2">
                                <a href="{{ route('umkm.show', $umkm) }}" class="inline-flex items-center justify-center py-2.5 px-3 rounded-xl border border-espresso/20 text-espresso text-xs font-semibold hover:bg-espresso hover:text-white transition">
                                    <span>Lihat Profil</span>
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp) }}" target="_blank" class="inline-flex items-center justify-center py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition shadow-sm">
                                    <span>WhatsApp</span>
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $umkms->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-espresso/10 p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-cream mx-auto flex items-center justify-center text-espresso/40 text-2xl mb-4">
                    🔍
                </div>
                <h3 class="text-xl font-bold text-espresso mb-2">Tidak Ada UMKM Yang Sesuai</h3>
                <p class="text-xs text-espresso/60 leading-relaxed mb-6">
                    Kriteria pencarian Anda tidak menemukan hasil. Coba ganti kata kunci, kosongkan kecamatan, atau hilangkan centang filter E-Katalog.
                </p>
                <a href="{{ route('umkm.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-espresso text-cream text-xs font-semibold hover:bg-espresso-soft transition">
                    Reset Semua Filter
                </a>
            </div>
        @endif

    </div>
</section>
@endsection
