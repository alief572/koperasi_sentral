<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAsset extends Model
{
    use HasFactory;

    protected $table = 'ms_peminjaman_asset';
    protected $primaryKey = 'id_peminjaman_asset';
    public $incrementing = false;

    protected $fillable = [
        'id_peminjaman_asset',
        'id_karyawan',
        'nm_karyawan',
        'tgl_awal_peminjaman',
        'tgl_pengembalian',
        'sts'
    ];
}
