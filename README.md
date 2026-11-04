# SIPUS-Del — Sistem Informasi Perpustakaan

SIPUS-Del adalah aplikasi web berbasis Laravel 11 yang digunakan untuk mengelola data buku, kategori buku, dan transaksi peminjaman serta pengembalian buku. Aplikasi ini dilengkapi autentikasi pustakawan, pencarian buku, dan dashboard informasi perpustakaan.

## Fitur Utama

- Login dan logout pustakawan.
- Menampilkan dashboard statistik perpustakaan.
- Menampilkan, menambah, mengedit, dan menghapus data buku.
- Menampilkan, menambah, mengedit, dan menghapus kategori buku.
- Pencarian buku berdasarkan kata kunci.
- Pagination untuk menampilkan daftar buku.
- Relasi Buku dan Kategori menggunakan Eloquent ORM.
- Eager loading dan `withCount()` untuk membantu efisiensi query.
- Peminjaman dan pengembalian buku dengan validasi stok.
- Pencegahan peminjaman ketika stok buku habis.
- Transaksi database menggunakan `DB::transaction()` dan penguncian data menggunakan `lockForUpdate()`.
- Pengelolaan session dan cookie untuk mendukung autentikasi dan menyimpan informasi peminjam terakhir.

## Teknologi

- Laravel 11
- PHP 8.3
- MySQL
- Bootstrap
- Vite
- Eloquent ORM

## Persiapan

Pastikan PHP, Composer, Node.js, npm, dan Laragon sudah terpasang.

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

3. Salin `.env.example` menjadi `.env`, lalu sesuaikan konfigurasi database MySQL dengan lingkungan lokal.

4. Buat database MySQL bernama `sipus_del_week6` melalui Laragon atau perangkat pengelola database.

5. Buat application key:

   ```bash
   php artisan key:generate
   ```

6. Jalankan migrasi:

   ```bash
   php artisan migrate
   ```

7. Jalankan seeder untuk mengisi data awal:

   ```bash
   php artisan db:seed
   ```

   Pastikan seluruh seeder berhasil sebelum menggunakan aplikasi.

8. Jalankan aplikasi Laravel:

   ```bash
   php artisan serve
   ```

9. Pada terminal terpisah, jalankan Vite:

   ```bash
   npm run dev
   ```

10. Buka `http://127.0.0.1:8000` di browser.

## Database dan Relasi

Database menggunakan MySQL dengan tabel yang mencakup:

- `kategoris`: menyimpan data kategori buku.
- `bukus`: menyimpan informasi buku, kategori, dan stok.
- `peminjamans`: menyimpan kode transaksi, buku yang dipinjam, identitas peminjam, tanggal pinjam, tanggal jatuh tempo, tanggal kembali, dan status transaksi.
- `users`: menyimpan akun pustakawan.

Setiap buku memiliki satu kategori melalui relasi `belongsTo`, sedangkan satu kategori dapat memiliki banyak buku melalui relasi `hasMany`. Data peminjaman terhubung dengan buku melalui relasi `belongsTo`.

## Query Database

Aplikasi memanfaatkan beberapa pendekatan akses database:

- **Eloquent ORM** untuk operasi data melalui model.
- **Query Builder** untuk membangun query pencarian dan pengambilan data secara dinamis.
- **Raw SQL** untuk kebutuhan query tertentu dengan parameter binding.
- `when()` untuk menerapkan filter hanya ketika kata kunci pencarian diisi.
- `with('kategori')` untuk mengambil relasi kategori secara eager loading.
- `withCount()` untuk menghitung jumlah relasi peminjaman.
- `paginate(10)->withQueryString()` untuk pagination yang mempertahankan parameter pencarian.

## Transaksi Peminjaman dan Pengembalian

Proses peminjaman memeriksa ketersediaan stok sebelum transaksi disimpan. Transaksi database digunakan agar perubahan data peminjaman dan stok tetap konsisten.

Penggunaan `DB::transaction()` dan `lockForUpdate()` membantu mencegah konflik ketika beberapa proses mengakses stok buku secara bersamaan. Jika stok habis, peminjaman ditolak. Saat buku dikembalikan, status transaksi diperbarui dan stok buku ditambah kembali.

## Autentikasi, Session, dan Cookie

Aplikasi menyediakan login dan logout pustakawan. Autentikasi menggunakan `Auth::attempt()`, regenerasi session setelah login, serta middleware `auth` untuk melindungi halaman yang memerlukan autentikasi.

Saat logout, session diinvalidasi dan token CSRF diperbarui. Aplikasi juga menggunakan cookie untuk menyimpan informasi peminjam terakhir dengan pengaturan keamanan seperti `HttpOnly` dan `SameSite=Lax`.

## Pengujian

Pengujian aplikasi mencakup:

- Login dan logout pustakawan.
- Pembatasan akses halaman untuk pengguna yang belum login.
- Pencarian dan pagination daftar buku.
- Peminjaman buku yang stoknya tersedia.
- Penolakan peminjaman saat stok habis.
- Perubahan stok ketika peminjaman dan pengembalian.
- Konsistensi status transaksi peminjaman.
- Pemeriksaan cookie dan session melalui browser DevTools.

Screenshot hasil pengujian dapat ditambahkan pada bagian dokumentasi pengujian atau disimpan dalam folder dokumentasi proyek.

## Struktur Proyek

- `app/Models` — model Buku, Kategori, Peminjaman, dan User.
- `app/Http/Controllers` — controller untuk autentikasi, dashboard, buku, kategori, dan peminjaman.
- `database/migrations` — struktur tabel database.
- `database/factories` — pembuatan data contoh.
- `database/seeders` — pengisian data awal.
- `resources/views` — tampilan aplikasi.
- `routes/web.php` — definisi rute aplikasi.

## Keamanan Repository

File `.env` berisi konfigurasi lokal dan tidak boleh diunggah ke repository publik. Gunakan `.env.example` sebagai contoh konfigurasi. Folder `vendor` dan `node_modules` juga tidak perlu diunggah ke repository.