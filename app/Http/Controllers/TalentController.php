<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Talent;
use Illuminate\Http\Request;

class TalentController extends Controller
{
    public function index(Request $request)
    {
        $categories = [
            'Programmer & IT',
            'Desain & Kreatif',
            'Teknisi & Servis',
            'Jasa Profesional',
            'Pertanian Lokal',
            'Kriya & Fashion',
            'Kuliner Tradisional',
        ];

        $kecamatans = [
            'Medan Amplas', 'Medan Area', 'Medan Barat', 'Medan Baru', 'Medan Belawan',
            'Medan Deli', 'Medan Denai', 'Medan Helvetia', 'Medan Johor', 'Medan Kota',
            'Medan Labuhan', 'Medan Maimun', 'Medan Marelan', 'Medan Perjuangan',
            'Medan Petisah', 'Medan Polonia', 'Medan Selayang', 'Medan Sunggal',
            'Medan Tembung', 'Medan Timur', 'Medan Tuntungan',
        ];

        $query = Talent::with('user')->where('is_published', true);

        if ($request->filled('keyword')) {
            $kw = strtolower($request->keyword);
            $query->where(function ($q) use ($kw) {
                $q->whereRaw('LOWER(expertise) LIKE ?', ["%{$kw}%"])
                    ->orWhereRaw('LOWER(bio) LIKE ?', ["%{$kw}%"])
                    ->orWhereRaw('LOWER(category) LIKE ?', ["%{$kw}%"])
                    ->orWhereHas('user', function ($uq) use ($kw) {
                        $uq->whereRaw('LOWER(name) LIKE ?', ["%{$kw}%"]);
                    });
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        if ($request->boolean('certified') || $request->disnaker_certified == '1') {
            $query->where('disnaker_certified', true);
        }

        $talents = $query->orderBy('disnaker_certified', 'desc')
            ->orderBy('id', 'asc')
            ->paginate(9)
            ->withQueryString();

        return view('talents.index', compact('talents', 'categories', 'kecamatans'));
    }

    public function editProfile()
    {
        abort_unless(auth()->user()->role === 'talent', 403);

        $talent = auth()->user()->talent()->firstOrFail();

        return view('talents.profile', compact('talent'));
    }

    public function updateProfile(Request $request)
    {
        abort_unless(auth()->user()->role === 'talent', 403);

        $talent = auth()->user()->talent()->firstOrFail();
        $data = $request->validate([
            'nik' => 'nullable|string|max:20',
            'category' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'expertise' => 'required|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'portfolio_url' => 'nullable|url|max:2048',
        ]);

        $talent->update($data);

        return back()->with('success', 'Profil talenta berhasil diperbarui.');
    }

    public function portfolio()
    {
        abort_unless(auth()->user()->role === 'talent', 403);

        $talent = auth()->user()->talent()->with('portfolio')->firstOrFail();

        return view('talents.portfolio', compact('talent'));
    }

    public function createPortfolio()
    {
        abort_unless(auth()->user()->role === 'talent', 403);

        return view('talents.portfolio_create');
    }

    public function storePortfolio(Request $request)
    {
        abort_unless(auth()->user()->role === 'talent', 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'link' => 'nullable|url|max:2048',
        ]);

        auth()->user()->talent()->firstOrFail()->portfolio()->create($data);

        return redirect()->route('talent.portfolio')
            ->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function updatePortfolio(Request $request, Portfolio $portfolio)
    {
        abort_unless(auth()->user()->role === 'talent', 403);
        $talent = auth()->user()->talent()->firstOrFail();
        abort_unless($portfolio->talent_id === $talent->id, 404);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'link' => 'nullable|url|max:2048',
        ]);

        $portfolio->update($data);

        return redirect()->route('talent.portfolio')
            ->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroyPortfolio(Portfolio $portfolio)
    {
        abort_unless(auth()->user()->role === 'talent', 403);
        $talent = auth()->user()->talent()->firstOrFail();
        abort_unless($portfolio->talent_id === $talent->id, 404);

        $portfolio->delete();

        return redirect()->route('talent.portfolio')
            ->with('success', 'Portofolio berhasil dihapus.');
    }
}
