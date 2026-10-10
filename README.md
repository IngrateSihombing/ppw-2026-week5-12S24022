# SIPUS-Del — Sistem Informasi Perpustakaan

Aplikasi web berbasis Laravel 11 untuk mengelola data buku dan kategori buku.

## Fitur Utama
- Menampilkan daftar buku beserta kategorinya.
- Menambah, mengedit, dan menghapus data buku.
- Mengelola kategori buku melalui operasi CRUD.
- Validasi input dan relasi antarmodel menggunakan Eloquent ORM.
- Eager loading untuk mengurangi query database berulang.
- Pagination dan notifikasi hasil operasi.
- SQL Audit Logging untuk mencatat query database.

## Teknologi
- Laravel 11
- PHP 8.3
- SQLite
- Bootstrap
- Vite

## Cara Menjalankan
1. Clone repository ini.
2. Jalankan `composer install` dan `npm install`.
3. Salin `.env.example` menjadi `.env`.
4. Pastikan file database `database/database.sqlite` tersedia.
5. Jalankan `php artisan key:generate`.
6. Jalankan `php artisan migrate --seed`.
7. Jalankan `php artisan serve`.
8. Pada terminal terpisah, jalankan `npm run dev`.
9. Buka `http://127.0.0.1:8000`.

## SQL Audit Logging
Query SQL dan waktu eksekusinya dicatat melalui `DB::listen()` di `AppServiceProvider` ke `storage/logs/laravel.log`.

Halaman daftar buku menggunakan `Buku::with('kategori')` untuk mengambil data kategori dengan eager loading.

## Struktur Proyek
- `app/Models` — model Buku dan Kategori.
- `app/Http/Controllers` — controller aplikasi.
- `database/migrations` — struktur tabel database.
- `database/factories` — data contoh.
- `database/seeders` — data awal.
- `resources/views` — tampilan Blade.
- `routes/web.php` — rute aplikasi.

## Keamanan
Jangan mengunggah file `.env`, `vendor`, atau `node_modules` ke repository publik.
