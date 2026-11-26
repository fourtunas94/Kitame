@extends('layouts.app')

@section('title', 'Lupa Kata Sandi - KITAME')

@section('content')
<section class="py-12 bg-cream min-h-[60vh]">
    <div class="max-w-lg mx-auto px-4">
        <form action="{{ route('password.email') }}" method="POST" class="bg-white rounded-2xl border border-espresso/10 p-6 sm:p-8 space-y-5">
            @csrf
            <div>
                <h1 class="text-2xl font-bold text-espresso">Lupa Kata Sandi</h1>
                <p class="text-sm text-espresso/65 mt-2">Masukkan email akun Anda. Kami akan mengirim tautan untuk membuat kata sandi baru.</p>
            </div>
            @if(session('status'))
                <p class="rounded-lg bg-emerald-50 p-3 text-sm text-emerald-800">{{ session('status') }}</p>
            @endif
            @if(session('error'))
                <p class="rounded-lg bg-rose-50 p-3 text-sm text-rose-800">{{ session('error') }}</p>
            @endif
            <label class="block text-sm font-semibold">Email akun
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                @error('email')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
            </label>
            <button type="submit" class="w-full rounded-lg bg-emerald-700 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-800">Kirim Tautan Reset</button>
            <a href="{{ route('home') }}" class="block text-center text-sm font-semibold text-emerald-700 hover:underline">Kembali ke beranda</a>
        </form>
    </div>
</section>
@endsection
