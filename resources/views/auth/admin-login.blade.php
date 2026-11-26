@extends('layouts.app')

@section('title', 'Login Admin & Stakeholder - KITAME')

@section('content')
<section class="py-14 bg-cream min-h-[65vh] flex items-center">
    <div class="w-full max-w-md mx-auto px-4">
        <form action="{{ route('admin.login.submit') }}" method="POST" class="bg-white rounded-2xl border border-espresso/15 p-6 sm:p-8 shadow-sm space-y-5">
            @csrf
            <div>
                <span class="inline-block rounded-full bg-amber-100 px-3 py-1 text-[11px] font-bold text-amber-900">
                    Jalur Khusus Admin Pemko / Stakeholder
                </span>
                <h1 class="text-2xl font-bold text-espresso mt-3">Masuk Panel Admin</h1>
                <p class="text-sm text-espresso/65 mt-1">Gunakan kredensial pengelola untuk verifikasi UMKM, talenta, dan pengadaan.</p>
            </div>

            @if(session('success'))
                <p class="rounded-lg bg-emerald-50 p-3 text-sm text-emerald-800">{{ session('success') }}</p>
            @endif

            @if($errors->any())
                <p class="rounded-lg bg-rose-50 p-3 text-sm text-rose-800">{{ $errors->first() }}</p>
            @endif

            <label class="block text-sm font-semibold text-espresso">Email Administrator
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                    class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
            </label>

            <label class="block text-sm font-semibold text-espresso">Kata Sandi
                <input type="password" name="password" required autocomplete="current-password"
                    class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
            </label>

            <button type="submit" class="w-full rounded-lg bg-espresso px-5 py-3 text-sm font-semibold text-cream hover:bg-espresso/90 transition">
                Masuk ke Dashboard Admin
            </button>

            <a href="{{ route('home') }}" class="block text-center text-sm font-semibold text-emerald-700 hover:underline">
                Kembali ke beranda publik
            </a>
        </form>
    </div>
</section>
@endsection