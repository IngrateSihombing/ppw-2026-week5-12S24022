# SIPUS-Del — Sistem Informasi Perpustakaan

SIPUS-Del adalah aplikasi web berbasis Laravel 11 yang digunakan untuk mengelola data buku, kategori buku, serta transaksi peminjaman dan pengembalian buku. Aplikasi ini dilengkapi autentikasi pustakawan, dashboard informasi perpustakaan, SOAP Web Service, REST API, dan integrasi dengan layanan eksternal OpenLibrary.

## Fitur Utama

### 1. Pengelolaan Perpustakaan
- Login dan logout pustakawan.
- Menampilkan dashboard statistik perpustakaan.
- Menampilkan, menambah, mengedit, dan menghapus data buku.
- Menampilkan, menambah, mengedit, dan menghapus kategori buku.
- Pencarian buku berdasarkan kata kunci.
- Pagination untuk menampilkan daftar buku.
- Relasi Buku dan Kategori menggunakan Eloquent ORM.
- Eager loading dan `withCount()` untuk membantu efisiensi query.

### 2. Peminjaman dan Pengembalian
- Peminjaman dan pengembalian buku dengan validasi stok.
- Pencegahan peminjaman ketika stok buku habis.
- Transaksi database menggunakan `DB::transaction()` dan penguncian data menggunakan `lockForUpdate()`.
- Pengelolaan session dan cookie untuk mendukung autentikasi dan menyimpan informasi peminjam terakhir.

### 3. Web Service dan REST API
- SOAP Web Service untuk pemeriksaan status clearance peminjam.
- REST API dengan prefix versi `/api/v1`.
- Autentikasi REST API menggunakan Laravel Sanctum dengan Bearer Token.
- Pengelolaan token melalui endpoint login dan logout.
- Pengambilan daftar buku melalui REST API.
- Eloquent Resource untuk membentuk respons JSON.
- Penerapan tautan HATEOAS pada respons data buku.
- Penanganan kesalahan API menggunakan format RFC 7807 (`application/problem+json`).
- Integrasi REST API dengan OpenLibrary sebagai layanan eksternal.
- Dokumentasi API menggunakan OpenAPI 3.0.3.

## Teknologi

- Laravel 11
- PHP 8.3
- MySQL
- Bootstrap
- Vite
- Eloquent ORM
- Laravel Sanctum
- SOAP
- REST API
- OpenAPI 3.0.3
- OpenLibrary API

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

7. Jalankan seeder untuk mengisi data awal jika diperlukan:

   ```bash
   php artisan db:seed
   ```

   Pastikan konfigurasi database dan isi seeder sesuai dengan kondisi lingkungan lokal sebelum menjalankannya.

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

## SOAP Web Service

SOAP Web Service digunakan untuk memeriksa status clearance peminjam berdasarkan NIM.

Endpoint SOAP:

```text
POST http://127.0.0.1:8000/soap/sipus
```

WSDL:

```text
http://127.0.0.1:8000/soap/sipus.wsdl
```

Operasi yang disediakan adalah `CheckClearanceStatus`. Layanan memberikan informasi jumlah peminjaman aktif dan status clearance peminjam. Permintaan yang tidak memenuhi ketentuan akan menghasilkan SOAP Fault.

## REST API

REST API menggunakan prefix versi `v1` dan tersedia melalui:

```text
http://127.0.0.1:8000/api/v1
```

### Daftar Endpoint

| Method | Endpoint | Keterangan | Autentikasi |
|---|---|---|---|
| POST | `/login` | Login dan memperoleh Bearer Token | Tidak |
| POST | `/logout` | Logout dan mencabut token | Ya |
| GET | `/bukus` | Menampilkan daftar buku | Ya |
| GET | `/openlibrary/search?q=kata_kunci` | Mencari buku melalui OpenLibrary | Ya |

Autentikasi REST API menggunakan Laravel Sanctum. Pengguna melakukan login untuk memperoleh Bearer Token, kemudian menyertakan token tersebut pada header `Authorization` ketika mengakses endpoint yang dilindungi.

Contoh header:

```http
Accept: application/json
Authorization: Bearer {token}
```

### Eloquent Resource dan HATEOAS

Data buku disajikan menggunakan `BukuResource` agar struktur respons JSON lebih konsisten.

Respons buku juga dilengkapi tautan navigasi HATEOAS:

- `self`: tautan referensi menuju sumber daya buku.
- `collection`: tautan menuju koleksi buku.

### RFC 7807

Penanganan kesalahan REST API menggunakan format RFC 7807 dengan Content-Type:

```text
application/problem+json
```

Respons kesalahan memuat informasi seperti `type`, `title`, `status`, `detail`, dan `errors` untuk membantu konsumen API memahami masalah yang terjadi.

## Integrasi OpenLibrary API

SIPUS-Del terintegrasi dengan OpenLibrary untuk melakukan pencarian informasi buku melalui layanan eksternal.

Endpoint internal:

```text
GET /api/v1/openlibrary/search?q=harry+potter
```

Informasi yang dapat ditampilkan mencakup:

- Judul buku.
- Nama penulis.
- Tahun publikasi pertama.
- ISBN.
- Identitas buku OpenLibrary.

Parameter pencarian `q` wajib diisi dan memiliki panjang minimal dua karakter. Jika permintaan tidak memenuhi aturan validasi, API memberikan respons HTTP 422.

## Dokumentasi dan Pengujian API

Dokumentasi REST API menggunakan OpenAPI 3.0.3 dan disimpan pada:

```text
openapi.yaml
```

Dokumentasi tersebut mencakup endpoint login, logout, daftar buku, pencarian OpenLibrary, serta skema autentikasi Bearer Token. Validasi dokumentasi dilakukan menggunakan Swagger Editor.

File Postman disiapkan pada direktori:

```text
docs/postman/
```

File yang tersedia:

- `SIPUS-Del-Collection.json`
- `SIPUS-Del-Environment.json`

Kedua file telah divalidasi menggunakan PowerShell. Pengujian endpoint yang dicatat dalam laporan dilakukan menggunakan PowerShell, bukan melalui aplikasi Postman Desktop.

Laporan hasil pengujian tersedia pada:

```text
docs/API-Testing-Report.md
```

Pengujian mencakup SOAP, REST API, autentikasi Sanctum, HATEOAS, validasi OpenLibrary, serta penanganan kesalahan RFC 7807.

## Struktur Proyek

- `app/Models` — model Buku, Kategori, Peminjaman, dan User.
- `app/Http/Controllers` — controller untuk autentikasi, dashboard, buku, kategori, peminjaman, SOAP, dan REST API.
- `app/Http/Resources` — resource untuk membentuk respons API.
- `database/migrations` — struktur tabel database.
- `database/factories` — pembuatan data contoh.
- `database/seeders` — pengisian data awal.
- `resources/views` — tampilan aplikasi.
- `routes/web.php` — definisi rute aplikasi web.
- `routes/api.php` — definisi rute REST API.
- `docs/postman` — Postman Collection dan Environment.
- `docs/API-Testing-Report.md` — laporan hasil pengujian API.
- `openapi.yaml` — dokumentasi OpenAPI.

## Keamanan Repository

File `.env` berisi konfigurasi lokal dan tidak boleh diunggah ke repository publik. Gunakan `.env.example` sebagai contoh konfigurasi. Folder `vendor` dan `node_modules` juga tidak perlu diunggah ke repository.

Jangan menyimpan password, Bearer Token, atau kredensial asli ke dalam dokumentasi maupun repository publik.
