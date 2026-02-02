<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            // RELASI
            $table->unsignedBigInteger('id_pegawai');
            $table->unsignedBigInteger('id_aset');

            // DATA PEMINJAMAN
            $table->date('tanggal_pinjam')->nullable();
            $table->date('tanggal_kembali')->nullable();

            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'kembali'
            ])->default('menunggu');

            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('id_pegawai')
                ->references('id_pegawai')
                ->on('pegawai')
                ->cascadeOnDelete();

            $table->foreign('id_aset')
                ->references('id_aset')
                ->on('aset')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
