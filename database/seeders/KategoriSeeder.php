<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'kode_kategori' => 'KAT001',
                'nama_kategori' => 'Pemrograman',
            ],
            [
                'kode_kategori' => 'KAT002',
                'nama_kategori' => 'Basis Data',
            ],
            [
                'kode_kategori' => 'KAT003',
                'nama_kategori' => 'Jaringan Komputer',
            ],
            [
                'kode_kategori' => 'KAT004',
                'nama_kategori' => 'Kecerdasan Buatan',
            ],
            [
                'kode_kategori' => 'KAT005',
                'nama_kategori' => 'Sistem Informasi',
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(
                ['kode_kategori' => $kategori['kode_kategori']],
                ['nama_kategori' => $kategori['nama_kategori']]
            );
        }
    }
}