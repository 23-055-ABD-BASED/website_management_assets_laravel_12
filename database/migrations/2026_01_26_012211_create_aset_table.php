<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->id('id_aset'); // primary key custom
            $table->string('kode_aset')->unique();
            $table->string('nama_aset');
            $table->string('kategori_aset');
            $table->string('kondisi_aset');
            $table->string('status_aset');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset');
    }
};
