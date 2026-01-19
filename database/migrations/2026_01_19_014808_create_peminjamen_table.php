<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id(); // Primary key tabel ini
        
        // Relasi ke tabel Pegawai
        $table->unsignedBigInteger('id_pegawai');
        $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawai')->onDelete('cascade');

        // Relasi ke tabel Aset
        $table->unsignedBigInteger('id_aset');
        $table->foreign('id_aset')->references('id_aset')->on('aset')->onDelete('cascade');

        $table->date('tanggal_pinjam');
        $table->date('tanggal_kembali');
        $table->text('alasan'); // Alasan peminjaman
        
        // Status pengajuan: pending (menunggu), disetujui, ditolak, kembali
        $table->enum('status', ['pending', 'disetujui', 'ditolak', 'kembali'])->default('pending');
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
