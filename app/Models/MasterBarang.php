<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    use HasFactory;

    protected $table = 'ms_barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;

    protected $fillable = [
        'id_barang',
        'nm_barang',
        'sts'
    ];

    public function kategori_barang(){
        return $this->hasOne(MasterKategoriBarang::class, 'id', 'id_kategori_barang');
    }
}
