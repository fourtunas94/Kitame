# KITAME

KITAME (Katalog Informasi Talenta & UMKM Medan) adalah portal informasi non-transaksional untuk direktori UMKM dan talenta lokal serta pengumuman pengadaan dan lowongan proyek di Kota Medan.

## Fitur

- Direktori UMKM dan talenta dengan pencarian dan filter.
- Profil publik serta pengelolaan profil UMKM dan portofolio talenta.
- Publikasi profil UMKM dan talenta oleh admin; status tampil di direktori terpisah dari penanda E-Katalog dan sertifikasi.
- Unggah foto usaha, logo, dan produk.
- Pengumuman pengadaan/lowongan, pengajuan, serta pemantauan status.
- Ekspor data pengajuan pelamar dalam format PDF khusus admin, untuk seluruh pengumuman atau per pengumuman.
- Akses berbasis peran untuk admin, UMKM, dan talenta.

## Persyaratan

- PHP 8.2 atau lebih baru dengan ekstensi `pdo_pgsql`, `pgsql`, `mbstring`, `openssl`, `fileinfo`, dan `intl`.
- PostgreSQL 14 atau lebih baru.
- Composer dan Node.js/npm.

## Menjalankan aplikasi

1. Instal dependensi:

   ```sh
   composer install
   npm ci
   ```

2. Salin `.env.example` menjadi `.env`, lalu isi koneksi PostgreSQL dan mail. Buat database `kitame` terlebih dahulu.

   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=kitame
   DB_USERNAME=postgres
   DB_PASSWORD=kata-sandi-postgresql-anda
   ```

3. Siapkan aplikasi:

   ```sh
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   npm run build
   php artisan serve
   ```

Untuk data contoh di lingkungan pengembangan saja, jalankan `php artisan db:seed`. Jangan gunakan akun atau data seeder di produksi.

Fitur reset kata sandi membutuhkan pengaturan mail yang benar di `.env` (misalnya SMTP). Jangan gunakan kredensial contoh di lingkungan produksi.

Jika sebelumnya memakai SQLite, isi database lama tidak dipindahkan otomatis. Ekspor/impor data perlu dilakukan secara terpisah setelah database PostgreSQL siap.

## Hosting produksi (PHP + PostgreSQL)

Proyek dapat dipasang pada hosting yang menyediakan PHP 8.2+, ekstensi `pdo_pgsql`, `pgsql`, `mbstring`, `openssl`, `fileinfo`, dan `intl`, serta PostgreSQL 14+. Folder web root/document root wajib diarahkan ke folder `public/`, bukan ke root proyek. Jika hosting memakai `public_html`, simpan kode aplikasi di luar folder publik lalu atur document root ke folder `public/` aplikasi.

1. Salin `.env.production.example` menjadi `.env` di server. Isi domain HTTPS, kredensial database, dan kredensial SMTP yang diberikan penyedia hosting. Jangan unggah `.env` pengembangan, membagikan rahasianya, atau memasukkannya ke Git. Buat kunci aplikasi baru dengan `php artisan key:generate`.
2. Buat database PostgreSQL kosong dan pengguna khusus aplikasi. Jangan jalankan seeder contoh di produksi. Data lokal tidak ikut tersalin; pindahkan hanya jika memang diperlukan.
3. Buat aset front-end di lingkungan build dengan `npm ci` dan `npm run build`, lalu deploy folder `public/build` bersama kode. Jangan menjalankan Vite dalam mode development di server publik.
4. Di server, jalankan perintah berikut setelah `.env` diisi:

   ```sh
   composer install --no-dev --optimize-autoloader --no-interaction
   php artisan migrate --force
   php artisan storage:link
   php artisan optimize:clear
   php artisan optimize
   ```

5. Pastikan `storage/` dan `bootstrap/cache/` dapat ditulis oleh proses PHP. Folder `storage/app/public` berisi foto yang diunggah, jadi gunakan disk persisten dan backup rutin. Aktifkan HTTPS; template produksi mengaktifkan cookie sesi secure.
6. Konfigurasi PHP hosting dengan `upload_max_filesize` minimal `5M` dan `post_max_size` minimal `8M` agar unggahan gambar hingga batas aplikasi 4 MB dapat diterima. Uji login, unggah gambar, SMTP reset kata sandi, dan halaman utama setelah deploy.

Template memakai antrean sinkron (`QUEUE_CONNECTION=sync`) agar tidak memerlukan worker tambahan pada hosting biasa. Jika kelak pekerjaan antrean digunakan, siapkan worker sesuai penyedia hosting.

## Pengujian

```sh
php artisan test
```

Suite pengujian memakai SQLite in-memory melalui `phpunit.xml`, sehingga pengujian tidak memerlukan database PostgreSQL aktif.
