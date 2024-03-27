<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tabungan extends Model
{
    use HasFactory;

    protected $table = 'ms_tabungan';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'id_karyawan',
        'nm_karyawan',
        'tipe',
        'tgl',
        'nilai',
        'status',
        'keterangan'
    ];
}
