<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\UmkmProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $categories = [
            'Kuliner Tradisional',
            'Kriya & Fashion',
            'Desain & Kreatif',
            'Programmer & IT',
            'Teknisi & Servis',
            'Suvenir',
            'Pertanian Lokal',
            'Jasa Profesional',
        ];

        $kecamatans = [
            'Medan Amplas', 'Medan Area', 'Medan Barat', 'Medan Baru', 'Medan Belawan',
            'Medan Deli', 'Medan Denai', 'Medan Helvetia', 'Medan Johor', 'Medan Kota',
            'Medan Labuhan', 'Medan Maimun', 'Medan Marelan', 'Medan Perjuangan',
            'Medan Petisah', 'Medan Polonia', 'Medan Selayang', 'Medan Sunggal',
            'Medan Tembung', 'Medan Timur', 'Medan Tuntungan',
        ];

        $query = Umkm::with('user', 'products')->where('is_published', true);

        if ($request->filled('keyword')) {
            $kw = strtolower($request->keyword);
            $query->where(function ($q) use ($kw) {
                $q->whereRaw('LOWER(business_name) LIKE ?', ["%{$kw}%"])
                    ->orWhereRaw('LOWER(description) LIKE ?', ["%{$kw}%"])
                    ->orWhereRaw('LOWER(category) LIKE ?', ["%{$kw}%"])
                    ->orWhereRaw('LOWER(address) LIKE ?', ["%{$kw}%"]);
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        if ($request->boolean('verified') || $request->e_catalog_pemko == '1') {
            $query->where('e_catalog_pemko', true);
        }

        $umkms = $query->orderBy('e_catalog_pemko', 'desc')
            ->orderBy('id', 'asc')
            ->paginate(9)
            ->withQueryString();

        return view('umkm.index', compact('umkms', 'categories', 'kecamatans'));
    }

    public function show(Umkm $umkm)
    {
        abort_unless(
            $umkm->is_published
                || auth()->id() === $umkm->user_id
                || auth()->user()?->role === 'admin_pemko',
            404
        );

        $umkm->load('user', 'products');

        $relatedUmkms = Umkm::where('category', $umkm->category)
            ->where('is_published', true)
            ->where('id', '!=', $umkm->id)
            ->take(3)
            ->get();

        return view('umkm.show', compact('umkm', 'relatedUmkms'));
    }

    public function manage()
    {
        abort_unless(auth()->user()->role === 'umkm', 403);

        $umkm = auth()->user()->umkm()->with('products')->firstOrFail();

        return view('umkm.manage', compact('umkm'));
    }

    public function updateProfile(Request $request)
    {
        abort_unless(auth()->user()->role === 'umkm', 403);

        $umkm = auth()->user()->umkm()->firstOrFail();
        $imagesToDelete = [];
        $data = $request->validate([
            'nib' => 'nullable|string|max:20',
            'business_name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'address' => 'nullable|string|max:1000',
            'description' => 'nullable|string|max:5000',
            'whatsapp' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:100',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('cover_image')) {
            $imagesToDelete[] = $umkm->cover_image;
            $data['cover_image'] = $request->file('cover_image')->store('umkm/covers', 'public');
        } else {
            unset($data['cover_image']);
        }

        if ($request->hasFile('logo')) {
            $imagesToDelete[] = $umkm->logo;
            $data['logo'] = $request->file('logo')->store('umkm/logos', 'public');
        } else {
            unset($data['logo']);
        }

        $umkm->update($data);
        foreach ($imagesToDelete as $image) {
            $this->deleteStoredImage($image);
        }

        return back()->with('success', 'Profil UMKM berhasil diperbarui.');
    }

    public function storeProduct(Request $request)
    {
        abort_unless(auth()->user()->role === 'umkm', 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('umkm/products', 'public');
        }

        auth()->user()->umkm()->firstOrFail()->products()->create($data);

        return back()->with('success', 'Produk berhasil ditambahkan ke katalog.');
    }

    public function updateProduct(Request $request, UmkmProduct $product)
    {
        abort_unless(auth()->user()->role === 'umkm', 403);
        $umkm = auth()->user()->umkm()->firstOrFail();
        abort_unless($product->umkm_id === $umkm->id, 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $previousImage = $product->image;
            $data['image'] = $request->file('image')->store('umkm/products', 'public');
        } else {
            unset($data['image']);
        }

        $product->update($data);
        if (isset($previousImage)) {
            $this->deleteStoredImage($previousImage);
        }

        return back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroyProduct(UmkmProduct $product)
    {
        abort_unless(auth()->user()->role === 'umkm', 403);
        $umkm = auth()->user()->umkm()->firstOrFail();
        abort_unless($product->umkm_id === $umkm->id, 404);

        $image = $product->image;
        $product->delete();
        $this->deleteStoredImage($image);

        return back()->with('success', 'Produk berhasil dihapus.');
    }

    private function deleteStoredImage(?string $image): void
    {
        if ($image && ! str_starts_with($image, 'http://') && ! str_starts_with($image, 'https://')) {
            Storage::disk('public')->delete($image);
        }
    }
}
