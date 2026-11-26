<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\Application;
use App\Models\Talent;
use App\Models\Umkm;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdf;
use Database\Seeders\KitameSeeder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class KitamePortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(KitameSeeder::class);
    }

    /**
     * Test 1: Homepage renders hero, categories, and non-transactional elements.
     */
    public function test_homepage_renders_with_hero_and_categories(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('KITAME');
        $response->assertSee('images/logo-kitame.jpg');
        $response->assertSee('Temukan Talenta');
        $response->assertSee('Peluang UMKM');
        $response->assertSee('Katalog & Kategori Utama', false);
        $response->assertSee('Kuliner Tradisional');
        $response->assertSee('Kriya');
        $response->assertSee('Masuk');
        $response->assertSee('Daftar');
    }

    /**
     * Test 2: UMKM Directory lists businesses and filters correctly.
     */
    public function test_umkm_directory_renders_and_filters(): void
    {
        $response = $this->get('/umkm');

        $response->assertStatus(200);
        $response->assertSee('Direktori UMKM & E-Katalog Lokal Medan', false);
        $response->assertSee('Bolu Meranti Deli Rasa');
        $response->assertSee('Profil UMKM');

        // Test filter by category
        $responseFiltered = $this->get('/umkm?category='.urlencode('Kuliner Tradisional'));
        $responseFiltered->assertStatus(200);
        $responseFiltered->assertSee('Bolu Meranti Deli Rasa');

        // Test filter by search keyword
        $responseSearch = $this->get('/umkm?keyword=Meranti');
        $responseSearch->assertStatus(200);
        $responseSearch->assertSee('Bolu Meranti Deli Rasa');
    }

    public function test_new_umkm_profiles_require_admin_publication_and_can_be_hidden_again(): void
    {
        $this->post(route('register'), [
            'name' => 'UMKM Menunggu Publikasi',
            'email' => 'pending@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '08123456789',
            'role' => 'umkm',
        ])->assertRedirect();

        $user = User::where('email', 'pending@example.test')->firstOrFail();
        $umkm = $user->umkm()->firstOrFail();
        $this->post(route('logout'));
        $publishedCount = Umkm::where('is_published', true)->count();

        $this->assertFalse($umkm->is_published);
        $this->get(route('umkm.index'))->assertDontSee('UMKM Menunggu Publikasi');
        $this->get(route('home'))->assertDontSee('UMKM Menunggu Publikasi');
        $this->get(route('home'))->assertSee($publishedCount.'+');
        $this->get(route('umkm.show', $umkm))->assertNotFound();

        $admin = User::where('role', 'admin_pemko')->firstOrFail();
        $this->actingAs($admin)
            ->post(route('admin.umkms.publication', $umkm))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('umkms', [
            'id' => $umkm->id,
            'is_published' => true,
        ]);
        $this->get(route('umkm.index'))->assertSee('UMKM Menunggu Publikasi');
        $this->get(route('home'))->assertSee(($publishedCount + 1).'+');
        $this->get(route('umkm.show', $umkm))->assertOk();

        $this->post(route('admin.umkms.publication', $umkm))
            ->assertSessionHas('success');

        $this->post(route('logout'));
        $this->get(route('umkm.index'))->assertDontSee('UMKM Menunggu Publikasi');
        $this->get(route('home'))->assertDontSee('UMKM Menunggu Publikasi');
        $this->get(route('home'))->assertSee($publishedCount.'+');
        $this->get(route('umkm.show', $umkm))->assertNotFound();
    }

    /**
     * Test 3: UMKM Detail Profile page has contact actions and strictly NO cart or checkout.
     */
    public function test_umkm_detail_page_renders_with_no_cart_buttons(): void
    {
        $umkm = Umkm::where('business_name', 'Bolu Meranti Deli Rasa')->firstOrFail();

        $response = $this->get('/umkm/'.$umkm->id);

        $response->assertStatus(200);
        $response->assertSee('Bolu Meranti Deli Rasa');
        $response->assertSee('Hubungi via WhatsApp');
        $response->assertSee('Kirim Email');
        $response->assertSee('Informasi Pengadaan Pemko');
        $response->assertSee('Bolu Gulung Keju Spesial');

        // Strictly verify that no shopping cart or checkout exists
        $response->assertDontSee('Add to Cart');
        $response->assertDontSee('Tambah ke Keranjang');
        $response->assertDontSee('Checkout Sekarang');
        $response->assertDontSee('Keranjang Belanja');
    }

    public function test_umkm_and_talent_can_open_their_profile_management_pages(): void
    {
        $umkm = Umkm::firstOrFail();
        $umkmResponse = $this->actingAs($umkm->user)->get(route('umkm.manage'));
        $umkmResponse->assertOk();
        $umkmResponse->assertSee('Kelola Profil UMKM');
        $umkmResponse->assertSee('Tambah Produk');

        $talent = Talent::firstOrFail();
        $talentResponse = $this->actingAs($talent->user)->get(route('talent.profile'));
        $talentResponse->assertOk();
        $talentResponse->assertSee('Kelola Profil Talenta');
        $talentResponse->assertSee('Kelola Portofolio');
    }

    public function test_umkm_and_talent_can_update_profiles_and_add_items(): void
    {
        Storage::fake('public');

        $umkm = Umkm::firstOrFail();
        $this->actingAs($umkm->user)->put(route('umkm.manage.update'), [
            'nib' => '9120003418291',
            'business_name' => 'Usaha Uji Kitame',
            'category' => 'Kuliner Tradisional',
            'kecamatan' => 'Medan Baru',
            'address' => 'Jl. Uji No. 1',
            'description' => 'Deskripsi uji.',
            'whatsapp' => '08123456789',
            'email' => 'usaha@example.test',
            'cover_image' => UploadedFile::fake()->create('cover.jpg', 100, 'image/jpeg'),
            'logo' => UploadedFile::fake()->create('logo.png', 50, 'image/png'),
        ])->assertSessionHas('success');

        $this->post(route('umkm.products.store'), [
            'name' => 'Produk Uji',
            'description' => 'Deskripsi produk uji.',
            'image' => UploadedFile::fake()->create('product.webp', 80, 'image/webp'),
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('umkms', ['id' => $umkm->id, 'business_name' => 'Usaha Uji Kitame']);
        $this->assertDatabaseHas('umkm_products', ['umkm_id' => $umkm->id, 'name' => 'Produk Uji']);

        $talent = Talent::firstOrFail();
        $this->actingAs($talent->user)->put(route('talent.profile.update'), [
            'nik' => '1271011504950001',
            'category' => 'Desain & Kreatif',
            'kecamatan' => 'Medan Kota',
            'expertise' => 'Desain produk',
            'bio' => 'Bio uji.',
            'portfolio_url' => 'https://example.test/portfolio',
        ])->assertSessionHas('success');

        $this->post(route('talent.portfolio.store'), [
            'title' => 'Karya Uji',
            'description' => 'Deskripsi karya uji.',
            'link' => 'https://example.test/work',
        ])->assertRedirect(route('talent.portfolio'));

        $this->assertDatabaseHas('umkms', ['id' => $umkm->id, 'nib' => '9120003418291']);
        $this->assertDatabaseHas('talents', ['id' => $talent->id, 'expertise' => 'Desain produk', 'nik' => '1271011504950001']);
        $this->assertDatabaseHas('portfolios', ['talent_id' => $talent->id, 'title' => 'Karya Uji']);
    }

    public function test_admin_can_manage_e_catalog_and_talent_certification(): void
    {
        $admin = User::where('role', 'admin_pemko')->firstOrFail();
        $umkm = Umkm::firstOrFail();
        $talent = Talent::firstOrFail();

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Admin')
            ->assertSee('Tinjau UMKM')
            ->assertSee('Tinjau Talenta')
            ->assertSee('Direktori UMKM')
            ->assertSee('Medan Talent Hub')
            ->assertSee('Pengadaan Pemko')
            ->assertSee('data-admin-target="ringkasan"', false)
            ->assertSee('data-admin-target="umkm"', false)
            ->assertSee('id="umkm" data-admin-panel hidden', false)
            ->assertSee("sessionStorage.setItem('kitame-admin-panel'", false);

        $this->post(route('admin.umkms.e-catalog', $umkm))->assertSessionHas('success');
        $this->post(route('admin.talents.certification', $talent))->assertSessionHas('success');

        $this->assertDatabaseHas('umkms', [
            'id' => $umkm->id,
            'e_catalog_pemko' => ! $umkm->e_catalog_pemko,
        ]);
        $this->assertDatabaseHas('talents', [
            'id' => $talent->id,
            'disnaker_certified' => ! $talent->disnaker_certified,
        ]);
    }

    public function test_admin_can_download_applicant_data_as_pdf_for_all_or_selected_announcement(): void
    {
        $umkm = Umkm::firstOrFail();
        $announcement = Announcement::where('type', 'procurement')->firstOrFail();

        Application::create([
            'announcement_id' => $announcement->id,
            'user_id' => $umkm->user_id,
            'applicant_name' => '=HYPERLINK("https://example.test","Click")',
            'identifier' => 'NIB-PDF-1',
            'proposal_note' => 'Proposal untuk ekspor.',
            'contact_phone' => '08123456789',
            'status' => 'pending',
        ]);

        $admin = User::where('role', 'admin_pemko')->firstOrFail();
        $otherAnnouncement = Announcement::create([
            'user_id' => $admin->id,
            'type' => 'procurement',
            'title' => 'Acara Ekspor Kedua',
            'description' => 'Pengumuman untuk menguji ekspor terfilter.',
            'budget_estimate' => 'Rp 1.000.000',
            'deadline' => now()->addDays(10)->toDateString(),
            'status' => 'open',
            'agency' => 'Dinas Uji',
            'location' => 'Medan',
        ]);
        $otherApplication = Application::create([
            'announcement_id' => $otherAnnouncement->id,
            'user_id' => $umkm->user_id,
            'applicant_name' => 'Pelamar Acara Kedua',
            'identifier' => 'NIB-PDF-2',
            'proposal_note' => 'Proposal acara kedua.',
            'contact_phone' => '08123456780',
            'status' => 'reviewed',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.applications.export'));

        $response->assertOk()
            ->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('private', $response->headers->get('cache-control'));
        $this->assertStringContainsString('no-store', $response->headers->get('cache-control'));
        $this->assertStringStartsWith('%PDF-', $response->getContent());
        $this->assertStringContainsString('data-pelamar-semua-acara-', $response->headers->get('content-disposition'));

        $pdf = Mockery::mock(DomPdf::class);
        $pdf->shouldReceive('setPaper')
            ->once()
            ->with('a4', 'landscape')
            ->andReturnSelf();
        $pdf->shouldReceive('download')
            ->once()
            ->with(Mockery::pattern('/^data-pelamar-acara-ekspor-kedua-.*\.pdf$/'))
            ->andReturn(response('%PDF-test', 200, ['Content-Type' => 'application/pdf']));
        Pdf::shouldReceive('loadView')
            ->once()
            ->with('admin.applications-pdf', Mockery::on(function (array $data) use ($otherApplication, $otherAnnouncement): bool {
                return $data['announcement']->is($otherAnnouncement)
                    && $data['applications']->modelKeys() === [$otherApplication->id];
            }))
            ->andReturn($pdf);

        $this->get(route('admin.applications.export', [
            'announcement_id' => $otherAnnouncement->id,
        ]))->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_new_talent_profiles_require_admin_publication_and_can_be_hidden_again(): void
    {
        $this->post(route('register'), [
            'name' => 'Talenta Menunggu Publikasi',
            'email' => 'talent-pending@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '08123456789',
            'role' => 'talent',
        ])->assertRedirect();

        $user = User::where('email', 'talent-pending@example.test')->firstOrFail();
        $talent = $user->talent()->firstOrFail();
        $this->post(route('logout'));
        $publishedCount = Talent::where('is_published', true)->count();

        $this->assertFalse($talent->is_published);
        $this->get(route('talents.index'))->assertDontSee('Talenta Menunggu Publikasi');
        $this->get(route('home'))->assertDontSee('Talenta Menunggu Publikasi');
        $this->get(route('home'))->assertSee($publishedCount.'+');

        $admin = User::where('role', 'admin_pemko')->firstOrFail();
        $this->actingAs($admin)
            ->post(route('admin.talents.publication', $talent))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('talents', [
            'id' => $talent->id,
            'is_published' => true,
        ]);
        $this->get(route('talents.index'))->assertSee('Talenta Menunggu Publikasi');
        $this->get(route('home'))->assertSee(($publishedCount + 1).'+');

        $this->post(route('admin.talents.publication', $talent))
            ->assertSessionHas('success');
        $this->post(route('logout'));

        $this->get(route('talents.index'))->assertDontSee('Talenta Menunggu Publikasi');
        $this->get(route('home'))->assertDontSee('Talenta Menunggu Publikasi');
        $this->get(route('home'))->assertSee($publishedCount.'+');
    }

    public function test_non_admin_cannot_open_admin_dashboard_or_change_verification_status(): void
    {
        $umkm = Umkm::firstOrFail();

        $this->actingAs($umkm->user)->get(route('admin.dashboard'))->assertForbidden();
        $this->post(route('admin.umkms.e-catalog', $umkm))->assertForbidden();
        $this->post(route('admin.umkms.publication', $umkm))->assertForbidden();
        $this->post(route('admin.talents.publication', Talent::firstOrFail()))->assertForbidden();
        $this->get(route('admin.applications.export'))->assertForbidden();
        $this->post(route('admin.announcements.store'), [
            'type' => 'procurement',
            'title' => 'Pengumuman tidak sah',
            'description' => 'Pengguna biasa tidak dapat menerbitkan pengumuman.',
            'budget_estimate' => 'Rp 1.000.000',
            'deadline' => now()->addDays(10)->toDateString(),
            'agency' => 'Dinas Uji',
            'location' => 'Medan',
        ])->assertForbidden();
    }

    public function test_admin_can_publish_procurement_and_talent_announcements(): void
    {
        $admin = User::where('role', 'admin_pemko')->firstOrFail();
        $deadline = now()->addDays(14)->toDateString();

        $this->actingAs($admin)->post(route('admin.announcements.store'), [
            'type' => 'procurement',
            'title' => 'Pengadaan Konsumsi Rapat Uji',
            'description' => 'Penyedia menyiapkan konsumsi rapat untuk kegiatan dinas.',
            'budget_estimate' => 'Rp 5.000.000',
            'deadline' => $deadline,
            'agency' => 'Dinas Uji Pemko Medan',
            'location' => 'Medan',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas('announcements', [
            'user_id' => $admin->id,
            'type' => 'procurement',
            'title' => 'Pengadaan Konsumsi Rapat Uji',
            'status' => 'open',
        ]);

        $announcement = Announcement::where('title', 'Pengadaan Konsumsi Rapat Uji')->firstOrFail();
        $this->post(route('admin.announcements.status', $announcement))->assertSessionHas('success');
        $this->assertDatabaseHas('announcements', ['id' => $announcement->id, 'status' => 'closed']);
        $this->post(route('admin.announcements.status', $announcement))->assertSessionHas('success');
        $this->assertDatabaseHas('announcements', ['id' => $announcement->id, 'status' => 'open']);

        $this->get(route('announcements.index', ['type' => 'procurement']))
            ->assertOk()
            ->assertSee('Pengadaan Konsumsi Rapat Uji');

        $this->post(route('admin.announcements.store'), [
            'type' => 'job_vacancy',
            'title' => 'Lowongan Pengembang Aplikasi Uji',
            'description' => 'Membuat aplikasi portal layanan pemerintahan.',
            'budget_estimate' => 'Rp 8.000.000',
            'deadline' => $deadline,
            'agency' => 'Dinas Uji Pemko Medan',
            'location' => 'Medan',
        ])->assertRedirect()->assertSessionHas('success');

        $this->assertDatabaseHas('announcements', [
            'user_id' => $admin->id,
            'type' => 'job_vacancy',
            'title' => 'Lowongan Pengembang Aplikasi Uji',
            'status' => 'open',
        ]);
    }

    /**
     * Test 4: Medan Talent Hub directory renders verified talents and badges.
     */
    public function test_talents_directory_renders_with_verified_badges(): void
    {
        $response = $this->get('/talents');

        $response->assertStatus(200);
        $response->assertSee('Medan Talent Hub');
        $response->assertSee('Rizky Ananda Siregar');
        $response->assertSee('Profil Talenta');
        $response->assertSee('Disnaker Certified');
        $response->assertSee('Portofolio');
        $response->assertSee('WhatsApp');
    }

    /**
     * Test 5: Announcement board and Expression of Interest submission.
     */
    public function test_announcements_board_and_apply_flow(): void
    {
        // 1. Announcements Board
        $response = $this->get('/announcements');
        $response->assertStatus(200);
        $response->assertSee('Papan Pengumuman Pengadaan & Lowongan Proyek', false);
        $response->assertSee('Pengadaan Konsumsi');

        // 2. Apply page
        $announcement = Announcement::firstOrFail();
        $umkm = Umkm::firstOrFail();
        $this->actingAs($umkm->user);

        $applyResponse = $this->get('/announcements/'.$announcement->id.'/apply');
        $applyResponse->assertStatus(200);
        $applyResponse->assertSee('Kirimkan Minat & Portofolio', false);

        // 3. Submit application
        $postData = [
            'applicant_name' => 'PT Mitra Kuliner Deli Bersama',
            'identifier' => '9120003418291',
            'contact_phone' => '081260001234',
            'proposal_note' => 'Kami memiliki sertifikasi Halal dan kapasitas produksi 500 boks snack per hari dengan standar higienis.',
            'terms' => '1',
        ];

        $submitResponse = $this->post('/announcements/'.$announcement->id.'/apply', $postData);
        $submitResponse->assertRedirect();
        $submitResponse->assertSessionHas('success');

        $this->assertDatabaseHas('applications', [
            'announcement_id' => $announcement->id,
            'contact_phone' => '081260001234',
            'applicant_name' => 'PT Mitra Kuliner Deli Bersama',
            'identifier' => '9120003418291',
        ]);
    }

    public function test_applications_are_limited_to_matching_roles_and_prevent_duplicates(): void
    {
        $announcement = Announcement::where('type', 'procurement')->firstOrFail();
        $umkm = Umkm::firstOrFail();
        $talent = Talent::firstOrFail();

        $this->actingAs($talent->user)
            ->get(route('announcements.apply', $announcement))
            ->assertForbidden();
        $this->post(route('announcements.submit', $announcement), [
            'applicant_name' => 'Talenta Uji',
            'identifier' => '1271011504950001',
            'contact_phone' => '081260001237',
            'proposal_note' => 'Talenta tidak boleh mengirim pengajuan untuk paket UMKM.',
            'terms' => '1',
        ])->assertForbidden();

        $this->actingAs($umkm->user)->post(route('announcements.submit', $announcement), [
            'applicant_name' => 'UMKM Uji',
            'identifier' => 'NIB-TEST-1',
            'contact_phone' => '081260001238',
            'proposal_note' => 'Pengalaman dan kapasitas produksi UMKM telah dijelaskan.',
            'terms' => '1',
        ])->assertRedirect();

        $this->post(route('announcements.submit', $announcement), [
            'applicant_name' => 'UMKM Uji',
            'identifier' => 'NIB-TEST-1',
            'contact_phone' => '081260001238',
            'proposal_note' => 'Pengajuan kedua tidak boleh tersimpan pada paket yang sama.',
            'terms' => '1',
        ])->assertSessionHas('error');

        $this->assertDatabaseCount('applications', 1);
    }

    public function test_applications_cannot_be_submitted_for_closed_or_expired_announcements(): void
    {
        $umkm = Umkm::firstOrFail();
        $admin = User::where('role', 'admin_pemko')->firstOrFail();
        $announcement = Announcement::create([
            'user_id' => $admin->id,
            'type' => 'procurement',
            'title' => 'Paket Kedaluwarsa',
            'description' => 'Paket pengadaan untuk menguji batas tanggal.',
            'budget_estimate' => 'Rp 1.000.000',
            'deadline' => now()->subDay()->toDateString(),
            'agency' => 'Dinas Uji',
            'location' => 'Medan',
            'status' => 'open',
        ]);

        $this->actingAs($umkm->user)
            ->post(route('announcements.submit', $announcement), [
                'applicant_name' => 'UMKM Uji',
                'identifier' => 'NIB-TEST-2',
                'contact_phone' => '081260001239',
                'proposal_note' => 'Tidak boleh mengajukan setelah batas tanggal terlewati.',
                'terms' => '1',
            ])
            ->assertNotFound();

        $this->assertDatabaseMissing('applications', ['announcement_id' => $announcement->id]);
    }

    public function test_application_submission_requires_an_account(): void
    {
        $announcement = Announcement::firstOrFail();

        $this->get(route('announcements.apply', $announcement))
            ->assertRedirect();

        $this->post(route('announcements.submit', $announcement), [
            'applicant_name' => 'Pengguna Tanpa Akun',
            'identifier' => '1271011504950001',
            'contact_phone' => '081260001237',
            'proposal_note' => 'Proposal untuk memastikan pendaftaran akun diwajibkan.',
            'terms' => '1',
        ])->assertRedirect();

        $this->assertDatabaseMissing('applications', [
            'announcement_id' => $announcement->id,
            'contact_phone' => '081260001237',
        ]);
    }

    /**
     * Test 6: Auth login, registration, and logout endpoints.
     */
    public function test_talent_can_delete_only_their_rejected_application(): void
    {
        $talent = Talent::firstOrFail();
        $announcement = Announcement::firstOrFail();

        $rejectedApplication = Application::create([
            'announcement_id' => $announcement->id,
            'user_id' => $talent->user_id,
            'proposal_note' => 'Proposal lamaran talenta yang ditolak.',
            'contact_phone' => '081260001234',
            'status' => 'rejected',
        ]);

        $pendingAnnouncement = Announcement::create([
            'user_id' => User::where('role', 'admin_pemko')->firstOrFail()->id,
            'type' => $announcement->type,
            'title' => 'Pengumuman kedua untuk uji hapus',
            'description' => 'Pengumuman lain untuk menguji bahwa lamaran berjalan tidak dapat dihapus.',
            'budget_estimate' => 'Rp 1.000.000',
            'deadline' => now()->addDays(10)->toDateString(),
            'agency' => 'Dinas Uji',
            'location' => 'Medan',
            'status' => 'open',
        ]);
        $pendingApplication = Application::create([
            'announcement_id' => $pendingAnnouncement->id,
            'user_id' => $talent->user_id,
            'proposal_note' => 'Proposal lamaran talenta yang masih diproses.',
            'contact_phone' => '081260001235',
            'status' => 'pending',
        ]);

        $this->actingAs($talent->user)
            ->delete(route('announcements.applications.destroy', $rejectedApplication))
            ->assertRedirect(route('announcements.my_applications'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('applications', ['id' => $rejectedApplication->id]);

        $this->actingAs($talent->user)
            ->delete(route('announcements.applications.destroy', $pendingApplication))
            ->assertForbidden();

        $this->assertDatabaseHas('applications', ['id' => $pendingApplication->id]);
    }

    public function test_talent_cannot_delete_another_users_rejected_application(): void
    {
        $talent = Talent::firstOrFail();
        $otherUser = User::where('role', 'umkm')->firstOrFail();
        $announcement = Announcement::firstOrFail();

        $application = Application::create([
            'announcement_id' => $announcement->id,
            'user_id' => $otherUser->id,
            'proposal_note' => 'Proposal milik pengguna lain.',
            'contact_phone' => '081260001236',
            'status' => 'rejected',
        ]);

        $this->actingAs($talent->user)
            ->delete(route('announcements.applications.destroy', $application))
            ->assertForbidden();

        $this->assertDatabaseHas('applications', ['id' => $application->id]);
    }

    public function test_auth_login_and_registration(): void
    {
        // 1. Register new UMKM user
        $regData = [
            'name' => 'Kopi Tarigan Express',
            'email' => 'tarigan.express@gmail.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
            'phone' => '081299998888',
            'role' => 'umkm',
        ];

        $regResponse = $this->post('/register', $regData);
        $regResponse->assertRedirect();
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['id' => auth()->id(), 'is_verified' => false]);
        $this->assertDatabaseHas('umkms', ['user_id' => auth()->id(), 'nib' => null]);

        // 2. Logout
        $logoutResponse = $this->post('/logout');
        $logoutResponse->assertRedirect('/');
        $this->assertGuest();

        // 3. Login
        $loginResponse = $this->post('/login', [
            'email' => 'tarigan.express@gmail.com',
            'password' => 'secret12345',
        ]);
        $loginResponse->assertRedirect();
        $this->assertAuthenticated();
    }

    public function test_user_can_request_and_complete_password_reset(): void
    {
        Notification::fake();
        $user = User::where('role', 'umkm')->firstOrFail();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertSessionHas('status');

        $token = null;
        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use (&$token) {
            $token = $notification->token;

            return true;
        });

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-test-password',
            'password_confirmation' => 'new-test-password',
        ])->assertRedirect(route('home'))->assertSessionHas('success');

        $this->assertTrue(Hash::check('new-test-password', $user->fresh()->password));
    }

    public function test_umkm_and_talent_can_update_and_delete_only_their_own_items(): void
    {
        Storage::fake('public');
        $umkm = Umkm::firstOrFail();
        $product = $umkm->products()->create([
            'name' => 'Produk awal',
            'description' => 'Deskripsi awal',
        ]);

        $this->actingAs($umkm->user)
            ->put(route('umkm.products.update', $product), [
                'name' => 'Produk diperbarui',
                'description' => 'Deskripsi baru',
            ])
            ->assertSessionHas('success');
        $this->assertDatabaseHas('umkm_products', ['id' => $product->id, 'name' => 'Produk diperbarui']);

        $talent = Talent::firstOrFail();
        $portfolio = $talent->portfolio()->create([
            'title' => 'Karya awal',
            'description' => 'Deskripsi awal',
        ]);
        $this->actingAs($talent->user)
            ->put(route('talent.portfolio.update', $portfolio), [
                'title' => 'Karya diperbarui',
                'description' => 'Deskripsi baru',
            ])
            ->assertSessionHas('success');
        $this->assertDatabaseHas('portfolios', ['id' => $portfolio->id, 'title' => 'Karya diperbarui']);

        $this->delete(route('talent.portfolio.destroy', $portfolio))
            ->assertSessionHas('success');
        $this->actingAs($umkm->user)
            ->delete(route('umkm.products.destroy', $product))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
        $this->assertDatabaseMissing('umkm_products', ['id' => $product->id]);
    }
}
