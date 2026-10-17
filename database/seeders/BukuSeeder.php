
<?php
namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        if (!Buku::where('judul', 'Buku Uji Stok Habis')->exists()) {
            Buku::factory()->create([
                'judul' => 'Buku Uji Stok Habis',
                'stok' => 0,
            ]);
        }

        if (!Buku::where('judul', 'Buku Uji Stok Satu')->exists()) {
            Buku::factory()->create([
                'judul' => 'Buku Uji Stok Satu',
                'stok' => 1,
            ]);
        }
    }
}
"@
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText((Resolve-Path $file), $content, $utf8NoBom)