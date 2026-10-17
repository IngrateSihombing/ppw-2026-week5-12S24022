# SIPUS-Del — Sistem Informasi Perpustakaan

SIPUS-Del adalah aplikasi web berbasis Laravel 11 untuk mengelola data buku dan kategori buku.

## Fitur Utama

- Menampilkan daftar buku dan kategori.
- Menambah, mengedit, dan menghapus data buku.
- Menambah, mengedit, dan menghapus kategori buku.
- Validasi data buku dan kategori.
- Relasi antara Buku dan Kategori menggunakan Eloquent ORM.
- Eager loading untuk mengurangi query database berulang.
- Pagination dan notifikasi operasi.
- SQL Audit Logging untuk mencatat query database.

## Teknologi
- Laravel 11
- PHP 8.3
- SQLite
- Bootstrap
- Vite

## Persiapan

Pastikan PHP, Composer, Node.js, dan npm sudah terpasang.

## Cara Menjalankan

1. Clone repository:

   ```bash
   git clone https://github.com/IngrateSihombing/ppw-2026-week5-12S24022.git
   cd ppw-2026-week5-12S24022
   ```

2. Instal dependensi:

   ```bash
   composer install
   npm install
   ```

3. Salin `.env.example` menjadi `.env`.

4. Buat file database SQLite `database/database.sqlite` jika belum tersedia.

5. Jalankan:

   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

6. Buka dua terminal terpisah dan jalankan:

   ```bash
   php artisan serve
   ```

   ```bash
   npm run dev
   ```

7. Buka `http://127.0.0.1:8000` di browser.

## Database dan Relasi

Aplikasi menggunakan dua tabel utama, yaitu `bukus` dan `kategoris`. Setiap buku memiliki kategori melalui relasi `belongsTo`, sedangkan kategori dapat memiliki banyak buku melalui relasi `hasMany`.

## SQL Audit Logging

SQL Audit Logging menggunakan `DB::listen()` pada `AppServiceProvider` untuk mencatat query SQL beserta waktu eksekusinya ke `storage/logs/laravel.log`.

Halaman daftar buku menggunakan `Buku::with('kategori')` untuk mengambil data buku beserta kategorinya dengan eager loading sehingga mengurangi query berulang.

## Struktur Proyek

- `app/Models` — model Buku dan Kategori.
- `app/Http/Controllers` — controller buku dan kategori.
- `database/migrations` — struktur tabel database.
- `database/factories` — data contoh.
- `database/seeders` — pengisian data awal.
- `resources/views` — tampilan aplikasi.
- `routes/web.php` — rute aplikasi.

## Keamanan Repository

File `.env` berisi konfigurasi lokal dan tidak boleh diunggah ke repository publik. Gunakan `.env.example` sebagai contoh konfigurasi. Folder `vendor` dan `node_modules` juga tidak perlu diunggah.