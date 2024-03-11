<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKaryawan extends Model
{
    use HasFactory;

    protected $table = 'ms_karyawan';
    protected $primaryKey = 'id_karyawan';
    public $incrementing = false;

    protected $fillable = [
        'id_karyawan',
        'nm_karyawan',
        'no_hp',
        'email',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'tgl_mulai_kerja',
        'tgl_resign',
        'pendidikan_terakhir',
        'no_kartu_keluarga',
        'no_bpjs',
        'no_npwp',
        'alamat',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'bank_address',
        'swift_code'
    ];
}
