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
        Schema::create('ms_peminjaman_asset', function (Blueprint $table) {
            $table->string('id_peminjaman_asset')->primary();
            $table->string('id_karyawan');
            $table->string('nm_karyawan');
            $table->date('tgl_awal_peminjaman');
            $table->date('tgl_pengembalian');
            $table->text('keterangan');
            $table->string('sts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_peminjaman_asset');
    }
};
