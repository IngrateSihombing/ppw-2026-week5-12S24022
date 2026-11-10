# Laporan Pengujian API SIPUS-Del

## 1. Tujuan Pengujian

Pengujian dilakukan untuk memastikan layanan web SIPUS-Del dapat berjalan dengan baik, baik melalui SOAP maupun REST API. Pengujian juga mencakup autentikasi menggunakan Laravel Sanctum, penerapan HATEOAS, RFC 7807, serta integrasi dengan layanan eksternal OpenLibrary.

## 2. Lingkungan Pengujian

| Komponen | Keterangan |
|---|---|
| Framework | Laravel 11 |
| Bahasa Pemrograman | PHP |
| Database | MySQL |
| REST API | Laravel API |
| Autentikasi | Laravel Sanctum |
| Standar Dokumentasi API | OpenAPI 3.0.3 |
| Layanan Eksternal | OpenLibrary API |
| Pengujian | PowerShell |
| Postman Collection | docs/postman/SIPUS-Del-Collection.json |
| Postman Environment | docs/postman/SIPUS-Del-Environment.json |

## 3. Hasil Pengujian

### 3.1 Pengujian SOAP

| No. | Skenario | Hasil yang Diharapkan | Hasil |
|---|---|---|---|
| 1 | Mengakses WSDL | WSDL berhasil ditampilkan | Berhasil |
| 2 | Mengirim permintaan SOAP dengan NIM | Sistem menampilkan status peminjaman | Berhasil |
| 3 | Mengirim permintaan tanpa NIM | Sistem memberikan SOAP Fault | Berhasil |

Contoh hasil pengujian menunjukkan bahwa NIM pengujian memiliki 3 peminjaman aktif dan status clearance bernilai false.

### 3.2 Pengujian REST API

| No. | Skenario | Hasil yang Diharapkan | Hasil |
|---|---|---|---|
| 1 | Login dengan akun valid | Sistem memberikan Bearer Token | Berhasil |
| 2 | Mengakses daftar buku dengan token | Data buku ditampilkan dalam format JSON | Berhasil |
| 3 | Logout menggunakan token | Token berhasil dicabut | Berhasil |
| 4 | Mengakses API menggunakan token yang sudah dicabut | Sistem menolak akses dengan HTTP 401 | Berhasil |

### 3.3 Pengujian HATEOAS

Pengujian dilakukan pada endpoint GET `/api/v1/bukus`.

Respons API menampilkan data buku beserta tautan navigasi:

- `self`: tautan referensi untuk sumber daya buku.
- `collection`: tautan menuju koleksi buku.

Dengan demikian, respons REST API telah menyertakan informasi tautan HATEOAS.

### 3.4 Pengujian OpenLibrary API

| No. | Skenario | Hasil yang Diharapkan | Hasil |
|---|---|---|---|
| 1 | Pencarian buku dengan kata kunci valid | Sistem menampilkan hasil pencarian | Berhasil |
| 2 | Parameter q tidak diisi | Sistem memberikan HTTP 422 | Berhasil |
| 3 | Kata kunci kurang dari 2 karakter | Sistem memberikan HTTP 422 | Berhasil |

Integrasi OpenLibrary berhasil menampilkan informasi buku, seperti judul, penulis, tahun publikasi, ISBN, dan identitas buku.

### 3.5 Pengujian RFC 7807

| No. | Skenario | Status HTTP | Hasil |
|---|---|---|---|
| 1 | Mengakses endpoint tanpa autentikasi | 401 | Berhasil |
| 2 | Mengirim data yang tidak memenuhi validasi | 422 | Berhasil |

Respons kesalahan menggunakan format `application/problem+json` dengan informasi seperti type, title, status, detail, dan errors.

## 4. Dokumentasi OpenAPI

Dokumentasi REST API dibuat menggunakan OpenAPI 3.0.3 dan disimpan pada file:

`openapi.yaml`

Dokumentasi mencakup endpoint login, logout, daftar buku, serta pencarian buku melalui OpenLibrary.

Validasi dokumentasi dilakukan menggunakan Swagger Editor.

## 5. Postman Collection dan Environment

File pengujian disiapkan pada direktori `docs/postman/`, yaitu:

- `SIPUS-Del-Collection.json`
- `SIPUS-Del-Environment.json`

Kedua file telah divalidasi menggunakan PowerShell. Pengujian endpoint yang tercantum dalam laporan dilakukan menggunakan PowerShell, bukan melalui aplikasi Postman Desktop.

## 6. Kesimpulan

Berdasarkan pengujian yang telah dilakukan, layanan SOAP dan REST API SIPUS-Del dapat berjalan sesuai skenario yang diuji. Autentikasi menggunakan Laravel Sanctum berhasil diterapkan, respons API telah dilengkapi tautan HATEOAS, dan penanganan kesalahan menggunakan format RFC 7807 berhasil diuji. Integrasi dengan OpenLibrary juga berhasil menampilkan hasil pencarian buku dari layanan eksternal.