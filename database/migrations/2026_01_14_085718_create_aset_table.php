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
        Schema::create('aset', function (Blueprint $table) {
            $table->bigIncrements('id_aset');
            $table->string('kode_aset')->unique();
            $table->string('nama_aset');
            $table->string('kategori_aset');
            $table->enum('kondisi_aset', ['baik', 'rusak']);
            $table->enum('status_aset', ['tersedia', 'digunakan', 'rusak'])
                 ->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset');
    }
};
