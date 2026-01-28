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
        Schema::table('peminjaman', function (Blueprint $table) {

            if (!Schema::hasColumn('peminjaman', 'tanggal_kembali_real')) {
                $table->date('tanggal_kembali_real')
                    ->nullable()
                    ->after('tanggal_kembali');
            }

            if (!Schema::hasColumn('peminjaman', 'kondisi_pengembalian')) {
                $table->enum('kondisi_pengembalian', ['baik', 'rusak', 'hilang'])
                    ->nullable()
                    ->after('status');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            //
        });
    }
};
