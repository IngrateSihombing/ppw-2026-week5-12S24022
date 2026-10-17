<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalJudulBuku = DB::table('bukus')->count();

        $totalStokBuku = DB::table('bukus')->sum('stok');

        $sedangDipinjam = DB::table('peminjamans')
            ->where('status', 'dipinjam')
            ->count();

        $sudahDikembalikan = DB::table('peminjamans')
            ->where('status', 'dikembalikan')
            ->count();

        return view('dashboard', compact(
            'totalJudulBuku',
            'totalStokBuku',
            'sedangDipinjam',
            'sudahDikembalikan'
        ));
    }
}
