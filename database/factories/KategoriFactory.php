
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode_kategori' => 'KAT' . fake()->unique()->numerify('###'),
            'nama_kategori' => fake()->unique()->randomElement([
                'Teknologi',
                'Pemrograman',
                'Basis Data',
                'Bisnis',
                'Sastra',
                'Jaringan Komputer',
                'Kecerdasan Buatan',
                'Sistem Informasi',
            ]),
        ];
    }
}
