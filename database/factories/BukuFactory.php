<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    public function definition(): array
    {
        $buku = [
            [
                'judul' => 'Dasar-Dasar Pemrograman Web',
                'penulis' => 'Andi Pratama',
                'penerbit' => 'Informatika',
                'sinopsis' => 'Buku ini membahas dasar pemrograman web, mulai dari HTML, CSS, hingga pengenalan JavaScript untuk membangun halaman web.',
            ],
            [
                'judul' => 'Pengantar Basis Data',
                'penulis' => 'Budi Santoso',
                'penerbit' => 'Andi Publisher',
                'sinopsis' => 'Buku ini menjelaskan konsep basis data, perancangan tabel, relasi antartabel, serta penggunaan SQL untuk mengelola data.',
            ],
            [
                'judul' => 'Kecerdasan Buatan untuk Pemula',
                'penulis' => 'Rina Lestari',
                'penerbit' => 'Elex Media Komputindo',
                'sinopsis' => 'Buku ini memperkenalkan konsep kecerdasan buatan, algoritma pencarian, dan penerapannya dalam menyelesaikan berbagai masalah.',
            ],
            [
                'judul' => 'Jaringan Komputer dan Komunikasi Data',
                'penulis' => 'Dedi Kurniawan',
                'penerbit' => 'Informatika',
                'sinopsis' => 'Buku ini membahas dasar jaringan komputer, protokol komunikasi, arsitektur jaringan, dan keamanan komunikasi data.',
            ],
            [
                'judul' => 'Analisis dan Perancangan Sistem Informasi',
                'penulis' => 'Siti Rahmawati',
                'penerbit' => 'Andi Publisher',
                'sinopsis' => 'Buku ini membahas tahapan analisis kebutuhan, pemodelan proses bisnis, dan perancangan sistem informasi untuk organisasi.',
            ],
        ];

        $data = fake()->randomElement($buku);

        return [
            'isbn' => fake()->unique()->numerify('978-###-###-###-#'),
            'judul' => $data['judul'] . ' ' . fake()->unique()->numberBetween(1, 999),
            'penulis' => $data['penulis'],
            'penerbit' => $data['penerbit'],
            'tahun_terbit' => fake()->numberBetween(2015, 2026),
            'kategori_id' => Kategori::query()->inRandomOrder()->value('id')
                ?? Kategori::factory()->create()->id,
            'stok' => fake()->numberBetween(0, 50),
            'sinopsis' => $data['sinopsis'],
        ];
    }
}