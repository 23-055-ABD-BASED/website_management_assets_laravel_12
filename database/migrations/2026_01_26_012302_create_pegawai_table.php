<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id('id_pegawai'); // primary key custom

            $table->string('nip_pegawai')->unique();
            $table->string('nama_pegawai');
            $table->string('bidang_kerja');
            $table->string('jabatan');
            $table->string('status_pegawai');

            $table->unsignedBigInteger('id_pengguna')->nullable();

            $table->timestamps();

            // foreign key ke users.id
            $table->foreign('id_pengguna')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
