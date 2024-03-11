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
        Schema::create('ms_pembayaran_peminjaman', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('id_peminjaman_dana');
            $table->integer('tenor_ke');
            $table->date('tgl_tenor');
            $table->date('tgl_bayar');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_pembayaran_peminjaman');
    }
};
