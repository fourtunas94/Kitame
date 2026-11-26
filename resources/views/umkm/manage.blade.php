@extends('layouts.app')

@section('title', 'Kelola Profil UMKM - KITAME')

@section('content')
<section class="py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Direktori UMKM</p>
                <h1 class="text-3xl font-bold mt-2">Kelola Profil UMKM</h1>
                <p class="text-sm text-espresso/65 mt-2">Perbarui informasi usaha dan produk yang ditampilkan di direktori.</p>
            </div>
            <a href="{{ route('umkm.show', $umkm) }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-espresso/20 text-sm font-semibold hover:bg-espresso/5 transition">Lihat Profil Publik</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <form action="{{ route('umkm.manage.update') }}" method="POST" enctype="multipart/form-data" class="lg:col-span-2 bg-white border border-espresso/10 rounded-xl p-6 sm:p-8 space-y-5">
                @csrf
                @method('PUT')
                <h2 class="text-lg font-bold">Informasi Usaha</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <label class="block text-sm font-semibold sm:col-span-2">Nomor Induk Berusaha (NIB)
                        <input name="nib" value="{{ old('nib', $umkm->nib) }}" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                        <span class="mt-1 block text-xs font-normal text-espresso/55">Masukkan NIB yang benar. KITAME belum terhubung untuk memverifikasi data ke OSS.</span>
                        @error('nib')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold sm:col-span-2">Nama usaha
                        <input name="business_name" value="{{ old('business_name', $umkm->business_name) }}" required class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                        @error('business_name')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold">Kategori
                        <input name="category" value="{{ old('category', $umkm->category) }}" required class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                        @error('category')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold">Kecamatan
                        <input name="kecamatan" value="{{ old('kecamatan', $umkm->kecamatan) }}" required class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                        @error('kecamatan')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold sm:col-span-2">Alamat
                        <textarea name="address" rows="2" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">{{ old('address', $umkm->address) }}</textarea>
                        @error('address')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold sm:col-span-2">Deskripsi usaha
                        <textarea name="description" rows="4" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">{{ old('description', $umkm->description) }}</textarea>
                        @error('description')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold">WhatsApp
                        <input name="whatsapp" value="{{ old('whatsapp', $umkm->whatsapp) }}" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                        @error('whatsapp')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold">Email usaha
                        <input type="email" name="email" value="{{ old('email', $umkm->email) }}" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                        @error('email')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold sm:col-span-2">Foto sampul
                        @if($umkm->cover_image_url)
                            <img src="{{ $umkm->cover_image_url }}" alt="Foto sampul saat ini" class="mt-2 h-32 w-full rounded-lg object-cover border border-espresso/10">
                        @endif
                        <input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none file:mr-3 file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:rounded-md file:text-emerald-700 file:text-xs file:font-semibold">
                        <span class="mt-1 block text-xs font-normal text-espresso/55">Pilih foto dari perangkat. JPG, PNG, atau WebP maksimal 4 MB.</span>
                        @error('cover_image')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold sm:col-span-2">Logo usaha
                        @if($umkm->logo_url)
                            <img src="{{ $umkm->logo_url }}" alt="Logo saat ini" class="mt-2 h-20 w-20 rounded-xl object-cover border border-espresso/10">
                        @endif
                        <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none file:mr-3 file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:rounded-md file:text-emerald-700 file:text-xs file:font-semibold">
                        <span class="mt-1 block text-xs font-normal text-espresso/55">Pilih logo dari perangkat. JPG, PNG, atau WebP maksimal 4 MB.</span>
                        @error('logo')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                </div>
                <div class="flex justify-end border-t border-espresso/10 pt-5">
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-emerald-700 text-white text-sm font-semibold hover:bg-emerald-800 transition">Simpan Profil</button>
                </div>
            </form>

            <div class="space-y-6">
                <form action="{{ route('umkm.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-espresso/10 rounded-xl p-6 space-y-4">
                    @csrf
                    <h2 class="text-lg font-bold">Tambah Produk</h2>
                    <label class="block text-sm font-semibold">Nama produk
                        <input name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">
                        @error('name')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold">Deskripsi
                        <textarea name="description" rows="3" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none">{{ old('description') }}</textarea>
                        @error('description')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-semibold">Foto produk
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="mt-2 w-full rounded-lg border border-espresso/20 px-3 py-2.5 text-sm font-normal focus:border-emerald-700 focus:outline-none file:mr-3 file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:rounded-md file:text-emerald-700 file:text-xs file:font-semibold">
                        <span class="mt-1 block text-xs font-normal text-espresso/55">Pilih foto dari perangkat. JPG, PNG, atau WebP maksimal 4 MB.</span>
                        @error('image')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                    </label>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-espresso text-white text-sm font-semibold hover:bg-espresso-soft transition">Tambah ke Katalog</button>
                </form>

                <div>
                    <h2 class="text-lg font-bold mb-3">Produk Terdaftar <span class="text-sm font-normal text-espresso/55">({{ $umkm->products->count() }})</span></h2>
                    <div class="divide-y divide-espresso/10 border-y border-espresso/10">
                        @forelse ($umkm->products as $product)
                            <div class="py-4">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="mb-3 h-28 w-full rounded-lg object-cover">
                                @endif
                                <form action="{{ route('umkm.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <label class="block text-xs font-semibold">Nama produk
                                        <input name="name" value="{{ $product->name }}" required class="mt-1 w-full rounded-lg border border-espresso/20 px-3 py-2 text-sm font-normal">
                                    </label>
                                    <label class="block text-xs font-semibold">Deskripsi
                                        <textarea name="description" rows="2" class="mt-1 w-full rounded-lg border border-espresso/20 px-3 py-2 text-sm font-normal">{{ $product->description }}</textarea>
                                    </label>
                                    <label class="block text-xs font-semibold">Ganti foto (opsional)
                                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="mt-1 w-full rounded-lg border border-espresso/20 px-3 py-2 text-xs font-normal">
                                    </label>
                                    <button type="submit" class="rounded-lg bg-emerald-700 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-800">Simpan Perubahan</button>
                                </form>
                                <form action="{{ route('umkm.products.destroy', $product) }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-700 hover:underline">Hapus produk</button>
                                </form>
                            </div>
                        @empty
                            <p class="py-4 text-sm text-espresso/60">Belum ada produk di katalog.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection