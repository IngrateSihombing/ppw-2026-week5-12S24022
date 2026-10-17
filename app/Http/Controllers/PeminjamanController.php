<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function create()
{
    $bukus = Buku::orderBy('judul')->get();

    return view('peminjamans.create', compact('bukus'));
}
    public function store(Request $request)
    {
        // 1. Validasi data dari form
        $data = $request->validate([
            'buku_id' => ['required', 'integer', 'exists:bukus,id'],
            'nim_peminjam' => ['required', 'string', 'max:255'],
            'nama_peminjam' => ['required', 'string', 'max:255'],
            'tanggal_jatuh_tempo' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
        ]);

        try {
            // 2. Jalankan transaksi database
            DB::transaction(function () use ($data) {

                // 3. Kunci data buku selama transaksi
                $buku = Buku::whereKey($data['buku_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                // 4. Tolak peminjaman jika stok habis
                if ($buku->stok < 1) {
                    throw ValidationException::withMessages([
                        'buku_id' => 'Stok buku habis. Peminjaman ditolak.',
                    ]);
                }

                // 5. Cek apakah mahasiswa masih meminjam buku yang sama
                $sudahMeminjam = Peminjaman::where(
                    'buku_id',
                    $buku->id
                )
                    ->where('nim_peminjam', $data['nim_peminjam'])
                    ->where('status', 'dipinjam')
                    ->exists();

                if ($sudahMeminjam) {
                    throw ValidationException::withMessages([
                        'buku_id' => 'Mahasiswa masih meminjam buku ini.',
                    ]);
                }

                // 6. Kurangi stok buku satu buah
                $buku->decrement('stok');

                // 7. Simpan transaksi peminjaman
                Peminjaman::create([
                    'kode_pinjam' => (string) Str::uuid(),
                    'buku_id' => $buku->id,
                    'nim_peminjam' => $data['nim_peminjam'],
                    'nama_peminjam' => $data['nama_peminjam'],
                    'tanggal_pinjam' => now()->toDateString(),
                    'tanggal_jatuh_tempo' =>
                        $data['tanggal_jatuh_tempo'],
                    'status' => 'dipinjam',
                ]);
            });

            return back()->with(
                'success',
                'Peminjaman buku berhasil dicatat.'
            );

        } catch (ValidationException $e) {
            throw $e;

        } catch (QueryException $e) {
            // 8. Catat kesalahan database ke log
            Log::error('Transaksi peminjaman gagal.', [
                'message' => $e->getMessage(),
                'buku_id' => $data['buku_id'],
                'nim_peminjam' => $data['nim_peminjam'],
            ]);

            return back()->withInput()->withErrors([
                'transaksi' => 'Peminjaman gagal disimpan. Silakan coba lagi.',
            ]);
        }
    }
    
    public function kembalikan(Peminjaman $peminjaman)
    {
        try {
            DB::transaction(function () use ($peminjaman) {
                // Ambil dan kunci data peminjaman
                $pinjaman = Peminjaman::whereKey($peminjaman->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Pastikan buku belum dikembalikan
                if ($pinjaman->status === 'dikembalikan') {
                    throw ValidationException::withMessages([
                        'transaksi' => 'Buku ini sudah dikembalikan.',
                    ]);
                }

                // Ambil dan kunci data buku
                $buku = Buku::whereKey($pinjaman->buku_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Catat pengembalian
                $pinjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali' => now()->toDateString(),
                ]);

                // Tambahkan stok buku satu buah
                $buku->increment('stok');
            });

            return back()->with(
                'success',
                'Buku berhasil dikembalikan.'
            );

        } catch (ValidationException $e) {
            throw $e;

        } catch (QueryException $e) {
            Log::error('Transaksi pengembalian gagal.', [
                'message' => $e->getMessage(),
                'peminjaman_id' => $peminjaman->id,
            ]);

           
            // Simpan informasi peminjam terakhir di session
            $request->session()->put('last_borrower', [
                'nim' => $data['nim_peminjam'],
                'nama' => $data['nama_peminjam'],
                'waktu' => now()->toDateTimeString(),
            ]);

            // Buat cookie dengan pengaturan keamanan
            Cookie::queue(cookie(
                'last_borrower',
                $data['nim_peminjam'],
                60,
                '/',
                null,
                false,
                true,
                false,
                'lax'
            ));

            return back()->with(
                'success',
                'Peminjaman buku berhasil dicatat.'
            );

        }
    }

}
