<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKategoriBarang extends Model
{
    use HasFactory;

    protected $table = 'master_kategori_barangs';
    // protected $primaryKey = 'id';
    // public $incrementing = false;

    protected $fillable = [
        'id',
        'nm_kategori_barang'
    ];
}
