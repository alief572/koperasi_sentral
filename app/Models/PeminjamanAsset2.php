<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAsset2 extends Model
{
    use HasFactory;

    protected $table = 'ms2_peminjaman_asset';
    protected $primaryKey = 'id_peminjaman_asset2';
    public $incrementing = false;

    protected $fillable = [
        'id_peminjaman_asset2',
        'id_peminjaman_asset',
        'id_asset',
        'nm_asset'
    ];

    public function barang(){
        return $this->hasOne(MasterBarang::class,'id_barang','id_asset');
    }
}
