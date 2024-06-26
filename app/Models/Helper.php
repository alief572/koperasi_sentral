<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    protected $table = 'ms_barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;

    protected $fillable = [
        'id_barang',
        'nm_barang',
        'sts'
    ];
}
