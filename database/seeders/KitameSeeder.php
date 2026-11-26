<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Talent;
use App\Models\Umkm;
use App\Models\UmkmProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KitameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin Pemko Medan
        User::firstOrCreate(
            ['email' => 'admin@kitame.medan.go.id'],
            [
                'name' => 'Administrator Pemko Medan',
                'password' => Hash::make('password123'),
                'phone' => '08116001001',
                'role' => 'admin_pemko',
                'is_verified' => true,
            ]
        );

        // 2. UMKM Users & Profiles
        $umkmList = [
            [
                'user' => [
                    'name' => 'Hj. Syarifah Chairani',
                    'email' => 'info@bolumeranti.id',
                    'phone' => '081234567890',
                ],
                'umkm' => [
                    'nib' => '9120003418291',
                    'business_name' => 'Bolu Meranti Deli Rasa',
                    'category' => 'Kuliner Tradisional',
                    'kecamatan' => 'Medan Maimun',
                    'address' => 'Jl. Kruing No. 2K, Sekip, Kec. Medan Petisah, Kota Medan, Sumatera Utara 20112',
                    'description' => 'Ikon kuliner kebanggaan Kota Medan sejak 2005. Terkenal dengan tekstur bolu gulung yang sangat lembut, aroma butter khas, serta varian keju, mocca, dan cokelat premium yang telah tersertifikasi Halal MUI dan NIB OSS Berisiko Rendah.',
                    'e_catalog_pemko' => true,
                    'cover_image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=1200&auto=format&fit=crop&q=80',
                    'logo' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=200&auto=format&fit=crop&q=80',
                    'whatsapp' => '6281234567890',
                    'email' => 'pesanan@bolumeranti.id',
                ],
                'products' => [
                    [
                        'name' => 'Bolu Gulung Keju Spesial',
                        'description' => 'Bolu gulung legendaris dengan parutan keju cheddar melimpah ruah di luar dan lapisan butter cream keju istimewa di bagian dalam.',
                        'image' => 'https://images.unsplash.com/photo-1535141192574-5d4897c13136?w=600&auto=format&fit=crop&q=80',
                    ],
                    [
                        'name' => 'Bolu Gulung Double Cokelat & Mocca',
                        'description' => 'Perpaduan sempurna adonan bolu cokelat Belgia lembut dengan krim moka harum, disukai seluruh kalangan.',
                        'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=600&auto=format&fit=crop&q=80',
                    ],
                    [
                        'name' => 'Bolu Gulung Abon Sapi Pedas Gurih',
                        'description' => 'Varian gurih dengan taburan abon sapi pilihan berpadu aroma daun bawang dan sedikit gigitan cabai khas Melayu Deli.',
                        'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=600&auto=format&fit=crop&q=80',
                    ],
                    [
                        'name' => 'Paket Boks Kudapan Resmi Rapat Kedinasan',
                        'description' => 'Paket boks snack resmi higienis berstandar pengadaan Pemko Medan berisi slice bolu premium, lemper deli, dan air mineral.',
                        'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80',
                    ],
                ],
            ],
            [
                'user' => [
                    'name' => 'Dame Maria Simanjuntak',
                    'email' => 'kontak@ulostobadeli.com',
                    'phone' => '081345678901',
                ],
                'umkm' => [
                    'nib' => '9120005519283',
                    'business_name' => 'Kain Ulos Tenun Toba Deli',
                    'category' => 'Kriya & Fashion',
                    'kecamatan' => 'Medan Kota',
                    'address' => 'Jl. Brigjend Katamso No. 142, Kp. Baru, Kec. Medan Kota, Kota Medan',
                    'description' => 'Sentra pelestarian dan produksi kain tenun ulos tradisional batak dan songket Melayu Deli. Menggunakan alat tenun bukan mesin (ATBM) dengan pewarna serat alami ramah lingkungan.',
                    'e_catalog_pemko' => true,
                    'cover_image' => 'https://images.unsplash.com/photo-1607613009820-a29f7bb81c04?w=1200&auto=format&fit=crop&q=80',
                    'logo' => 'https://images.unsplash.com/photo-1520006403909-838d6b92c22e?w=200&auto=format&fit=crop&q=80',
                    'whatsapp' => '6281345678901',
                    'email' => 'sales@ulostobadeli.com',
                ],
                'products' => [
                    [
                        'name' => 'Kain Ulos Ragidup Tenun Tangan Asli',
                        'description' => 'Tenunan tangan berkelas dengan motif sakral melambangkan doa dan kehidupan panjang, cocok untuk cenderamata kehormatan tamu agung.',
                        'image' => 'https://images.unsplash.com/photo-1528459801416-a9e53bbf4e17?w=600&auto=format&fit=crop&q=80',
                    ],
                    [
                        'name' => 'Selendang Songket Deli Motif Pucuk Rebung',
                        'description' => 'Selendang berbenang emas mewah khas Kesultanan Deli untuk busana formal pejabat dan seremoni daerah.',
                        'image' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=600&auto=format&fit=crop&q=80',
                    ],
                ],
            ],
            [
                'user' => [
                    'name' => 'Budi Tarigan',
                    'email' => 'halo@kopitarigan.id',
                    'phone' => '081298765432',
                ],
                'umkm' => [
                    'nib' => '9120007728190',
                    'business_name' => 'Kopi Sidikalang Warisan Tarigan',
                    'category' => 'Kuliner Tradisional',
                    'kecamatan' => 'Medan Baru',
                    'address' => 'Jl. Dr. Mansyur No. 88, Padang Bulan, Kec. Medan Baru, Kota Medan',
                    'description' => 'Penyangrai kopi artisan biji tunggal (single origin) asli Sidikalang dan Mandheling grade 1. Telah bermitra dengan puluhan instansi perkantoran di Sumatera Utara.',
                    'e_catalog_pemko' => true,
                    'cover_image' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=1200&auto=format&fit=crop&q=80',
                    'logo' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=200&auto=format&fit=crop&q=80',
                    'whatsapp' => '6281298765432',
                    'email' => 'b2b@kopitarigan.id',
                ],
                'products' => [
                    [
                        'name' => 'Arabika Sidikalang Roasted Beans Grade 1',
                        'description' => 'Biji sangrai medium-dark dengan cita rasa cokelat, rempah, dan aroma earthy yang khas dan pekat.',
                        'image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600&auto=format&fit=crop&q=80',
                    ],
                    [
                        'name' => 'Kopi Drip Bag Instan Konsumsi Rapat',
                        'description' => 'Sachet drip bag praktis siap seduh dengan air panas, dirancang khusus untuk kenyamanan ruang rapat pimpinan.',
                        'image' => 'https://images.unsplash.com/photo-1517256064527-09c73fc73e38?w=600&auto=format&fit=crop&q=80',
                    ],
                ],
            ],
            [
                'user' => [
                    'name' => 'Zulkifli Nasution',
                    'email' => 'rotanamplas@gmail.com',
                    'phone' => '085278912345',
                ],
                'umkm' => [
                    'nib' => '9120004419280',
                    'business_name' => 'Kerajinan Rotan Medan Amplas',
                    'category' => 'Kriya & Fashion',
                    'kecamatan' => 'Medan Amplas',
                    'address' => 'Jl. Panglima Denai No. 54, Timbang Deli, Kec. Medan Amplas, Kota Medan',
                    'description' => 'Kelompok perajin anyaman rotan alami dan sintetis berkualitas ekspor. Memproduksi perabot interior, keranjang parsel, dan perlengkapan dekorasi kantor.',
                    'e_catalog_pemko' => false,
                    'cover_image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=1200&auto=format&fit=crop&q=80',
                    'logo' => 'https://images.unsplash.com/photo-1538688525198-9b88f6f53126?w=200&auto=format&fit=crop&q=80',
                    'whatsapp' => '6285278912345',
                    'email' => 'rotanamplas@gmail.com',
                ],
                'products' => [
                    [
                        'name' => 'Kursi Tunggu Sudut Anyaman Rotan Alami',
                        'description' => 'Rangka kokoh dengan anyaman rotan halus dilapisi coating anti rayap, ideal untuk lobi kantor pemerintahan.',
                        'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600&auto=format&fit=crop&q=80',
                    ],
                ],
            ],
            [
                'user' => [
                    'name' => 'Lily Wahyuni Tanjung',
                    'email' => 'order@teribulily.com',
                    'phone' => '081165432109',
                ],
                'umkm' => [
                    'nib' => '9120008827161',
                    'business_name' => 'Keripik Sambal Teri Bu Lily',
                    'category' => 'Kuliner Tradisional',
                    'kecamatan' => 'Medan Petisah',
                    'address' => 'Jl. Sekip No. 12B, Sei Putih Timur, Kec. Medan Petisah, Kota Medan',
                    'description' => 'Produsen olahan teri Medan asli bercita rasa renyah, gurih, dan pedas manis segar. Diproses higienis tanpa bahan pengawet dengan sertifikat PIRT dan Halal.',
                    'e_catalog_pemko' => true,
                    'cover_image' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=1200&auto=format&fit=crop&q=80',
                    'logo' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=200&auto=format&fit=crop&q=80',
                    'whatsapp' => '6281165432109',
                    'email' => 'order@teribulily.com',
                ],
                'products' => [
                    [
                        'name' => 'Teri Medan Krispi Sambal Bajak Kemasan Kaleng',
                        'description' => 'Teri nasi pilihan yang digoreng garing dengan bumbu cabai merah segar, awet hingga 6 bulan tanpa pengawet.',
                        'image' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=600&auto=format&fit=crop&q=80',
                    ],
                ],
            ],
            [
                'user' => [
                    'name' => 'Tengku Iskandar Syah',
                    'email' => 'batikdelisrimersing@gmail.com',
                    'phone' => '082165498712',
                ],
                'umkm' => [
                    'nib' => '9120009938271',
                    'business_name' => 'Batik Melayu Deli Sri Mersing',
                    'category' => 'Kriya & Fashion',
                    'kecamatan' => 'Medan Tuntungan',
                    'address' => 'Jl. Bunga Melati No. 22, Kemenangan Tani, Kec. Medan Tuntungan, Kota Medan',
                    'description' => 'Pusat kriya batik tulis dan cap dengan ragam motif ornamen Melayu Deli bersejarah seperti motif Tampuk Manggis, Daun Sirih, dan Bunga Raya.',
                    'e_catalog_pemko' => true,
                    'cover_image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=1200&auto=format&fit=crop&q=80',
                    'logo' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=200&auto=format&fit=crop&q=80',
                    'whatsapp' => '6282165498712',
                    'email' => 'batikdelisrimersing@gmail.com',
                ],
                'products' => [
                    [
                        'name' => 'Kemeja Batik Sutra Motif Ornamen Melayu Deli',
                        'description' => 'Kemeja pria lengan panjang berbahan sutra lembut dengan motif eksklusif ragam hias istana Maimun.',
                        'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600&auto=format&fit=crop&q=80',
                    ],
                ],
            ],
            [
                'user' => [
                    'name' => 'Hendri Sinaga',
                    'email' => 'markisamedan@yahoo.com',
                    'phone' => '081267890123',
                ],
                'umkm' => [
                    'nib' => '9120001239847',
                    'business_name' => 'Sirup Markisa Berastagi Medan',
                    'category' => 'Kuliner Tradisional',
                    'kecamatan' => 'Medan Barat',
                    'address' => 'Jl. Pertempuran No. 45, Pulo Brayan Kota, Kec. Medan Barat, Kota Medan',
                    'description' => 'Pabrik olahan buah markisa manis asli dataran tinggi Karo yang dikemas di Medan. Pilihan utama untuk buah tangan dan jamuan tamu kenegaraan.',
                    'e_catalog_pemko' => true,
                    'cover_image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=1200&auto=format&fit=crop&q=80',
                    'logo' => 'https://images.unsplash.com/photo-1543083477-4f785aeafaa9?w=200&auto=format&fit=crop&q=80',
                    'whatsapp' => '6281267890123',
                    'email' => 'markisamedan@yahoo.com',
                ],
                'products' => [
                    [
                        'name' => 'Sirup Markisa Asli Murni 1 Liter Botol Kaca',
                        'description' => 'Ekstrak buah markisa murni dengan gula tebu alami tanpa pemanis buatan, kaya akan vitamin C.',
                        'image' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=600&auto=format&fit=crop&q=80',
                    ],
                ],
            ],
            [
                'user' => [
                    'name' => 'Alfi Syahri',
                    'email' => 'deli.creative@gmail.com',
                    'phone' => '081987654321',
                ],
                'umkm' => [
                    'nib' => '9120004561239',
                    'business_name' => 'Studio Desain Kreatif Deli',
                    'category' => 'Desain & Kreatif',
                    'kecamatan' => 'Medan Helvetia',
                    'address' => 'Jl. Kapten Muslim Komplek Ruko Mega Mas Blok B-4, Kec. Medan Helvetia, Kota Medan',
                    'description' => 'Agensi desain grafis, branding, percetakan kemasan makanan bersertifikasi food-grade untuk ratusan binaan dinas koperasi se-Kota Medan.',
                    'e_catalog_pemko' => false,
                    'cover_image' => 'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=1200&auto=format&fit=crop&q=80',
                    'logo' => 'https://images.unsplash.com/photo-1572044162444-ad60f128bdea?w=200&auto=format&fit=crop&q=80',
                    'whatsapp' => '6281987654321',
                    'email' => 'deli.creative@gmail.com',
                ],
                'products' => [
                    [
                        'name' => 'Desain Kemasan Kotak Makanan Food Grade',
                        'description' => 'Jasa perancangan kemasan produk UMKM berstandar ekspor dilengkapi barcode BPOM dan Nutrition Facts.',
                        'image' => 'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=600&auto=format&fit=crop&q=80',
                    ],
                ],
            ],
        ];

        foreach ($umkmList as $item) {
            $user = User::firstOrCreate(
                ['email' => $item['user']['email']],
                [
                    'name' => $item['user']['name'],
                    'password' => Hash::make('password123'),
                    'phone' => $item['user']['phone'],
                    'role' => 'umkm',
                    'is_verified' => true,
                ]
            );

            $umkm = Umkm::updateOrCreate(
                ['user_id' => $user->id],
                array_merge($item['umkm'], ['user_id' => $user->id, 'is_published' => true])
            );

            foreach ($item['products'] as $prod) {
                UmkmProduct::firstOrCreate(
                    [
                        'umkm_id' => $umkm->id,
                        'name' => $prod['name'],
                    ],
                    [
                        'description' => $prod['description'],
                        'image' => $prod['image'],
                    ]
                );
            }
        }

        // 3. Talents
        $talentList = [
            [
                'name' => 'Rizky Ananda Siregar, S.Kom',
                'email' => 'rizky.siregar@gmail.com',
                'phone' => '081260112233',
                'nik' => '1271011504950001',
                'category' => 'Programmer & IT',
                'kecamatan' => 'Medan Selayang',
                'expertise' => 'Fullstack Laravel & Vue.js, PostgreSQL, RESTful API',
                'portfolio_url' => 'https://github.com/rizkyananda-dev',
                'disnaker_certified' => true,
                'bio' => 'Software engineer berpengalaman lebih dari 6 tahun dalam membangun sistem perizinan terpadu, aplikasi antrian faskes, serta arsitektur basis data relasional untuk sektor pemerintahan Kota Medan.',
            ],
            [
                'name' => 'Nadia Safitri Harahap, S.Ds',
                'email' => 'nadia.harahap@gmail.com',
                'phone' => '081370223344',
                'nik' => '1271025208970002',
                'category' => 'Desain & Kreatif',
                'kecamatan' => 'Medan Baru',
                'expertise' => 'UI/UX Design, Design System, Mobile App Prototype, Figma',
                'portfolio_url' => 'https://behance.net/nadiasafitri',
                'disnaker_certified' => true,
                'bio' => 'Desainer pengalaman pengguna peraih sertifikasi Disnaker & Google UX Design. Berfokus pada aksesibilitas warga lansia dalam mengakses layanan digital pemerintahan.',
            ],
            [
                'name' => 'Bagus Pratama Lubis, A.Md.T',
                'email' => 'bagus.lubis@gmail.com',
                'phone' => '081260334455',
                'nik' => '1271032103920003',
                'category' => 'Teknisi & Servis',
                'kecamatan' => 'Medan Denai',
                'expertise' => 'Teknisi Jaringan, Fiber Optic Splicing, Mikrotik MTCNA',
                'portfolio_url' => 'https://linkedin.com/in/baguspratama',
                'disnaker_certified' => true,
                'bio' => 'Teknisi telekomunikasi dan jaringan kabel optik tersertifikasi BNSP. Telah menginstalasi infrastruktur intranet di lebih dari 15 kantor kelurahan dan puskesmas di Medan.',
            ],
            [
                'name' => 'Dewi Anggraini, S.E., Ak.',
                'email' => 'dewi.anggraini@gmail.com',
                'phone' => '081370445566',
                'nik' => '1271046511940004',
                'category' => 'Jasa Profesional',
                'kecamatan' => 'Medan Timur',
                'expertise' => 'Konsultan Keuangan, Penyusunan Laporan Pajak UMKM, Audit Finansial',
                'portfolio_url' => 'https://dewi-accounting.id',
                'disnaker_certified' => false,
                'bio' => 'Praktisi akuntansi bersertifikat CA yang berfokus mendampingi pelaku usaha mikro dalam penyusunan laporan keuangan standar SAK EMKM dan pelaporan SPT Tahunan.',
            ],
            [
                'name' => 'Faisal Ramadhan Nasution',
                'email' => 'faisal.ramadhan@gmail.com',
                'phone' => '081260556677',
                'nik' => '1271051909960005',
                'category' => 'Programmer & IT',
                'kecamatan' => 'Medan Sunggal',
                'expertise' => 'DevOps Engineer, Linux System Administrator, Docker, AWS',
                'portfolio_url' => 'https://github.com/faisalnasution',
                'disnaker_certified' => true,
                'bio' => 'Spesialis ketahanan server dan virtualisasi. Berpengalaman menjaga ketersediaan server hingga 99.9% untuk portal informasi publik bertrafik tinggi saat pendaftaran siswa baru.',
            ],
            [
                'name' => 'Grace Yohana Simanjuntak',
                'email' => 'grace.simanjuntak@gmail.com',
                'phone' => '081370667788',
                'nik' => '1271064812980006',
                'category' => 'Desain & Kreatif',
                'kecamatan' => 'Medan Tembung',
                'expertise' => 'Videografi Dokumenter, Color Grading Davinci Resolve, Motion Graphic',
                'portfolio_url' => 'https://vimeo.com/gracesimanjuntak',
                'disnaker_certified' => true,
                'bio' => 'Sineas muda peraih penghargaan festival film lokal Sumatera Utara. Aktif memproduksi video promosi destinasi wisata kuliner dan profil pegiat UMKM Kota Medan.',
            ],
            [
                'name' => 'Dimas Aditya Ginting',
                'email' => 'dimas.ginting@gmail.com',
                'phone' => '081260778899',
                'nik' => '1271071207930007',
                'category' => 'Teknisi & Servis',
                'kecamatan' => 'Medan Johor',
                'expertise' => 'Teknisi HVAC Komersial, Perbaikan Mesin Pendingin Industri',
                'portfolio_url' => 'https://dimas-service.com',
                'disnaker_certified' => true,
                'bio' => 'Teknisi tata udara tersertifikasi Badan Nasional Sertifikasi Profesi (BNSP). Berpengalaman menangani unit pendingin sentral di auditorium, rumah sakit, dan gedung pertemuan.',
            ],
        ];

        foreach ($talentList as $item) {
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => Hash::make('password123'),
                    'phone' => $item['phone'],
                    'role' => 'talent',
                    'is_verified' => true,
                ]
            );

            Talent::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'nik' => $item['nik'],
                    'category' => $item['category'],
                    'kecamatan' => $item['kecamatan'],
                    'expertise' => $item['expertise'],
                    'portfolio_url' => $item['portfolio_url'],
                    'disnaker_certified' => $item['disnaker_certified'],
                    'is_published' => true,
                    'bio' => $item['bio'],
                ]
            );
        }

        // 4. Announcements (Pengadaan Pemko & Lowongan Proyek Talenta)
        $admin = User::where('role', 'admin_pemko')->first();

        $announcements = [
            // Pengadaan UMKM (procurement)
            [
                'user_id' => $admin->id,
                'type' => 'procurement',
                'title' => 'Pengadaan Konsumsi & Kudapan Tradisional Rapat Paripurna DPRD Kota Medan',
                'description' => 'Dinas Perindustrian dan Perdagangan Kota Medan membuka pengajuan minat penyediaan katering makanan tradisional khas Medan (kudapan manis dan asin higienis) untuk 3 hari agenda Sidang Paripurna DPRD Kota Medan tahun anggaran 2026. Prioritas bagi UMKM terverifikasi NIB dan terdaftar E-Katalog.',
                'budget_estimate' => 'Rp 45.000.000',
                'deadline' => Carbon::now()->addDays(20),
                'status' => 'open',
                'agency' => 'Dinas Perindustrian & Perdagangan Kota Medan',
                'location' => 'Medan Petisah',
            ],
            [
                'user_id' => $admin->id,
                'type' => 'procurement',
                'title' => 'Penyediaan Paket Cenderamata Souvenir Etnik Delegasi Kota Kembar (Sister City)',
                'description' => 'Dinas Pariwisata Kota Medan memerlukan 250 paket cenderamata eksklusif kerajinan tangan khas Deli dan Toba (kain tenun, kerajinan kayu/rotan berlogo Pemko) dalam rangka kunjungan resmi delegasi bilateral mancanegara.',
                'budget_estimate' => 'Rp 75.000.000',
                'deadline' => Carbon::now()->addDays(25),
                'status' => 'open',
                'agency' => 'Dinas Pariwisata Kota Medan',
                'location' => 'Medan Kota',
            ],
            [
                'user_id' => $admin->id,
                'type' => 'procurement',
                'title' => 'Pengadaan Seragam Batik Resmi Motif Deli Pegawai Kecamatan Se-Kota Medan',
                'description' => 'Badan Kepegawaian Daerah membuka pendaftaran minat bagi sentra kriya batik lokal Kota Medan untuk pengadaan bahan dan penjahitan 600 stel pakaian batik motif Melayu Deli berlisensi hak cipta daerah.',
                'budget_estimate' => 'Rp 120.000.000',
                'deadline' => Carbon::now()->addDays(32),
                'status' => 'open',
                'agency' => 'Badan Kepegawaian Daerah & PSDM',
                'location' => 'Medan Baru',
            ],
            [
                'user_id' => $admin->id,
                'type' => 'procurement',
                'title' => 'Penyediaan Kudapan Makanan Tambahan Balita & Lansia Posyandu 21 Kecamatan',
                'description' => 'Dinas Kesehatan mengundang UMKM kuliner sehat dan higienis bersertifikat Laik Higiene Sanitasi untuk memasok menu PMT kaya protein lokal (beras merah, telur omega, puding buah asli) secara berkala di puskesmas pembantu.',
                'budget_estimate' => 'Rp 180.000.000',
                'deadline' => Carbon::now()->addDays(15),
                'status' => 'open',
                'agency' => 'Dinas Kesehatan Kota Medan',
                'location' => 'Medan Amplas',
            ],
            [
                'user_id' => $admin->id,
                'type' => 'procurement',
                'title' => 'Pengadaan Biji Kopi Lokal & Penyewaan Mesin Espresso Ruang Jamuan Tamu Balaikota',
                'description' => 'Bagian Umum Sekretariat Daerah Kota Medan mencari produsen kopi lokal Sumatera Utara (Arabika & Robusta) terkurasi untuk pasokan berkala selama 6 bulan ke depan serta perawatan mesin kopi jamuan dinas.',
                'budget_estimate' => 'Rp 50.000.000',
                'deadline' => Carbon::now()->addDays(28),
                'status' => 'open',
                'agency' => 'Bagian Umum Setdako Medan',
                'location' => 'Medan Petisah',
            ],

            // Lowongan Proyek Talenta (job_vacancy)
            [
                'user_id' => $admin->id,
                'type' => 'job_vacancy',
                'title' => 'Pengembang Fullstack Portal Monitoring Retribusi Pasar Tradisional Kota Medan',
                'description' => 'Dinas Komunikasi dan Informatika membutuhkan 2 orang Senior Web Developer untuk mengembangkan modul pelaporan retribusi pedagang pasar berbasis QRIS dan dashboard analitik real-time terintegrasi API Bank Sumut.',
                'budget_estimate' => 'Rp 35.000.000',
                'deadline' => Carbon::now()->addDays(14),
                'status' => 'open',
                'agency' => 'Dinas Komunikasi dan Informatika Kota Medan',
                'location' => 'Medan Barat',
            ],
            [
                'user_id' => $admin->id,
                'type' => 'job_vacancy',
                'title' => 'UI/UX Specialist untuk Perancangan Ulang Aplikasi Layanan Dukcapil Online',
                'description' => 'Dinas Kependudukan dan Pencatatan Sipil membuka lowongan proyek perancangan antarmuka mobile dan web kependudukan. Fokus pada riset kegunaan warga lanjut usia dan pemenuhan standar Web Accessibility (WCAG 2.1).',
                'budget_estimate' => 'Rp 22.000.000',
                'deadline' => Carbon::now()->addDays(18),
                'status' => 'open',
                'agency' => 'Dinas Kependudukan & Pencatatan Sipil',
                'location' => 'Medan Kota',
            ],
            [
                'user_id' => $admin->id,
                'type' => 'job_vacancy',
                'title' => 'Tim Kreatif Videografi & Dokumentasi Rangkaian Peringatan Hari Jadi Kota Medan',
                'description' => 'Bagian Hubungan Masyarakat dan Protokol membuka kesempatan bagi tim videografer dan drone pilot bersertifikat untuk memproduksi serial video narasi sejarah dan capaian pembangunan Kota Medan 2026.',
                'budget_estimate' => 'Rp 28.000.000',
                'deadline' => Carbon::now()->addDays(9),
                'status' => 'open',
                'agency' => 'Bagian Protokol & Komunikasi Pimpinan',
                'location' => 'Medan Petisah',
            ],
            [
                'user_id' => $admin->id,
                'type' => 'job_vacancy',
                'title' => 'Auditor Keamanan Siber & Penetrasi Jaringan Intranet OPD Kota Medan',
                'description' => 'Diskominfo Kota Medan membutuhkan konsultan / tenaga ahli pentester bersertifikat CEH/OSCP untuk melakukan security assessment, penetration testing berkala, serta perumusan SOP mitigasi insiden siber pada server OPD.',
                'budget_estimate' => 'Rp 40.000.000',
                'deadline' => Carbon::now()->addDays(24),
                'status' => 'open',
                'agency' => 'Dinas Komunikasi dan Informatika Kota Medan',
                'location' => 'Medan Baru',
            ],
        ];

        foreach ($announcements as $ann) {
            Announcement::firstOrCreate(
                [
                    'title' => $ann['title'],
                    'agency' => $ann['agency'],
                ],
                $ann
            );
        }
    }
}
