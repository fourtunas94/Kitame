@extends('layouts.app')

@section('title', 'Portofolio ' . $talent->user->name . ' - KITAME')

@section('content')
<section class="py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Medan Talent Hub</p>
                <h1 class="text-3xl font-bold mt-2">Portofolio {{ $talent->user->name }}</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('talent.profile') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-espresso/20 text-sm font-semibold hover:bg-espresso/5 transition">Profil</a>
                <a href="{{ route('talent.portfolio.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-semibold hover:bg-emerald-800 transition">Tambah Portofolio</a>
            </div>
        </div>

        @if ($talent->portfolio->isNotEmpty())
            <div class="divide-y divide-espresso/10 border-y border-espresso/10">
                @foreach ($talent->portfolio as $item)
                    <article class="py-5">
                        <form action="{{ route('talent.portfolio.update', $item) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <label class="block text-xs font-semibold">Judul karya
                                <input name="title" value="{{ $item->title }}" required class="mt-1 w-full rounded-lg border border-espresso/20 px-3 py-2 text-sm font-normal">
                            </label>
                            <label class="block text-xs font-semibold">Deskripsi
                                <textarea name="description" rows="2" class="mt-1 w-full rounded-lg border border-espresso/20 px-3 py-2 text-sm font-normal">{{ $item->description }}</textarea>
                            </label>
                            <label class="block text-xs font-semibold">Tautan karya
                                <input type="url" name="link" value="{{ $item->link }}" placeholder="https://" class="mt-1 w-full rounded-lg border border-espresso/20 px-3 py-2 text-sm font-normal">
                            </label>
                            <div class="flex flex-wrap gap-2">
                                <button type="submit" class="rounded-lg bg-emerald-700 px-4 py-2 text-xs font-semibold text-white hover:bg-emerald-800">Simpan Perubahan</button>
                                <a href="{{ $item->link }}" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-espresso/20 px-4 py-2 text-xs font-semibold hover:bg-cream">Lihat karya</a>
                            </div>
                        </form>
                        <form action="{{ route('talent.portfolio.destroy', $item) }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus portofolio ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-rose-700 hover:underline">Hapus portofolio</button>
                        </form>
                    </article>
                @endforeach
            </div>
        @else
            <div class="border-y border-espresso/10 py-12 text-center">
                <h2 class="font-semibold">Belum ada portofolio</h2>
                <p class="text-sm text-espresso/60 mt-1">Tambahkan karya atau proyek agar dapat dilihat calon klien.</p>
            </div>
        @endif
    </div>
</section>
@endsection