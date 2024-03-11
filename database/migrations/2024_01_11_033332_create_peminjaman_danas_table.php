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
        Schema::create('ms_peminjaman_dana', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('id_karyawan');
            $table->string('nm_karyawan');
            $table->date('tgl_peminjaman');
            $table->integer('tenor');
            $table->decimal('nilai_peminjaman', $precision = 20, $scale = 2);
            $table->string('sts');
            $table->text('keterangan');
            $table->text('keterangan_app');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_peminjaman_dana');
    }
};
