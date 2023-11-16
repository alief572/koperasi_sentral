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
        Schema::create('ms_karyawan', function (Blueprint $table) {
            $table->string('id_karyawan')->primary();
            $table->string('nm_karyawan');
            $table->string('no_hp');
            $table->string('email');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender',['pria','wanita']);
            $table->string('religion');
            $table->date('tgl_mulai_kerja');
            $table->date('tgl_resign');
            $table->string('pendidikan_terakhir');
            $table->string('no_kartu_keluarga');
            $table->string('no_bpjs');
            $table->string('no_npwp');
            $table->text('alamat');
            $table->string('bank_name');
            $table->string('bank_account_number');
            $table->string('bank_account_name');
            $table->text('bank_address');
            $table->string('swift_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_karyawan');
    }
};
