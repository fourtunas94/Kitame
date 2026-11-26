@extends('layouts.app')

@section('title', 'Tambah Portofolio - KITAME')

@section('content')
<section class="py-10">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('talent.portfolio') }}" class="text-sm font-semibold text-emerald-700 hover:underline">Kembali ke portofolio</a>
        <h1 class="text-3xl font-bold mt-3 mb-8">Tambah Portofolio</h1>
        <form action="{{ route('talent.portfolio.store') }}" method="POST" class="bg-white border border-espresso/10 rounded-xl p-6 sm:p-8 space-y-5">
            @csrf
            <label class="block text-sm font-semibold">Judul karya
                <input type="text" name="title" value="{{ old('title') }}" required class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                @error('title')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </label>
            <label class="block text-sm font-semibold">Deskripsi
                <textarea name="description" rows="4" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">{{ old('description') }}</textarea>
                @error('description')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </label>
            <label class="block text-sm font-semibold">Tautan karya
                <input type="url" name="link" value="{{ old('link') }}" placeholder="https://" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                @error('link')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </label>
            <div class="flex justify-end border-t border-espresso/10 pt-5">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-semibold hover:bg-emerald-800 transition">Simpan Portofolio</button>
            </div>
        </form>
    </div>
</section>
@endsection