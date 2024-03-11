<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'ms_pembayaran_peminjaman';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'id_peminjaman_dana',
        'tenor_ke',
        'tgl_tenor',
        'tgl_bayar',
        'keterangan'
    ];
}
