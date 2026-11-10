<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuApiController extends Controller
{
    /**
     * Menampilkan daftar buku.
     */
    public function index(Request $request)
    {
        $query = Buku::query();

        // Pencarian berdasarkan judul, pengarang, atau ISBN
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        // Filter buku yang tersedia
if ($request->input('tersedia') == '1') {
    $query->where('stok', '>', 0);
}

        // Pengurutan berdasarkan judul
        $sort = $request->input('sort', 'judul');

        if ($sort === '-judul') {
            $query->orderBy('judul', 'desc');
        } else {
            $query->orderBy('judul', 'asc');
        }

        $bukus = $query->paginate(10);

        return BukuResource::collection($bukus);
    }
}