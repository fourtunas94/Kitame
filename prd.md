# Product Requirements Document (PRD)
## Project Name: KITAME (Katalog Informasi Talenta & UMKM Medan)

### 1. Visi & Latar Belakang
KITAME adalah platform direktori informasi resmi dan papan pengumuman pengadaan/lowongan (*G2C & G2B Information Portal*) untuk Kota Medan. Sistem ini dirancang secara non-transaksional (tanpa transaksi finansial internal) guna menghubungkan secara transparan antara Pemerintah Kota Medan, pelaku UMKM, talenta lokal, dan warga.

### 2. Sasaran Pengguna (User Personas)
* **Admin Pemko Medan:** Mengelola verifikasi data (NIK Dukcapil & NIB OSS) serta mempublikasikan pengumuman pengadaan atau lowongan proyek.
* **Pelaku UMKM:** Mendaftarkan usaha, memajang katalog produk untuk pengadaan instansi, dan mendaftar pada program pengadaan pemerintah.
* **Talenta Lokal / Freelancer:** Menampilkan portofolio, keahlian, dan melamar lowongan proyek berbasis keahlian.
* **Warga / Pengguna Umum:** Mencari direktori jasa atau produk lokal terverifikasi di Kota Medan.

### 3. Lingkup Sistem (In-Scope vs Out-of-Scope)
* **In-Scope:**
  * Sistem Autentikasi & Validasi Peran (Admin, UMKM, Talent, Citizen).
  * Direktori Pencarian UMKM & Talenta dengan filter kategori dan kecamatan.
  * Papan Pengumuman Pengadaan & Lowongan Proyek (*Procurement & Job Board*).
  * Formulir Pengajuan Minat (*Expression of Interest*).
* **Out-of-Scope:**
  * Transaksi jual beli langsung (*Cart & Checkout*).
  * *Payment Gateway* / Pembayaran digital internal aplikasi.

### 4. Tech Stack
* **Backend:** Laravel Framework (PHP)
* **Database:** PostgreSQL
* **Frontend / UI:** Blade Templates dengan struktur desain modern responsif (Tailwind CSS)