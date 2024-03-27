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
        Schema::create('ms_nilai_tabungan', function (Blueprint $table) {
            $table->id();
            $table->string('id_karyawan');
            $table->string('nm_karyawan');
            $table->decimal('nilai_tabungan', $precision = 20, $scale = 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_nilai_tabungan');
    }
};
