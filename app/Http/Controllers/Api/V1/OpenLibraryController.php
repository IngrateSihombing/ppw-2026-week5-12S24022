<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class OpenLibraryController extends Controller
{
    /**
     * Mencari metadata buku melalui OpenLibrary API.
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $response = Http::timeout(15)
            ->get('https://openlibrary.org/search.json', [
                'q' => $request->q,
                'limit' => 10,
            ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Gagal mengambil data dari OpenLibrary.',
            ], 502);
        }

        $books = collect($response->json('docs', []))
            ->map(function ($book) {
                return [
                    'judul' => $book['title'] ?? null,
                    'pengarang' => $book['author_name'][0] ?? null,
                    'tahun_terbit' => $book['first_publish_year'] ?? null,
                    'isbn' => $book['isbn'][0] ?? null,
                    'openlibrary_key' => $book['key'] ?? null,
                ];
            });

        return response()->json([
            'message' => 'Pencarian OpenLibrary berhasil.',
            'total' => $response->json('numFound', 0),
            'data' => $books,
        ]);
    }
}
