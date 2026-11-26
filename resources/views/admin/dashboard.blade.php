@extends('layouts.app')

@section('title', 'Dashboard Admin - KITAME')

@section('content')
<section class="flex-1 flex flex-col pt-10 pb-20">
    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 flex-1 flex flex-col">
        <div class="grid grid-cols-1 lg:grid-cols-[220px_minmax(0,1fr)] gap-8 lg:gap-10 flex-1">
            <aside class="lg:sticky lg:top-8 lg:self-start">
                <div class="flex items-center gap-2.5 pb-4 mb-5 border-b border-espresso/10">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 min-w-0 group">
                        <img src="{{ asset('images/logo-kitame.jpg') }}" alt="KITAME" class="w-10 h-10 shrink-0 rounded-lg object-cover shadow-sm transition group-hover:shadow-md">
                        <div class="min-w-0">
                            <div class="text-sm font-bold text-espresso leading-tight truncate">KITAME</div>
                            <div class="text-[10px] font-semibold uppercase tracking-wider text-espresso/50 truncate">Panel Admin</div>
                        </div>
                    </a>
                </div>

                <p class="hidden lg:block text-[10px] font-bold uppercase tracking-wider text-espresso/45 mb-3">Navigasi Admin</p>
                <nav aria-label="Navigasi dashboard admin" class="flex lg:flex-col gap-1 overflow-x-auto pb-2 lg:pb-0">
                    <a href="#ringkasan" data-admin-target="ringkasan" aria-current="page" class="flex shrink-0 items-center justify-between gap-5 rounded-lg px-3 py-2.5 text-sm font-semibold bg-white text-emerald-800 shadow-sm hover:bg-white hover:text-emerald-800 transition">
                        <span>Ringkasan</span>
                    </a>
                    <a href="#umkm" data-admin-target="umkm" class="flex shrink-0 items-center justify-between gap-5 rounded-lg px-3 py-2.5 text-sm font-semibold text-espresso/75 hover:bg-white hover:text-emerald-800 transition">
                        <span>Direktori UMKM</span><span class="text-xs text-espresso/45">{{ $umkms->count() }}</span>
                    </a>
                    <a href="#talenta" data-admin-target="talenta" class="flex shrink-0 items-center justify-between gap-5 rounded-lg px-3 py-2.5 text-sm font-semibold text-espresso/75 hover:bg-white hover:text-emerald-800 transition">
                        <span>Medan Talent Hub</span><span class="text-xs text-espresso/45">{{ $talents->count() }}</span>
                    </a>
                    <a href="#pengadaan" data-admin-target="pengadaan" class="flex shrink-0 items-center justify-between gap-5 rounded-lg px-3 py-2.5 text-sm font-semibold text-espresso/75 hover:bg-white hover:text-emerald-800 transition">
                        <span>Pengadaan Pemko</span><span class="text-xs text-espresso/45">{{ $openAnnouncementCount }}</span>
                    </a>
                    <a href="#pelamar" data-admin-target="pelamar" class="flex shrink-0 items-center justify-between gap-5 rounded-lg px-3 py-2.5 text-sm font-semibold text-espresso/75 hover:bg-white hover:text-emerald-800 transition">
                        <span>Pengajuan / Pelamar</span>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $pendingApplicationCount > 0 ? 'bg-amber-100 text-amber-800 font-bold' : 'bg-espresso/10 text-espresso/60' }}">{{ $applications->count() }}</span>
                    </a>

                    <div class="hidden lg:block my-2 border-t border-espresso/10"></div>

                    <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold text-red-700 hover:bg-red-50 transition text-left">
                            <span>Keluar</span>
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </nav>
            </aside>

            <main class="min-w-0 flex flex-col">
                <section id="ringkasan" data-admin-panel class="flex-1 flex flex-col">
                    <h2 class="text-xl font-bold mb-4">Ringkasan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
                        <div class="border-l-4 border-amber-500 bg-white px-5 py-4">
                            <p class="text-xs font-semibold text-espresso/60">UMKM menunggu publikasi</p>
                            <p class="text-2xl font-bold mt-1">{{ $umkmUnpublishedCount }}</p>
                        </div>
                        <div class="border-l-4 border-terracotta bg-white px-5 py-4">
                            <p class="text-xs font-semibold text-espresso/60">UMKM belum masuk E-Katalog</p>
                            <p class="text-2xl font-bold mt-1">{{ $umkmNotInCatalogCount }}</p>
                        </div>
                        <div class="border-l-4 border-emerald-700 bg-white px-5 py-4">
                            <p class="text-xs font-semibold text-espresso/60">Talenta menunggu publikasi</p>
                            <p class="text-2xl font-bold mt-1">{{ $talentUnpublishedCount }}</p>
                        </div>
                        <div class="border-l-4 border-emerald-700 bg-white px-5 py-4">
                            <p class="text-xs font-semibold text-espresso/60">Talenta belum tersertifikasi Disnaker</p>
                            <p class="text-2xl font-bold mt-1">{{ $talentNotCertifiedCount }}</p>
                        </div>
                        <div class="border-l-4 border-amber-500 bg-white px-5 py-4">
                            <p class="text-xs font-semibold text-espresso/60">Pengajuan Pelamar (Pending)</p>
                            <p class="text-2xl font-bold mt-1">{{ $pendingApplicationCount }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-espresso/55 mb-3">Akses Cepat</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            <a href="#umkm" data-admin-quick="umkm" class="flex items-center justify-between rounded-xl bg-white border border-espresso/10 px-4 py-3 text-sm font-semibold text-espresso hover:border-emerald-600 hover:text-emerald-800 transition">
                                <span>Direktori UMKM</span>
                                <span class="text-xs text-espresso/50">{{ $umkms->count() }} usaha →</span>
                            </a>
                            <a href="#talenta" data-admin-quick="talenta" class="flex items-center justify-between rounded-xl bg-white border border-espresso/10 px-4 py-3 text-sm font-semibold text-espresso hover:border-emerald-600 hover:text-emerald-800 transition">
                                <span>Medan Talent Hub</span>
                                <span class="text-xs text-espresso/50">{{ $talents->count() }} talenta →</span>
                            </a>
                            <a href="#pengadaan" data-admin-quick="pengadaan" class="flex items-center justify-between rounded-xl bg-white border border-espresso/10 px-4 py-3 text-sm font-semibold text-espresso hover:border-emerald-600 hover:text-emerald-800 transition">
                                <span>Pengadaan Pemko</span>
                                <span class="text-xs text-espresso/50">{{ $openAnnouncementCount }} aktif →</span>
                            </a>
                            <a href="#pelamar" data-admin-quick="pelamar" class="flex items-center justify-between rounded-xl bg-white border border-espresso/10 px-4 py-3 text-sm font-semibold text-espresso hover:border-emerald-600 hover:text-emerald-800 transition">
                                <span>Pengajuan / Pelamar</span>
                                <span class="text-xs text-espresso/50">{{ $applications->count() }} masuk →</span>
                            </a>
                            <a href="{{ route('home') }}" class="flex items-center justify-between rounded-xl bg-emerald-50/70 border border-emerald-200 px-4 py-3 text-sm font-semibold text-emerald-800 hover:bg-emerald-100/70 transition sm:col-span-2 lg:col-span-2">
                                <span>Lihat Perubahan di Landing Page</span>
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>
                </section>

                <section id="umkm" data-admin-panel hidden>
                    <div class="flex items-baseline justify-between gap-4 mb-4">
                        <h2 class="text-xl font-bold">Tinjau UMKM</h2>
                        <span class="text-xs text-espresso/55">{{ $umkms->count() }} usaha</span>
                    </div>
                    <p class="text-xs text-espresso/60 mb-4">Publikasi menentukan apakah profil terlihat di direktori. Status E-Katalog adalah penanda terpisah.</p>
                    <div class="overflow-x-auto border-y border-espresso/15">
                        <table class="w-full min-w-[980px] text-left text-sm">
                            <thead class="bg-cream/70 text-xs uppercase text-espresso/60">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">Usaha</th>
                                    <th class="px-4 py-3 font-semibold">Pemilik</th>
                                    <th class="px-4 py-3 font-semibold">NIB</th>
                                    <th class="px-4 py-3 font-semibold">Publikasi Direktori</th>
                                    <th class="px-4 py-3 font-semibold">Status E-Katalog</th>
                                    <th class="px-4 py-3 font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-espresso/10">
                                @forelse ($umkms as $umkm)
                                    <tr>
                                        <td class="px-4 py-4">
                                            <a href="{{ route('umkm.show', $umkm) }}" class="font-semibold text-emerald-800 hover:underline">{{ $umkm->business_name }}</a>
                                            <p class="text-xs text-espresso/55 mt-1">{{ $umkm->category }} · {{ $umkm->kecamatan }}</p>
                                        </td>
                                        <td class="px-4 py-4">{{ $umkm->user->name }}</td>
                                        <td class="px-4 py-4 font-mono text-xs">{{ $umkm->nib ?: 'Belum diisi' }}</td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center gap-2 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full {{ $umkm->is_published ? 'bg-emerald-600' : 'bg-amber-500' }}"></span>
                                                {{ $umkm->is_published ? 'Tampil' : 'Disembunyikan' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center gap-2 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full {{ $umkm->e_catalog_pemko ? 'bg-emerald-600' : 'bg-espresso/25' }}"></span>
                                                {{ $umkm->e_catalog_pemko ? 'Terdaftar' : 'Belum terdaftar' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="space-y-2">
                                                <form action="{{ route('admin.umkms.publication', $umkm) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-semibold text-emerald-800 hover:underline">
                                                        {{ $umkm->is_published ? 'Sembunyikan dari direktori' : 'Terbitkan ke direktori' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.umkms.e-catalog', $umkm) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-semibold text-espresso/70 hover:underline">
                                                        {{ $umkm->e_catalog_pemko ? 'Hapus tanda E-Katalog' : 'Beri tanda E-Katalog' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-4 py-8 text-center text-sm text-espresso/60">Belum ada data UMKM.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="talenta" data-admin-panel hidden>
                    <div class="flex items-baseline justify-between gap-4 mb-4">
                        <h2 class="text-xl font-bold">Tinjau Talenta</h2>
                        <span class="text-xs text-espresso/55">{{ $talents->count() }} talenta</span>
                    </div>
                    <div class="overflow-x-auto border-y border-espresso/15">
                        <table class="w-full min-w-[980px] text-left text-sm">
                            <thead class="bg-cream/70 text-xs uppercase text-espresso/60">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">Talenta</th>
                                    <th class="px-4 py-3 font-semibold">Keahlian</th>
                                    <th class="px-4 py-3 font-semibold">NIK</th>
                                    <th class="px-4 py-3 font-semibold">Publikasi Direktori</th>
                                    <th class="px-4 py-3 font-semibold">Sertifikasi Disnaker</th>
                                    <th class="px-4 py-3 font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-espresso/10">
                                @forelse ($talents as $talent)
                                    <tr>
                                        <td class="px-4 py-4">
                                            <span class="font-semibold">{{ $talent->user->name }}</span>
                                            <p class="text-xs text-espresso/55 mt-1">{{ $talent->category }} · {{ $talent->kecamatan }}</p>
                                        </td>
                                        <td class="px-4 py-4">{{ $talent->expertise ?: 'Belum diisi' }}</td>
                                        <td class="px-4 py-4 font-mono text-xs">{{ $talent->nik ? substr($talent->nik, 0, 6) . '••••' : 'Belum diisi' }}</td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center gap-2 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full {{ $talent->is_published ? 'bg-emerald-600' : 'bg-amber-500' }}"></span>
                                                {{ $talent->is_published ? 'Tampil' : 'Disembunyikan' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center gap-2 text-xs font-semibold">
                                                <span class="w-2 h-2 rounded-full {{ $talent->disnaker_certified ? 'bg-emerald-600' : 'bg-espresso/25' }}"></span>
                                                {{ $talent->disnaker_certified ? 'Tersertifikasi' : 'Belum tersertifikasi' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="space-y-2">
                                                <form action="{{ route('admin.talents.publication', $talent) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-semibold text-emerald-800 hover:underline">
                                                        {{ $talent->is_published ? 'Sembunyikan dari direktori' : 'Terbitkan ke direktori' }}
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.talents.certification', $talent) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-xs font-semibold text-espresso/70 hover:underline">
                                                        {{ $talent->disnaker_certified ? 'Batalkan sertifikasi' : 'Sertifikasi talenta' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-4 py-8 text-center text-sm text-espresso/60">Belum ada data talenta.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="pengadaan" data-admin-panel hidden class="border-y border-espresso/15 py-6">
                    <div class="max-w-3xl">
                        <h2 class="text-xl font-bold">Buat Pengumuman</h2>
                        <p class="text-sm text-espresso/65 mt-1">Terbitkan pengadaan untuk UMKM atau lowongan proyek untuk talenta.</p>
                    </div>

                    <form action="{{ route('admin.announcements.store') }}" method="POST" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @csrf
                        <label class="block text-sm font-semibold">Jenis pengumuman
                            <select name="type" required class="mt-2 w-full rounded-lg border border-espresso/20 bg-white px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                                <option value="procurement" @selected(old('type', 'procurement') === 'procurement')>Pengadaan UMKM</option>
                                <option value="job_vacancy" @selected(old('type') === 'job_vacancy')>Lowongan proyek talenta</option>
                            </select>
                            @error('type')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <label class="block text-sm font-semibold">Nama instansi / OPD
                            <input name="agency" value="{{ old('agency') }}" required maxlength="255" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                            @error('agency')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <label class="block text-sm font-semibold sm:col-span-2">Judul pengumuman
                            <input name="title" value="{{ old('title') }}" required maxlength="255" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                            @error('title')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <label class="block text-sm font-semibold sm:col-span-2">Deskripsi dan kualifikasi
                            <textarea name="description" rows="4" required maxlength="5000" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">{{ old('description') }}</textarea>
                            @error('description')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <label class="block text-sm font-semibold">Estimasi anggaran / honorarium
                            <input name="budget_estimate" value="{{ old('budget_estimate') }}" required maxlength="100" placeholder="Contoh: Rp 5.000.000" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                            @error('budget_estimate')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <label class="block text-sm font-semibold">Batas pengajuan
                            <input type="date" name="deadline" value="{{ old('deadline') }}" min="{{ now()->toDateString() }}" required class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                            @error('deadline')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <label class="block text-sm font-semibold sm:col-span-2">Lokasi / wilayah kegiatan
                            <input name="location" value="{{ old('location') }}" required maxlength="255" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                            @error('location')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <div class="sm:col-span-2 flex flex-wrap items-center justify-between gap-3 border-t border-espresso/10 pt-5">
                            <a href="{{ route('announcements.index') }}" class="text-sm font-semibold text-emerald-800 hover:underline">Lihat papan pengumuman</a>
                            <button type="submit" class="px-5 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-semibold hover:bg-emerald-800 transition">Terbitkan Pengumuman</button>
                        </div>
                    </form>

                    <div class="mt-10">
                        <div class="flex items-baseline justify-between gap-4 mb-3">
                            <h3 class="font-bold">Pengumuman Terbaru</h3>
                            <span class="text-xs text-espresso/55">10 terakhir</span>
                        </div>
                        <div class="divide-y divide-espresso/10 border-y border-espresso/10">
                            @forelse ($announcements as $announcement)
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-4">
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <span class="text-[10px] font-bold uppercase {{ $announcement->type === 'procurement' ? 'text-amber-800' : 'text-blue-800' }}">{{ $announcement->type === 'procurement' ? 'Pengadaan UMKM' : 'Lowongan Talenta' }}</span>
                                            <span class="text-[10px] font-semibold {{ $announcement->status === 'open' ? 'text-emerald-700' : 'text-espresso/50' }}">{{ $announcement->status === 'open' ? 'Aktif' : 'Ditutup' }}</span>
                                        </div>
                                        <h4 class="text-sm font-semibold">{{ $announcement->title }}</h4>
                                        <p class="text-xs text-espresso/55 mt-1">{{ $announcement->agency }} · Batas {{ $announcement->deadline?->format('d/m/Y') ?? 'tidak ditentukan' }}</p>
                                    </div>
                                    <form action="{{ route('admin.announcements.status', $announcement) }}" method="POST" class="shrink-0">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold text-emerald-800 hover:underline">
                                            {{ $announcement->status === 'open' ? 'Tutup pengumuman' : 'Buka kembali' }}
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="py-5 text-sm text-espresso/60">Belum ada pengumuman.</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section id="pelamar" data-admin-panel hidden class="border-t border-espresso/15 pt-6">
                    <div class="mb-5">
                        <div>
                            <h2 class="text-xl font-bold">Daftar Pengajuan Masuk (Pelamar)</h2>
                            <p class="mt-1 max-w-3xl text-sm text-espresso/65">Kelola dan tindak lanjuti pengajuan minat dari talenta atau pelaku UMKM untuk pengadaan dan lowongan proyek Pemko Medan.</p>
                        </div>
                        <div class="mt-4 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                            <span class="text-xs font-semibold text-espresso/55">{{ $applications->count() }} pengajuan</span>
                            <div class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto">
                                @if($announcementsForExport->isNotEmpty())
                                    <form action="{{ route('admin.applications.export') }}" method="GET" class="flex min-w-0 flex-1 flex-col gap-2 sm:flex-row">
                                        <label for="announcement-export" class="sr-only">Pilih acara untuk ekspor</label>
                                        <select id="announcement-export" name="announcement_id" required class="min-w-0 w-full rounded-lg border border-espresso/20 bg-white px-3 py-2 text-sm sm:w-80 sm:flex-1">
                                            <option value="" selected disabled>Pilih acara/pengumuman</option>
                                            @foreach($announcementsForExport as $exportAnnouncement)
                                                <option value="{{ $exportAnnouncement->id }}">
                                                    {{ $exportAnnouncement->type === 'procurement' ? 'Pengadaan' : 'Lowongan' }} — {{ $exportAnnouncement->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="whitespace-nowrap rounded-lg border border-emerald-700 px-4 py-2 text-sm font-semibold text-emerald-800 hover:bg-emerald-50 transition">
                                            Unduh PDF acara
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.applications.export') }}" class="inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-lg bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800 transition" title="PDF berisi data pribadi pelamar. Simpan dengan aman.">
                                    <span>Unduh semua PDF</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto border-y border-espresso/15">
                        <table class="w-full min-w-[860px] text-left text-sm">
                            <thead class="bg-cream/70 text-xs uppercase text-espresso/60">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">Pelamar / Talenta</th>
                                    <th class="px-4 py-3 font-semibold">Pengumuman Terkait</th>
                                    <th class="px-4 py-3 font-semibold w-2/5">Catatan Kualifikasi / Proposal</th>
                                    <th class="px-4 py-3 font-semibold">Kontak</th>
                                    <th class="px-4 py-3 font-semibold">Status & Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-espresso/10">
                                @forelse ($applications as $app)
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $app->contact_phone);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $waPhone = '62' . substr($cleanPhone, 1);
                                        } else {
                                            $waPhone = $cleanPhone;
                                        }
                                    @endphp
                                    <tr class="align-top">
                                        <td class="px-4 py-4">
                                            <span class="font-semibold text-espresso block">{{ $app->applicant_name ?: $app->user->name }}</span>
                                            <div class="flex items-center gap-1.5 mt-1">
                                                <span class="text-[10px] px-2 py-0.5 rounded font-bold uppercase
                                                    {{ $app->user->role === 'talent' ? 'bg-indigo-100 text-indigo-800' : ($app->user->role === 'umkm' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700') }}">
                                                    {{ $app->user->role === 'talent' ? 'Talenta' : ($app->user->role === 'umkm' ? 'Pelaku UMKM' : 'Warga') }}
                                                </span>
                                            </div>
                                            @if($app->user->talent?->nik)
                                                <p class="text-[11px] font-mono text-espresso/50 mt-1">NIK: {{ substr($app->user->talent->nik, 0, 6) }}••••</p>
                                            @elseif($app->user->umkm?->nib)
                                                <p class="text-[11px] font-mono text-espresso/50 mt-1">NIB: {{ $app->user->umkm->nib }}</p>
                                            @endif
                                            @if($app->identifier)
                                                <p class="text-[11px] font-mono text-espresso/50 mt-1">NIK/NIB diajukan: {{ $app->identifier }}</p>
                                            @endif
                                            <p class="text-[11px] text-espresso/45 mt-1">{{ $app->created_at->format('d/m/Y H:i') }} WIB</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="text-[10px] font-bold uppercase {{ $app->announcement->type === 'procurement' ? 'text-amber-800' : 'text-blue-800' }}">
                                                {{ $app->announcement->type === 'procurement' ? 'Pengadaan UMKM' : 'Lowongan Talenta' }}
                                            </span>
                                            <h4 class="font-semibold text-xs text-espresso mt-0.5 leading-snug">{{ $app->announcement->title }}</h4>
                                            <p class="text-[11px] text-espresso/55 mt-1">{{ $app->announcement->agency }}</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="text-xs text-espresso/80 bg-cream/50 rounded-lg p-3 border border-espresso/10 whitespace-pre-line leading-relaxed max-h-40 overflow-y-auto break-words">
                                                {!! nl2br(preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank" rel="noopener noreferrer" class="text-emerald-700 underline font-semibold break-all hover:text-emerald-900">$1</a>', e($app->proposal_note))) !!}
                                            </div>
                                            @if($app->portfolio_url)
                                                <div class="mt-2">
                                                    <a href="{{ $app->portfolio_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-800 border border-blue-200 text-xs font-semibold hover:bg-blue-100 transition">
                                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                        <span>Buka Link Portofolio</span>
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <a href="https://wa.me/{{ $waPhone }}?text=Halo%20{{ urlencode($app->user->name) }},%20kami%20dari%20Pemko%20Medan%20menindaklanjuti%20pengajuan%20Anda%20pada%20pengumuman%20'{{ urlencode($app->announcement->title) }}'."
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition text-xs font-semibold">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                                <span>{{ $app->contact_phone }}</span>
                                            </a>
                                            <p class="text-[10px] text-espresso/45 mt-1">Klik untuk chat WhatsApp</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <form action="{{ route('admin.applications.status', $app) }}" method="POST" class="space-y-2">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" class="w-full text-xs font-semibold rounded-lg border px-2.5 py-1.5 cursor-pointer focus:outline-none transition
                                                    {{ $app->status === 'accepted' ? 'border-emerald-600 bg-emerald-50 text-emerald-800' : ($app->status === 'rejected' ? 'border-rose-400 bg-rose-50 text-rose-800' : ($app->status === 'reviewed' ? 'border-blue-400 bg-blue-50 text-blue-800' : 'border-amber-400 bg-amber-50 text-amber-800')) }}">
                                                    <option value="pending" @selected($app->status === 'pending')>⏳ Menunggu (Pending)</option>
                                                    <option value="reviewed" @selected($app->status === 'reviewed')>🔍 Sedang Ditinjau</option>
                                                    <option value="accepted" @selected($app->status === 'accepted')>✅ Diterima (Disetujui)</option>
                                                    <option value="rejected" @selected($app->status === 'rejected')>❌ Ditolak</option>
                                                </select>
                                                <noscript>
                                                    <button type="submit" class="text-xs bg-espresso text-cream px-2.5 py-1 rounded">Simpan</button>
                                                </noscript>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-espresso/60">
                                            Belum ada pengajuan masuk dari talenta atau UMKM.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>
    </div>
</section>

@push('scripts')
<script>
    (() => {
        const links = Array.from(document.querySelectorAll('[data-admin-target]'));
        const quickLinks = Array.from(document.querySelectorAll('[data-admin-quick]'));
        const panels = Array.from(document.querySelectorAll('[data-admin-panel]'));

        const activatePanel = (panelId) => {
            if (!panels.some((panel) => panel.id === panelId)) {
                return;
            }

            panels.forEach((panel) => {
                panel.hidden = panel.id !== panelId;
            });

            links.forEach((link) => {
                const isActive = link.dataset.adminTarget === panelId;
                link.setAttribute('aria-current', isActive ? 'page' : 'false');
                link.classList.toggle('bg-white', isActive);
                link.classList.toggle('text-emerald-800', isActive);
                link.classList.toggle('shadow-sm', isActive);
                link.classList.toggle('text-espresso/75', !isActive);
            });
        };

        const bindPanelSwitch = (el, panelId) => {
            el.addEventListener('click', (event) => {
                event.preventDefault();
                window.sessionStorage.setItem('kitame-admin-panel', panelId);
                window.history.replaceState(null, '', `#${panelId}`);
                activatePanel(panelId);
            });
        };

        links.forEach((link) => bindPanelSwitch(link, link.dataset.adminTarget));
        quickLinks.forEach((link) => bindPanelSwitch(link, link.dataset.adminQuick));

        window.addEventListener('hashchange', () => {
            activatePanel(window.location.hash.slice(1) || 'ringkasan');
        });

        const requestedPanel = window.location.hash.slice(1)
            || window.sessionStorage.getItem('kitame-admin-panel')
            || 'ringkasan';
        activatePanel(requestedPanel);
    })();
</script>
@endpush
@endsection