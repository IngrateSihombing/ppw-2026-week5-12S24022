<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->string('kode_pinjam')->unique();

            $table->foreignId('buku_id')
                ->constrained('bukus')
                ->cascadeOnDelete();

            $table->string('nim_peminjam');
            $table->string('nama_peminjam');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan'])
                ->default('dipinjam');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['buku_id']);
            $table->dropUnique(['kode_pinjam']);

            $table->dropColumn([
                'kode_pinjam',
                'buku_id',
                'nim_peminjam',
                'nama_peminjam',
                'tanggal_pinjam',
                'tanggal_jatuh_tempo',
                'tanggal_kembali',
                'status',
            ]);
        });
    }
};