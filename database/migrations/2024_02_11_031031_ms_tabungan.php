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
        Schema::create('ms_tabungan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('id_karyawan');
            $table->string('nm_karyawan');
            $table->string('tipe');
            $table->date('tgl');
            $table->date('nilai');
            $table->text('keterangan');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_tabungan');
    }
};
