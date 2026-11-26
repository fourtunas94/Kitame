@extends('layouts.app')

@section('title', 'Medan Talent Hub - Direktori Tenaga Ahli & Pekerja Kreatif Medan')

@section('content')
<!-- HEADER SECTION -->
<section class="py-12 bg-cream border-b border-espresso/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-blue-100 text-blue-900 text-xs font-semibold mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                <span>Pusat Data Ketenagakerjaan & Keahlian Lokal</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-espresso">
                Medan Talent Hub
            </h1>
            <p class="text-espresso/70 text-base mt-2 leading-relaxed">
                Temukan dan berdayakan talenta lokal profesional, programmer, desainer, teknisi, dan konsultan bersertifikasi yang siap berkolaborasi untuk proyek instansi, industri, maupun warga.
            </p>
        </div>
    </div>
</section>

<!-- FILTER BAR -->
<section class="py-6 bg-white border-b border-espresso/10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('talents.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">

                <!-- Keyword Search -->
                <div class="md:col-span-4">
                    <div class="relative">
                        <svg class="w-4 h-4 text-espresso/40 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari nama, keahlian (Laravel, UI/UX...)" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                    </div>
                </div>

                <!-- Category Dropdown -->
                <div class="md:col-span-3">
                    <select name="category" class="w-full px-3 py-2.5 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30 cursor-pointer">
                        <option value="">Semua Bidang Keahlian</option>
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

                <!-- Action Button -->
                <div class="md:col-span-2 flex items-center space-x-2">
                    <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-espresso text-cream hover:bg-espresso-soft text-sm font-semibold transition">
                        Terapkan
                    </button>
                    @if(request()->hasAny(['keyword', 'category', 'kecamatan', 'certified']))
                        <a href="{{ route('talents.index') }}" title="Reset Filter" class="p-2.5 rounded-xl border border-espresso/20 text-espresso hover:bg-espresso/5 transition">
                            ✕
                        </a>
                    @endif
                </div>

            </div>

            <!-- Checkbox Bar -->
            <div class="flex items-center space-x-6 text-xs text-espresso/80 pt-1">
                <label class="inline-flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="certified" value="1" {{ request('certified') == '1' ? 'checked' : '' }} onchange="this.form.submit()" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span class="font-medium">Hanya Tampilkan Talenta Tersertifikasi Disnaker / BNSP</span>
                </label>
                <span class="text-espresso/40">|</span>
                <span class="text-espresso/60">Ditemukan <strong>{{ $talents->total() }}</strong> talenta terdaftar</span>
            </div>
        </form>
    </div>
</section>

<!-- TALENT CARDS GRID -->
<section class="py-12 bg-cream flex-grow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($talents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($talents as $talent)
                    <div class="bg-white rounded-2xl border border-espresso/10 p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">

                        <div>
                            <!-- Header: Avatar & Name -->
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-14 h-14 rounded-2xl bg-espresso text-cream font-bold text-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                                        {{ strtoupper(substr($talent->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-espresso group-hover:text-emerald-700 transition leading-snug">
                                            {{ $talent->user->name }}
                                        </h3>
                                        <span class="text-xs font-semibold text-terracotta">{{ $talent->category }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Badges -->
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Profil Talenta
                                </span>
                                @if($talent->disnaker_certified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                                        ★ Disnaker Certified
                                    </span>
                                @endif
                            </div>

                            <!-- Expertise Tag -->
                            <div class="p-3 rounded-xl bg-cream/50 border border-espresso/10 mb-4">
                                <span class="text-[10px] font-bold text-espresso/50 uppercase tracking-wider block mb-1">Spesialisasi & Keterampilan</span>
                                <p class="text-xs font-semibold text-espresso">{{ $talent->expertise }}</p>
                            </div>

                            <!-- Bio Snippet -->
                            <p class="text-xs text-espresso/70 leading-relaxed line-clamp-3 mb-4">
                                {{ $talent->bio }}
                            </p>
                        </div>

                        <!-- Footer Details & Buttons -->
                        <div class="pt-4 border-t border-espresso/10">
                            <div class="flex items-center justify-between text-xs text-espresso/60 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1 text-espresso/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $talent->kecamatan }}
                                </span>
                                <span class="text-[10px] text-espresso/40">NIK: {{ substr($talent->nik, 0, 6) }}••••</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ $talent->portfolio_url }}" target="_blank" class="inline-flex items-center justify-center py-2.5 px-3 rounded-xl border border-espresso/20 text-espresso text-xs font-semibold hover:bg-espresso hover:text-white transition">
                                    <span>Portofolio</span>
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $talent->user->phone) }}?text=Halo%20{{ urlencode($talent->user->name) }},%20saya%20melihat%20profil%20keahlian%20Anda%20di%20Medan%20Talent%20Hub%20KITAME." target="_blank" class="inline-flex items-center justify-center py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition shadow-sm">
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
                {{ $talents->links() }}
            </div>

        @else
            <div class="bg-white rounded-2xl border border-espresso/10 p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-cream mx-auto flex items-center justify-center text-espresso/40 text-2xl mb-4">
                    🔍
                </div>
                <h3 class="text-xl font-bold text-espresso mb-2">Talenta Tidak Ditemukan</h3>
                <p class="text-xs text-espresso/60 leading-relaxed mb-6">
                    Kriteria pencarian Anda belum cocok dengan database talenta aktif. Coba sesuaikan kata kunci atau bersihkan opsi filter.
                </p>
                <a href="{{ route('talents.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-espresso text-cream text-xs font-semibold hover:bg-espresso-soft transition">
                    Reset Filter
                </a>
            </div>
        @endif

    </div>
</section>
@endsection
