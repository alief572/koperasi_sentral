<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabunganNilai extends Model
{
    use HasFactory;

    protected $table = 'ms_nilai_tabungan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_karyawan',
        'nm_karyawan',
        'nilai_tabungan'
    ];
}
