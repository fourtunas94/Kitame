<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Talent;
use App\Models\Umkm;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = [
            [
                'name' => 'Kuliner Tradisional',
                'slug' => 'kuliner-tradisional',
                'description' => 'Bolu, olahan kopi deli, kripik teri, dan hidangan khas',
                'icon' => 'cake',
                'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Kriya & Fashion',
                'slug' => 'kriya-fashion',
                'description' => 'Ulos Batak, songket Melayu Deli, bordir, dan kerajinan',
                'icon' => 'sparkles',
                'image' => 'https://images.unsplash.com/photo-1607613009820-a29f7bb81c04?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Desain & Kreatif',
                'slug' => 'desain-kreatif',
                'description' => 'UI/UX, visual branding, videografi, dan ilustrasi',
                'icon' => 'paint-brush',
                'image' => 'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Programmer & IT',
                'slug' => 'programmer-it',
                'description' => 'Web apps, mobile developers, database, & cloud DevOps',
                'icon' => 'code-bracket',
                'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Teknisi & Servis',
                'slug' => 'teknisi-servis',
                'description' => 'Jaringan FO, instalasi kelistrikan, & HVAC kantor',
                'icon' => 'wrench-screwdriver',
                'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Suvenir',
                'slug' => 'suvenir',
                'description' => 'Cenderamata resmi kenegaraan dan cinderamata khas daerah',
                'icon' => 'gift',
                'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Pertanian Lokal',
                'slug' => 'pertanian-lokal',
                'description' => 'Hasil bumi hidroponik, bibit bunga, dan pupuk organik',
                'icon' => 'sun',
                'image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=500&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Jasa Profesional',
                'slug' => 'jasa-profesional',
                'description' => 'Akuntan publik, konsultan pajak, legalitas, & penerjemah',
                'icon' => 'briefcase',
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=500&auto=format&fit=crop&q=80',
            ],
        ];

        $kecamatans = [
            'Medan Amplas', 'Medan Area', 'Medan Barat', 'Medan Baru', 'Medan Belawan',
            'Medan Deli', 'Medan Denai', 'Medan Helvetia', 'Medan Johor', 'Medan Kota',
            'Medan Labuhan', 'Medan Maimun', 'Medan Marelan', 'Medan Perjuangan',
            'Medan Petisah', 'Medan Polonia', 'Medan Selayang', 'Medan Sunggal',
            'Medan Tembung', 'Medan Timur', 'Medan Tuntungan',
        ];

        $featuredUmkms = Umkm::with('user', 'products')
            ->where('is_published', true)
            ->orderBy('e_catalog_pemko', 'desc')
            ->take(6)
            ->get();

        $featuredTalents = Talent::with('user')
            ->where('is_published', true)
            ->orderBy('disnaker_certified', 'desc')
            ->take(4)
            ->get();

        $latestAnnouncements = Announcement::where('status', 'open')
            ->whereDate('deadline', '>=', today())
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $stats = [
            'umkm_count' => Umkm::where('is_published', true)->count(),
            'talent_count' => Talent::where('is_published', true)->count(),
            'announcement_count' => Announcement::where('status', 'open')
                ->whereDate('deadline', '>=', today())
                ->count(),
            'kecamatan_count' => 21,
        ];

        return view('home', compact('categories', 'kecamatans', 'featuredUmkms', 'featuredTalents', 'latestAnnouncements', 'stats'));
    }
}
