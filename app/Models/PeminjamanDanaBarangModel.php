<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDanaBarangModel extends Model
{
    use HasFactory;

    protected $table = 'ms_barang_peminjaman_dana';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'id_peminjaman',
        'nama_barang'
    ];
}
