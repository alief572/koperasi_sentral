<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDana extends Model
{

    use HasFactory;

    protected $table = 'ms_peminjaman_dana';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'id_karyawan',
        'nm_karyawan',
        'tgl_peminjaman',
        'tenor',
        'nilai_peminjaman',
        'keterangan',
        'keterangan_app',
        'sts',
        'tipe_pinjaman'
    ];
}
