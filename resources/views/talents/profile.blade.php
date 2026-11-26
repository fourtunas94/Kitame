@extends('layouts.app')

@section('title', 'Kelola Profil Talenta - KITAME')

@section('content')
<section class="py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Medan Talent Hub</p>
                <h1 class="text-3xl font-bold mt-2">Kelola Profil Talenta</h1>
                <p class="text-sm text-espresso/65 mt-2">Perbarui informasi yang tampil di direktori talenta.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('announcements.my_applications') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-espresso/20 bg-white text-espresso text-sm font-semibold hover:bg-cream transition">
                    Status Lamaran Saya
                </a>
                <a href="{{ route('talent.portfolio') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-semibold hover:bg-emerald-800 transition">
                    Kelola Portofolio
                </a>
            </div>
        </div>

        <form action="{{ route('talent.profile.update') }}" method="POST" class="bg-white border border-espresso/10 rounded-xl p-6 sm:p-8 space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <label class="block text-sm font-semibold sm:col-span-2">Nomor Induk Kependudukan (NIK)
                    <input name="nik" value="{{ old('nik', $talent->nik) }}" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                    <span class="mt-1 block text-xs font-normal text-espresso/55">Masukkan NIK yang benar. KITAME belum terhubung untuk memverifikasi data ke Dukcapil.</span>
                    @error('nik')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="block text-sm font-semibold">Kategori
                    <input name="category" value="{{ old('category', $talent->category) }}" required class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                    @error('category')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="block text-sm font-semibold">Kecamatan
                    <input name="kecamatan" value="{{ old('kecamatan', $talent->kecamatan) }}" required class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                    @error('kecamatan')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="block text-sm font-semibold sm:col-span-2">Keahlian
                    <input name="expertise" value="{{ old('expertise', $talent->expertise) }}" required class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                    @error('expertise')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="block text-sm font-semibold sm:col-span-2">Bio
                    <textarea name="bio" rows="4" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">{{ old('bio', $talent->bio) }}</textarea>
                    @error('bio')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="block text-sm font-semibold sm:col-span-2">Tautan portofolio utama
                    <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $talent->portfolio_url) }}" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                    @error('portfolio_url')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                </label>
            </div>
            <div class="flex justify-end border-t border-espresso/10 pt-5">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-semibold hover:bg-emerald-800 transition">Simpan Profil</button>
            </div>
        </form>
    </div>
</section>
@endsection