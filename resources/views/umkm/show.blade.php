@extends('layouts.app')

@section('title', $umkm->business_name . ' - Profil Resmi UMKM Medan')

@section('content')
<!-- BREADCRUMB -->
<div class="bg-white border-b border-espresso/10 py-3 text-xs text-espresso/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-2">
        <a href="{{ route('home') }}" class="hover:text-espresso">Beranda</a>
        <span>/</span>
        <a href="{{ route('umkm.index') }}" class="hover:text-espresso">Direktori UMKM</a>
        <span>/</span>
        <span class="text-espresso font-semibold truncate">{{ $umkm->business_name }}</span>
    </div>
</div>

<!-- SPLIT COVER & PROFILE HEADER -->
<section class="py-10 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl border border-espresso/10 overflow-hidden shadow-sm">

            <!-- Cover Banner -->
            <div class="relative h-64 sm:h-80 w-full overflow-hidden bg-espresso">
                @if($umkm->cover_image_url)
                    <img src="{{ $umkm->cover_image_url }}" alt="{{ $umkm->business_name }}" class="w-full h-full object-cover opacity-90">
                @else
                    <div class="w-full h-full flex items-center justify-center text-white/70 text-sm">Foto sampul belum tersedia</div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-espresso/90 via-espresso/30 to-transparent"></div>

                <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white p-1 shadow-lg overflow-hidden border-2 border-white flex-shrink-0">
                            @if($umkm->logo_url)
                                <img src="{{ $umkm->logo_url }}" alt="{{ $umkm->business_name }} Logo" class="w-full h-full object-cover rounded-xl">
                            @else
                                <div class="w-full h-full flex items-center justify-center rounded-xl bg-cream text-espresso font-bold">{{ strtoupper(substr($umkm->business_name, 0, 1)) }}</div>
                            @endif
                        </div>
                        <div class="text-white">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-600 text-white flex items-center space-x-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    {{ $umkm->e_catalog_pemko ? 'Terdaftar E-Katalog Pemko' : 'Profil UMKM' }}
                                </span>
                                @if($umkm->e_catalog_pemko)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-400 text-espresso">
                                        ★ E-Katalog Pemko Medan
                                    </span>
                                @endif
                            </div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white">{{ $umkm->business_name }}</h1>
                            <p class="text-xs sm:text-sm text-cream/80 flex items-center space-x-2 mt-1">
                                <span>{{ $umkm->category }}</span>
                                <span>•</span>
                                <span>{{ $umkm->kecamatan }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Direct Action Buttons -->
                    <div class="flex items-center space-x-3 w-full sm:w-auto">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp) }}?text=Halo%20{{ urlencode($umkm->business_name) }},%20saya%20melihat%20katalog%20Anda%20di%20portal%20resmi%20KITAME%20Pemko%20Medan." target="_blank" class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold shadow-sm transition">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>Hubungi via WhatsApp</span>
                        </a>
                        <a href="mailto:{{ $umkm->email }}?subject=Inquiry%20Kerjasama%20Pengadaan%20-%20KITAME%20Medan" class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 py-3 rounded-xl bg-white/20 hover:bg-white/30 backdrop-blur-md text-white text-sm font-semibold border border-white/30 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Kirim Email</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Info Sub-Bar -->
            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-3 gap-6 bg-cream/30 border-t border-espresso/10">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-espresso/50 uppercase tracking-wider block">Alamat Usaha & Produksi</span>
                    <p class="text-xs text-espresso/80 leading-relaxed">{{ $umkm->address }}</p>
                </div>
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-espresso/50 uppercase tracking-wider block">Informasi Legalitas</span>
                    <p class="text-xs text-espresso/80">
                        <strong>NIB:</strong> {{ $umkm->nib ?: 'Belum dicantumkan' }}<br>
                        Data NIB dimasukkan pemilik dan belum diverifikasi otomatis.
                    </p>
                </div>
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-espresso/50 uppercase tracking-wider block">Kontak Penanggung Jawab</span>
                    <p class="text-xs text-espresso/80">
                        <strong>Pemilik / PIC:</strong> {{ $umkm->user->name }}<br>
                        <strong>WhatsApp:</strong> {{ $umkm->whatsapp }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MAIN CONTENT: DESCRIPTION, GOVERNMENT PROCUREMENT NOTICE, & PRODUCT SHOWCASE -->
<section class="py-10 bg-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left Column: Products Showcase (8 Cols) -->
            <div class="lg:col-span-8 space-y-8">

                <!-- Business Description -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-espresso/10 shadow-sm">
                    <h2 class="text-xl font-bold text-espresso mb-3">Tentang {{ $umkm->business_name }}</h2>
                    <p class="text-sm text-espresso/80 leading-relaxed">
                        {{ $umkm->description }}
                    </p>
                </div>

                <!-- Product Showcase Grid (STRICTLY NON-TRANSACTIONAL, NO PRICES, NO CART) -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-espresso/10 shadow-sm">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-espresso/10">
                        <div>
                            <h2 class="text-xl font-bold text-espresso">Katalog Produk & Portofolio Olahan</h2>
                            <p class="text-xs text-espresso/60 mt-0.5">Spesifikasi komoditas untuk kebutuhan pengadaan dinas, hajatan, atau konsumsi warga</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cream text-espresso/70 border border-espresso/10">
                            {{ $umkm->products->count() }} Produk Terdaftar
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($umkm->products as $product)
                            <div class="rounded-xl border border-espresso/10 overflow-hidden bg-cream/20 flex flex-col hover:border-espresso/30 transition">
                                <div class="h-44 overflow-hidden bg-cream-dark">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-espresso/40 text-sm">Foto produk belum tersedia</div>
                                    @endif
                                </div>
                                <div class="p-4 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-base font-bold text-espresso mb-1">{{ $product->name }}</h3>
                                        <p class="text-xs text-espresso/70 leading-relaxed">
                                            {{ $product->description }}
                                        </p>
                                    </div>
                                    <div class="mt-4 pt-3 border-t border-espresso/5 flex items-center justify-between">
                                        <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-md">
                                            Non-Transaksional • Info & Spesifikasi
                                        </span>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $umkm->whatsapp) }}?text=Halo%20{{ urlencode($umkm->business_name) }},%20saya%20tertarik%20dengan%20produk%20'{{ urlencode($product->name) }}'%20di%20KITAME." target="_blank" class="text-xs font-semibold text-espresso hover:text-emerald-700 transition">
                                            Tanya Info ↗
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Notice inside product showcase -->
                    <div class="mt-8 p-4 rounded-xl bg-cream border border-espresso/10 text-xs text-espresso/70 flex items-start space-x-3">
                        <span class="text-emerald-700 font-bold text-base">ℹ</span>
                        <div>
                            <strong>Ketentuan Katalog Non-Transaksional:</strong> Portal KITAME tidak mencantumkan harga eceran dinamis atau tombol pembelian instan (No Checkout). Rincian penawaran harga, pesanan skala besar (bulk order), dan kesepakatan pengiriman dibicarakan secara mandiri langsung dengan pelaku usaha.
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Government Procurement Notice Box & Legality (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Government Procurement Notice Box (Highlighted Warm Box) -->
                <div class="bg-gradient-to-br from-[#FFF8E7] to-[#FFF1D0] p-6 rounded-2xl border-2 border-amber-300 shadow-sm space-y-4">
                    <div class="flex items-center space-x-2 text-amber-900 font-bold text-sm">
                        <svg class="w-5 h-5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Informasi Pengadaan Pemko</span>
                    </div>
                    <p class="text-xs text-amber-950 leading-relaxed">
                        Profil ini tidak menjamin pelaku usaha memenuhi persyaratan pengadaan. Kelayakan ditentukan oleh instansi terkait sesuai ketentuan yang berlaku.
                    </p>
                    <div class="text-[11px] text-amber-900/80 space-y-1.5 pt-2 border-t border-amber-200">
                        <div>NIB dicantumkan pemilik: {{ $umkm->nib ? 'Ya' : 'Belum' }}</div>
                        <div>Status E-Katalog: {{ $umkm->e_catalog_pemko ? 'Ditandai admin' : 'Belum ditandai admin' }}</div>
                    </div>
                </div>

                <!-- Legality & Standards Badges -->
                <div class="bg-white rounded-2xl p-6 border border-espresso/10 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-espresso uppercase tracking-wider">Verifikasi Legalitas & Kualitas</h3>

                    <div class="space-y-3">
                        <div class="flex items-center space-x-3 p-3 rounded-xl bg-cream/40 border border-espresso/10">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                OSS
                            </span>
                            <div>
                                <div class="text-xs font-bold text-espresso">NIB Berisiko Rendah/Menengah</div>
                                <div class="text-[10px] text-espresso/60">Terbit otomatis melalui Sistem OSS RBA</div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 p-3 rounded-xl bg-cream/40 border border-espresso/10">
                            <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-800 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                HALAL
                            </span>
                            <div>
                                <div class="text-xs font-bold text-espresso">Sertifikasi Halal BPJPH/MUI</div>
                                <div class="text-[10px] text-espresso/60">Jaminan kehalalan rantai pasok kuliner</div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 p-3 rounded-xl bg-cream/40 border border-espresso/10">
                            <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-800 font-bold text-xs flex items-center justify-center flex-shrink-0">
                                DINKES
                            </span>
                            <div>
                                <div class="text-xs font-bold text-espresso">Sertifikat Laik Higiene Sanitasi</div>
                                <div class="text-[10px] text-espresso/60">Standar higienitas olahan pangan daerah</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share & Report Card -->
                <div class="bg-white rounded-2xl p-6 border border-espresso/10 shadow-sm text-center space-y-3">
                    <span class="text-xs font-bold text-espresso/60 uppercase tracking-wider block">Bagikan Direktori Profil</span>
                    <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan profil resmi telah disalin ke clipboard!');" class="w-full py-2.5 px-4 rounded-xl border border-espresso/20 text-xs font-semibold text-espresso hover:bg-espresso/5 transition flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span>Salin Tautan Profil Resmi</span>
                    </button>
                </div>

            </div>

        </div>
    </div>
</section>
@endsection
