<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $bukus = Buku::with('kategori')->paginate(10);

    return view('bukus.index', compact('bukus'));
}

    /**
     * Show the form for creating a new resource.
     */
    
public function create()
{
    $kategoris = \App\Models\Kategori::all();

    return view('bukus.create', compact('kategoris'));
}

    /**
     * Store a newly created resource in storage.
     */
    
public function store(\Illuminate\Http\Request $request)
{
    $validated = $request->validate([
        'isbn' => 'required|string|unique:bukus,isbn',
        'judul' => 'required|string|min:5',
        'penulis' => 'required|string',
        'penerbit' => 'required|string',
        'tahun_terbit' => 'required|integer|min:1901|max:2155',
        'kategori_id' => 'required|exists:kategoris,id',
        'stok' => 'required|integer|min:0',
        'sinopsis' => 'nullable|string',
    ]);

    \App\Models\Buku::create($validated);

    return redirect()
        ->route('bukus.index')
        ->with('success', 'Buku berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    
public function edit(\App\Models\Buku $buku)
{
    $kategoris = \App\Models\Kategori::all();

    return view('bukus.edit', compact('buku', 'kategoris'));
}

    /**
     * Update the specified resource in storage.
     */
    
public function update(\Illuminate\Http\Request $request, \App\Models\Buku $buku)
{
    $validated = $request->validate([
        'isbn' => 'required|string|unique:bukus,isbn,' . $buku->id,
        'judul' => 'required|string|min:5',
        'penulis' => 'required|string',
        'penerbit' => 'required|string',
        'tahun_terbit' => 'required|integer|min:1901|max:2155',
        'kategori_id' => 'required|exists:kategoris,id',
        'stok' => 'required|integer|min:0',
        'sinopsis' => 'nullable|string',
    ]);

    $buku->update($validated);

    return redirect()
        ->route('bukus.index')
        ->with('success', 'Data buku berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    
public function destroy(\App\Models\Buku $buku)
{
    $buku->delete();

    return redirect()
        ->route('bukus.index')
        ->with('success', 'Buku berhasil dihapus.');
}
}
