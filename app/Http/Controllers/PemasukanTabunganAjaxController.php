<?php

namespace App\Http\Controllers;

use App\Models\PemasukanTabungan;
use App\Models\MasterKaryawan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PemasukanTabunganAjaxController extends Controller
{
    public function get_pemasukan_tabungan(Request $request)
    {
        $search_val = $request->input('search');
        // print_r($search_val);
        // exit;

        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
        $search = request()->input('search.value');

        if ($search_val !== "" && $search_val !== null) {
            $data = PemasukanTabungan::where('nm_karyawan', 'LIKE', '%' . $search_val . '%')
                ->orWhere('tgl', 'LIKE', '%' . $search_val . '%')
                ->orWhere('nilai', 'LIKE', '%' . $search_val . '%')
                ->orWhere('keterangan', 'LIKE', '%' . $search_val . '%')
                ->orWhere('IF(status = "1", Complete, IF(status = "2", Reject, Draft))', 'LIKE', '%' . $search_val . '%')
                ->skip($start)
                ->take($length);

            $all_data = PemasukanTabungan::where('nm_karyawan', 'LIKE', '%' . $search_val . '%')
                ->orWhere('tgl', 'LIKE', '%' . $search_val . '%')
                ->orWhere('nilai', 'LIKE', '%' . $search_val . '%')
                ->orWhere('keterangan', 'LIKE', '%' . $search_val . '%')
                ->orWhere('IF(status = "1", Complete, IF(status = "2", Reject, Draft))', 'LIKE', '%' . $search_val . '%')
                ->limit(50);
        } else {
            $data = PemasukanTabungan::skip($start)
                ->take($length);
            $all_data =  PemasukanTabungan::limit(50);
        }

        $get_data = $data->get();
        $total = $all_data->count();



        $hasil = [];
        $no = 1;
        foreach ($get_data as $list_data) {

            $status = '<div class="badge badge-warning text-light">Draft</div>';
            if ($list_data->status == '1') {
                $status = '<div class="badge badge-success">Approved</div>';
            }
            if ($list_data->status == '2') {
                $status = '<div class="badge badge-success">Rejected</div>';
            }

            $edit = '<button type="button" class="btn btn-sm btn-warning text-light"><i class="fa fa-pencil"></i></button>';
            $view = '<button type="button" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></button>';
            $delete = '<button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>';

            $buttons = $edit . '' . $delete . '' . $view;

            $hasil[] = [
                'no' => $no,
                'nm_karyawan' => $list_data->nm_karyawan,
                'tgl' => $list_data->tgl,
                'nilai' => number_format($$list_data->nilai),
                'keterangan' => $list_data->keterangan,
                'status' => $status,
                'buttons' => $buttons
            ];
            $no++;
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $hasil
        ]);
    }

    public function add_pemasukan_modal()
    {

        // $get_karyawan = MasterKaryawan::all();

        return view('dashboard.pemasukan_tabungan.add');
    }

    public function get_karyawan_pemasukan(Request $request)
    {
        $getData = MasterKaryawan::where('nm_karyawan', 'LIKE', '%' . ($request->input('searchTerm')) . '%')->limit(50)->get();

        $hasil = [];

        foreach ($getData as $list_data) {
            $hasil[] = [
                'id' => $list_data->id_karyawan,
                'text' => $list_data->nm_karyawan
            ];
        }

        echo json_encode($hasil);
    }
}
