@extends('layouts.app')

@section('title', 'Papan Pengumuman Pengadaan & Lowongan Proyek - KITAME Kota Medan')

@section('content')
<!-- HEADER SECTION -->
<section class="py-12 bg-cream border-b border-espresso/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-amber-100 text-amber-900 text-xs font-semibold mb-3">
                <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                <span>Transparansi Pengadaan Langsung Pemko Medan</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-espresso">
                Papan Pengumuman Pengadaan & Lowongan Proyek
            </h1>
            <p class="text-espresso/70 text-base mt-2 leading-relaxed">
                Informasi terbuka kebutuhan paket pengadaan barang/makanan bagi pelaku UMKM serta penugasan proyek keahlian bagi talenta perorangan oleh Organisasi Perangkat Daerah (OPD) Kota Medan.
            </p>
        </div>
    </div>
</section>

<!-- TAB SWITCHER & FILTER -->
<section class="py-6 bg-white border-b border-espresso/10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

            <!-- Tabs -->
            <div class="inline-flex p-1.5 rounded-2xl bg-cream border border-espresso/10 text-xs sm:text-sm font-semibold">
                <a href="{{ route('announcements.index', ['type' => 'procurement']) }}" class="px-5 py-2.5 rounded-xl transition flex items-center space-x-2 {{ $type === 'procurement' ? 'bg-espresso text-cream shadow-sm' : 'text-espresso/70 hover:text-espresso' }}">
                    <span>Pengadaan UMKM / Katering</span>
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $type === 'procurement' ? 'bg-white/20 text-cream' : 'bg-espresso/10 text-espresso' }}">
                        {{ $procurementCount }}
                    </span>
                </a>
                <a href="{{ route('announcements.index', ['type' => 'job_vacancy']) }}" class="px-5 py-2.5 rounded-xl transition flex items-center space-x-2 {{ $type === 'job_vacancy' ? 'bg-espresso text-cream shadow-sm' : 'text-espresso/70 hover:text-espresso' }}">
                    <span>Lowongan Proyek Talenta</span>
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $type === 'job_vacancy' ? 'bg-white/20 text-cream' : 'bg-espresso/10 text-espresso' }}">
                        {{ $jobVacancyCount }}
                    </span>
                </a>
            </div>

            <!-- Search Field -->
            <form action="{{ route('announcements.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="relative w-full md:w-64">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari paket / dinas..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-espresso/20 text-xs bg-cream/30 focus:outline-none focus:border-emerald-600">
                    <svg class="w-4 h-4 text-espresso/40 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-4 py-2 bg-espresso text-cream rounded-xl text-xs font-semibold hover:bg-espresso-soft transition">
                    Cari
                </button>
            </form>

        </div>
    </div>
</section>

<!-- ANNOUNCEMENTS LIST -->
<section class="py-12 bg-cream flex-grow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($announcements->count() > 0)
            <div class="space-y-6">
                @foreach($announcements as $ann)
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-espresso/10 hover:border-espresso/30 transition shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">

                        <!-- Details -->
                        <div class="space-y-3 max-w-3xl">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $ann->type === 'procurement' ? 'bg-amber-100 text-amber-900' : 'bg-blue-100 text-blue-900' }}">
                                    {{ $ann->type === 'procurement' ? 'Pengadaan UMKM' : 'Lowongan Proyek' }}
                                </span>
                                <span class="text-xs font-bold text-espresso/80">
                                    {{ $ann->agency }}
                                </span>
                                <span class="text-xs text-espresso/40">• Wilayah: {{ $ann->location }}</span>
                            </div>

                            <h2 class="text-xl sm:text-2xl font-bold text-espresso hover:text-emerald-700 transition">
                                <a href="{{ route('announcements.apply', $ann) }}">{{ $ann->title }}</a>
                            </h2>

                            <p class="text-xs sm:text-sm text-espresso/70 leading-relaxed">
                                {{ $ann->description }}
                            </p>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-espresso/60 pt-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Verifikasi Pemko Aktif
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Batas Pengajuan: <strong>&nbsp;{{ $ann->deadline->format('d F Y') }}</strong>
                                </span>
                            </div>
                        </div>

                        <!-- Price & CTA -->
                        <div class="flex flex-col sm:flex-row md:flex-col items-start sm:items-center md:items-end justify-between gap-4 flex-shrink-0 border-t md:border-t-0 pt-4 md:pt-0 border-espresso/10">
                            <div class="text-left md:text-right">
                                <div class="text-[11px] font-medium text-espresso/50 uppercase tracking-wider">Estimasi Pagu Anggaran</div>
                                <div class="text-xl sm:text-2xl font-bold text-emerald-700">{{ $ann->budget_estimate }}</div>
                                <div class="text-[11px] text-red-600 font-semibold mt-0.5">
                                    Tersisa {{ (int) now()->diffInDays($ann->deadline, false) }} hari lagi
                                </div>
                            </div>

                            <a href="{{ route('announcements.apply', $ann) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl bg-espresso hover:bg-espresso-soft text-cream text-xs font-semibold shadow-sm transition">
                                <span>Ajukan Minat & Lihat Detail</span>
                                <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $announcements->links() }}
            </div>

        @else
            <div class="bg-white rounded-2xl border border-espresso/10 p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-cream mx-auto flex items-center justify-center text-espresso/40 text-2xl mb-4">
                    📋
                </div>
                <h3 class="text-xl font-bold text-espresso mb-2">Belum Ada Pengumuman Terbuka</h3>
                <p class="text-xs text-espresso/60 leading-relaxed mb-6">
                    Tidak ada paket pengadaan aktif yang cocok dengan filter saat ini. Silakan periksa kembali dalam waktu dekat.
                </p>
                <a href="{{ route('announcements.index', ['type' => $type]) }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-espresso text-cream text-xs font-semibold hover:bg-espresso-soft transition">
                    Lihat Semua {{ $type === 'procurement' ? 'Pengadaan' : 'Lowongan' }}
                </a>
            </div>
        @endif

    </div>
</section>
@endsection
