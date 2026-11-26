@extends('layouts.app')

@section('title', 'Formulir Pengajuan Minat - ' . $announcement->title)

@section('content')
<!-- BREADCRUMB -->
<div class="bg-white border-b border-espresso/10 py-3 text-xs text-espresso/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center space-x-2">
        <a href="{{ route('home') }}" class="hover:text-espresso">Beranda</a>
        <span>/</span>
        <a href="{{ route('announcements.index') }}" class="hover:text-espresso">Papan Pengumuman</a>
        <span>/</span>
        <span class="text-espresso font-semibold truncate">Pengajuan Minat</span>
    </div>
</div>

<section class="py-12 bg-cream min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Announcement Context Header Box -->
        <div class="bg-white rounded-2xl p-6 border border-espresso/10 shadow-sm mb-8 space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $announcement->type === 'procurement' ? 'bg-amber-100 text-amber-900' : 'bg-blue-100 text-blue-900' }}">
                    {{ $announcement->type === 'procurement' ? 'Paket Pengadaan Barang / Konsumsi' : 'Lowongan Penugasan Proyek' }}
                </span>
                <span class="text-xs text-espresso/60 font-medium">Batas: {{ $announcement->deadline->format('d F Y') }}</span>
            </div>

            <h1 class="text-xl sm:text-2xl font-bold text-espresso">
                {{ $announcement->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-4 text-xs text-espresso/70 pt-2 border-t border-espresso/5">
                <div><strong>Instansi:</strong> {{ $announcement->agency }}</div>
                <div><strong>Wilayah:</strong> {{ $announcement->location }}</div>
                <div><strong>Estimasi Pagu:</strong> <span class="text-emerald-700 font-bold">{{ $announcement->budget_estimate }}</span></div>
            </div>
        </div>

        <!-- Centered Expression of Interest Application Form Card -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-espresso/10 shadow-lg relative">

            <div class="mb-8">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span>Formulir Resmi Pengajuan Minat (Expression of Interest)</span>
                </div>
                <h2 class="text-2xl font-bold text-espresso tracking-tight">Kirimkan Minat & Portofolio</h2>
                <p class="text-xs sm:text-sm text-espresso/60 mt-1 leading-relaxed">
                    Data profil dan kontak Anda akan langsung diteruskan ke Pejabat Pengadaan / Panitia Teknis pada dinas pengampu terkait.
                </p>
            </div>

            <form action="{{ route('announcements.submit', $announcement) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Applicant Name -->
                <div>
                    <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-2">
                        Nama Lengkap / Nama Badan Usaha Terdaftar
                    </label>
                    <input type="text" name="applicant_name" value="{{ old('applicant_name', $user ? $user->name : '') }}" required placeholder="Contoh: Bolu Meranti Deli Rasa / Rizky Ananda Siregar" class="w-full px-4 py-3 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30 @if($user) bg-cream/60 @endif">
                    <p class="text-[11px] text-espresso/50 mt-1">Nama ini akan tercantum pada berkas daftar calon penyedia.</p>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold text-espresso uppercase tracking-wider">
                            {{ $identifierLabel }}
                        </label>
                        <span class="text-[11px] font-semibold text-emerald-700 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Verifikasi Sahih
                        </span>
                    </div>
                    <input type="text" name="identifier" value="{{ old('identifier', $identifier) }}" required placeholder="Masukkan nomor NIB atau NIK" class="w-full px-4 py-3 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30 font-mono">
                    <p class="text-[11px] text-espresso/50 mt-1">Digunakan verifikator dinas untuk validasi silang pada basis data OSS RBA / Disdukcapil Kota Medan.</p>
                </div>

                <!-- Active WhatsApp Contact -->
                <div>
                    <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-2">
                        Nomor WhatsApp Aktif Penanggung Jawab
                    </label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $user ? $user->phone : '') }}" required placeholder="Contoh: 081234567890" class="w-full px-4 py-3 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                    <p class="text-[11px] text-espresso/50 mt-1">Panitia pengadaan dinas akan menghubungi nomor WhatsApp ini untuk konfirmasi jadwal temu teknis atau pengiriman sampel.</p>
                </div>

                <!-- Proposal / Production Capacity Note -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold text-espresso uppercase tracking-wider">
                            Catatan Kualifikasi, Pengalaman & Kapasitas
                        </label>
                        <span class="text-[11px] text-emerald-700 font-medium">Bisa sertakan link URL</span>
                    </div>
                    <textarea name="proposal_note" rows="5" required placeholder="Jelaskan secara ringkas kualifikasi Anda, kapasitas produksi/kerja, pengalaman proyek sejenis, atau Anda juga dapat langsung menempelkan tautan/link (Google Drive, GitHub, dll) di sini..." class="w-full p-4 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30 leading-relaxed">{{ old('proposal_note') }}</textarea>
                    <p class="text-[11px] text-espresso/50 mt-1">Minimal 20 karakter. Anda dapat mengetik atau menempel tautan web/drive langsung di dalam catatan ini.</p>
                    @error('proposal_note')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Portfolio / Document Link (Optional dedicated input) -->
                <div>
                    <label class="block text-xs font-bold text-espresso uppercase tracking-wider mb-2">
                        Tautan Portofolio / Berkas Pendukung <span class="text-espresso/50 font-normal lowercase">(opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-espresso/40">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </span>
                        <input type="url" name="portfolio_url" value="{{ old('portfolio_url') }}" placeholder="https://drive.google.com/... atau https://github.com/..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-espresso/20 focus:outline-none focus:border-emerald-600 text-sm bg-cream/30">
                    </div>
                    <p class="text-[11px] text-espresso/50 mt-1">Tautan berkas Google Drive, PDF portofolio, GitHub, atau website. Pastikan izin akses disetel publik (siapa saja yang memiliki link dapat melihat).</p>
                    @error('portfolio_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pakta Integritas / Terms Checkbox -->
                <div class="p-4 rounded-xl bg-cream/50 border border-espresso/10 space-y-3">
                    <label class="flex items-start space-x-3 cursor-pointer">
                        <input type="checkbox" name="terms" value="1" required class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500">
                        <span class="text-xs text-espresso/80 leading-relaxed">
                            Saya menyatakan bahwa data yang saya kirimkan adalah benar, usaha/keahlian saya berdomisili di Kota Medan, dan saya bersedia mematuhi <strong>Pakta Integritas Pengadaan Barang & Jasa Pemerintah Kota Medan</strong> tanpa suap, gratifikasi, atau perantara berbayar.
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 rounded-xl bg-espresso hover:bg-espresso-soft text-cream font-bold text-sm tracking-wide transition shadow-lg flex items-center justify-center space-x-2">
                    <span>Kirim Pengajuan Minat Sekarang</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>

            </form>

            <div class="mt-6 text-center text-xs text-espresso/50">
                Layanan ini 100% gratis dan dikelola secara resmi oleh Pemko Medan.
            </div>

        </div>

    </div>
</section>
@endsection
