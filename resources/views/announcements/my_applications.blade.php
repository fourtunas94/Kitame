@extends('layouts.app')

@section('title', 'Status Pengajuan Minat & Lamaran - KITAME')

@section('content')
<!-- BREADCRUMB -->
<div class="bg-white border-b border-espresso/10 py-3 text-xs text-espresso/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-2">
        <a href="{{ route('home') }}" class="hover:text-espresso">Beranda</a>
        <span>/</span>
        <a href="{{ route('announcements.index') }}" class="hover:text-espresso">Papan Pengumuman</a>
        <span>/</span>
        <span class="text-espresso font-semibold">Status Pengajuan Minat</span>
    </div>
</div>

<section class="py-10 bg-cream min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span>Pusat Notifikasi Pemohon</span>
                </div>
                <h1 class="text-3xl font-bold text-espresso tracking-tight">Status Pengajuan Minat & Lamaran</h1>
                <p class="text-sm text-espresso/65 mt-1">Pantau perkembangan verifikasi berkas pengadaan UMKM dan lowongan proyek Pemko Medan yang Anda ikuti.</p>
            </div>

            <a href="{{ route('announcements.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-espresso text-cream hover:bg-espresso-soft text-xs font-semibold transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Lihat Pengumuman Lain</span>
            </a>
        </div>

        @if($applications->isEmpty())
            <div class="bg-white rounded-3xl p-10 border border-espresso/10 text-center shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-cream flex items-center justify-center mx-auto text-espresso/40 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-espresso">Belum Ada Pengajuan Minat</h3>
                <p class="text-xs sm:text-sm text-espresso/60 max-w-md mx-auto mt-1 mb-6">
                    Anda belum pernah mengirimkan formulir pengajuan minat untuk pengadaan UMKM atau lowongan proyek Pemko Medan.
                </p>
                <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs sm:text-sm font-semibold transition shadow-sm">
                    <span>Jelajahi Papan Pengumuman</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($applications as $app)
                    <div class="bg-white rounded-2xl border border-espresso/10 p-6 sm:p-7 shadow-sm transition hover:shadow-md">

                        <!-- Top Row: Badge & Date -->
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-espresso/5">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-bold uppercase px-2.5 py-0.5 rounded-full {{ $app->announcement->type === 'procurement' ? 'bg-amber-100 text-amber-900' : 'bg-blue-100 text-blue-900' }}">
                                    {{ $app->announcement->type === 'procurement' ? 'Pengadaan UMKM' : 'Lowongan Proyek Talenta' }}
                                </span>
                                <span class="text-xs text-espresso/50">Diajukan: {{ $app->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>

                            <!-- Status Badge -->
                            <div>
                                @if($app->status === 'accepted')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Diterima / Disetujui
                                    </span>
                                @elseif($app->status === 'reviewed')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-300">
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        Sedang Ditinjau
                                    </span>
                                @elseif($app->status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Belum Terpilih
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                        <svg class="w-3.5 h-3.5 text-amber-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Menunggu Verifikasi
                                    </span>
                                @endif
                                @if(auth()->check() && auth()->user()->role === 'talent' && $app->status === 'rejected')
                                    <form action="{{ route('announcements.applications.destroy', $app) }}" method="POST" class="mt-2"
                                          onsubmit="return confirm('Hapus lamaran yang ditolak ini? Tindakan ini tidak dapat dibatalkan.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-rose-200 bg-white text-rose-700 text-xs font-bold hover:bg-rose-50 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus Lamaran
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Announcement Details -->
                        <div class="mt-4">
                            <h2 class="text-lg sm:text-xl font-bold text-espresso">
                                {{ $app->announcement->title }}
                            </h2>
                            @if($app->applicant_name || $app->identifier)
                                <p class="text-xs text-espresso/60 mt-1">
                                    Pemohon: <strong>{{ $app->applicant_name ?: $app->user->name }}</strong>
                                    @if($app->identifier) <span class="ml-2">NIK/NIB: {{ $app->identifier }}</span> @endif
                                </p>
                            @endif
                            <div class="flex flex-wrap items-center gap-4 text-xs text-espresso/70 mt-1.5">
                                <div><strong>Instansi:</strong> {{ $app->announcement->agency }}</div>
                                <div>•</div>
                                <div><strong>Estimasi Pagu:</strong> <span class="text-emerald-700 font-semibold">{{ $app->announcement->budget_estimate }}</span></div>
                                <div>•</div>
                                <div><strong>Wilayah:</strong> {{ $app->announcement->location }}</div>
                            </div>
                        </div>

                        <!-- Status Message Card Box -->
                        <div class="mt-4 p-4 rounded-xl text-xs sm:text-sm leading-relaxed border
                            @if($app->status === 'accepted') bg-emerald-50/80 border-emerald-200 text-emerald-900
                            @elseif($app->status === 'reviewed') bg-blue-50/80 border-blue-200 text-blue-900
                            @elseif($app->status === 'rejected') bg-rose-50/80 border-rose-200 text-rose-900
                            @else bg-amber-50/80 border-amber-200 text-amber-900 @endif">
                            <div class="font-bold flex items-center gap-2 mb-1">
                                <span>Pemberitahuan Resmi:</span>
                            </div>
                            @if($app->status === 'accepted')
                                <p>Selamat! Pengajuan minat Anda telah <strong>disetujui</strong> oleh pejabat pengadaan {{ $app->announcement->agency }}. Panitia akan segera menghubungi nomor WhatsApp Anda (<strong>{{ $app->contact_phone }}</strong>) untuk konfirmasi teknis & penandatanganan SPK.</p>
                            @elseif($app->status === 'reviewed')
                                <p>Berkas kualifikasi dan portofolio Anda saat ini <strong>sedang ditinjau</strong> oleh panitia teknis. Harap pastikan nomor WhatsApp Anda aktif untuk menerima panggilan atau pesan konfirmasi.</p>
                            @elseif($app->status === 'rejected')
                                <p>Terima kasih atas partisipasi Anda. Untuk pengadaan kali ini berkas Anda belum terpilih. Tetap pantau papan pengumuman untuk peluang pengadaan lainnya.</p>
                            @else
                                <p>Pengajuan Anda telah berhasil tersimpan dan saat ini <strong>dalam antrean verifikasi</strong> oleh panitia {{ $app->announcement->agency }}. Anda akan dihubungi melalui WhatsApp bila memenuhi kriteria.</p>
                            @endif
                        </div>

                        <!-- Proposal Content & Links Submitted -->
                        <div class="mt-5 pt-4 border-t border-espresso/10">
                            <p class="text-xs font-bold uppercase tracking-wider text-espresso/60 mb-2">Uraian Kualifikasi / Catatan yang Anda Kirim:</p>
                            <div class="text-xs sm:text-sm text-espresso/80 bg-cream/40 rounded-xl p-4 border border-espresso/10 whitespace-pre-line leading-relaxed break-words">
                                {!! nl2br(preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank" rel="noopener noreferrer" class="text-emerald-700 underline font-semibold break-all hover:text-emerald-900">$1</a>', e($app->proposal_note))) !!}
                            </div>

                            @if($app->portfolio_url)
                                <div class="mt-3 flex items-center gap-2">
                                    <span class="text-xs text-espresso/60 font-semibold">Tautan Portofolio / Berkas:</span>
                                    <a href="{{ $app->portfolio_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-800 border border-blue-200 text-xs font-semibold hover:bg-blue-100 transition">
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        <span>Buka Link Portofolio</span>
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>
                @endforeach

                <div class="pt-4">
                    {{ $applications->links() }}
                </div>
            </div>
        @endif

    </div>
</section>
@endsection
