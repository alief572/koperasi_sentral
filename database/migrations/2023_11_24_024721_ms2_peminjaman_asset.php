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
        Schema::create('ms2_peminjaman_asset', function (Blueprint $table) {
            $table->string('id_peminjaman_asset2')->primary();
            $table->string('id_peminjaman_asset');
            $table->string('id_asset');
            $table->string('nm_asset');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms2_peminjaman_asset');
    }
};
