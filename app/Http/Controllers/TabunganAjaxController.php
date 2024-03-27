<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class TabunganAjaxController extends Controller
{
    public function view_tabungan_karyawan(Request $request){
        $id_karyawan = $request->input('id_karyawan');

        $get_ttl_tabungan_karyawan = DB::table('ms_tabungan as a')
        ->select(
            'a.nm_karyawan',
            'a.id_karyawan',
            DB::raw('(SELECT SUM(b.nilai) FROM ms_tabungan b WHERE b.id_karyawan = a.id_karyawan AND b.tipe = "pemasukan" AND b.status = "1") as nilai_pemasukan'),
            DB::raw('(SELECT SUM(c.nilai) FROM ms_tabungan c WHERE c.id_karyawan = a.id_karyawan AND c.tipe = "pengeluaran" AND c.status = "1") as nilai_pengeluaran')
        )
        ->where('a.id_karyawan', '=', $id_karyawan)
        ->groupBy('a.id_karyawan')
        ->get();

        return view('dashboard.tabungan_karyawan.view', [
            'data_tabungan' => $get_ttl_tabungan_karyawan,
            'ttl_tabungan' => ($get_ttl_tabungan_karyawan[0]->nilai_pemasukan - $get_ttl_tabungan_karyawan[0]->nilai_pengeluaran)
        ]);
    }

    public function search_tabungan_karyawan(Request $request){
        $id_karyawan = $request->input('id_karyawan');
        $periode_awal = $request->input('periode_awal');
        $periode_akhir = $request->input('periode_akhir');

        $get_tabungan = Tabungan::where('id_karyawan', '=', $id_karyawan)
        ->where('status', '=', '1')
        ->whereBetween('tgl', [$periode_awal, $periode_akhir])
        ->orderBy('tgl', 'desc')
        ->get();

        $hasil = '';

        $no = 1;
        foreach($get_tabungan as $tabungan) :
            $nilai_tabungan = $tabungan->nilai;
            if($tabungan->tipe == 'pengeluaran'){
                $nilai_tabungan = ($tabungan->nilai * -1);
            }
            $hasil = $hasil . '
                <tr>
                    <td>'.$no.'</td>
                    <td>'.$tabungan->nm_karyawan.'</td>
                    <td>'.ucfirst($tabungan->tipe).'</td>
                    <td>'.date('d F Y', strtotime($tabungan->tgl)).'</td>
                    <td class="text-center">Rp. '.number_format($nilai_tabungan, 2).'</td>
                </tr>
            ';

            $no++;
        endforeach;

        echo json_encode([
            'list_tabungan' => $hasil
        ]);
    }
}
