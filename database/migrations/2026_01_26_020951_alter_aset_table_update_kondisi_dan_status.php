<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aset', function (Blueprint $table) {
            // pastikan kolom ada sebelum diubah
        });

        // ubah kondisi_aset jadi ENUM('baik','rusak')
        DB::statement("
            ALTER TABLE aset 
            MODIFY kondisi_aset 
            ENUM('baik','rusak') 
            NOT NULL
        ");

        // ubah status_aset jadi ENUM dengan default 'tersedia'
        DB::statement("
            ALTER TABLE aset 
            MODIFY status_aset 
            ENUM('tersedia','digunakan','rusak') 
            NOT NULL 
            DEFAULT 'tersedia'
        ");
    }

    public function down(): void
    {
        // rollback ke tipe string (aman & fleksibel)
        Schema::table('aset', function (Blueprint $table) {
            $table->string('kondisi_aset')->change();
            $table->string('status_aset')->change();
        });
    }
};
