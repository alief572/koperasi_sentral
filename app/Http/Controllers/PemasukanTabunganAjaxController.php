<?php

namespace App\Http\Controllers;

use App\Models\PemasukanTabungan;
use App\Models\MasterKaryawan;
use App\Models\TabunganNilai;

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
            $data = PemasukanTabungan::where('tipe', '=', 'pemasukan')
                ->whereAny([
                    'nm_karyawan',
                    'tgl',
                    'nilai',
                    'keterangan',
                    'IF(status = "1", Complete, IF(status = "2", Reject, Draft))'
                ], 'LIKE', '%' . $search_val . '%')
                ->skip($start)
                ->take($length);

            $all_data = PemasukanTabungan::where('tipe', '=', 'pemasukan')
                ->whereAny([
                    'nm_karyawan',
                    'tgl',
                    'nilai',
                    'keterangan',
                    'IF(status = "1", Complete, IF(status = "2", Reject, Draft))'
                ], 'LIKE', '%' . $search_val . '%')
                ->limit(50);
        } else {
            $data = PemasukanTabungan::where('tipe', '=', 'pemasukan')
                ->skip($start)
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

            $edit = '<button type="button" class="btn btn-sm btn-success text-light edit_pemasukan_tabungan edit_pemasukan_tabungan_' . $list_data->id . '" data-id="' . $list_data->id . '"><i class="fa fa-pencil"></i></button>';
            $view = '<button type="button" class="btn btn-sm btn-info view view_' . $list_data->id . '" data-id="' . $list_data->id . '"><i class="fa fa-eye"></i></button>';
            $delete = '<button type="button" class="btn btn-sm btn-danger del_pemasukan del_pemasukan_' . $list_data->id . '" data-id="' . $list_data->id . '"><i class="fa fa-trash"></i></button>';
            $approval = '<button type="button" class="btn btn-sm bg-warning text-dark approval approval_' . $list_data->id . '" data-id="' . $list_data->id . '"><i class="fa fa-check"></i></button>';
            if ($list_data->status == '1') {
                $edit = '';
                $delete = '';
                $approval = '';
            }

            $buttons = $edit . ' ' . $delete . ' ' . $view . ' ' . $approval;

            $hasil[] = [
                'no' => $no,
                'nm_karyawan' => $list_data->nm_karyawan,
                'tgl' => date('d F Y', strtotime($list_data->tgl)),
                'nilai' => number_format($list_data->nilai),
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
        // $getData = MasterKaryawan::where('nm_karyawan', 'LIKE', '%' . ($request->input('searchTerm')) . '%')->limit(50)->get();

        $getData = DB::select('SELECT a.* FROM ms_karyawan a WHERE (SELECT count(aa.id) FROM ms_tabungan aa WHERE aa.id_karyawan = a.id_karyawan AND aa.status = "0" AND aa.tipe = "pemasukan") < 1 AND a.nm_karyawan LIKE "%' . $request->input('searchTerm') . '%" ORDER BY a.nm_karyawan ASC LIMIT 50');

        $hasil = [];

        foreach ($getData as $list_data) {
            $hasil[] = [
                'id' => $list_data->id_karyawan,
                'text' => $list_data->nm_karyawan
            ];
        }

        echo json_encode($hasil);
    }

    public function save_pemasukan_tabungan(Request $request)
    {
        DB::beginTransaction();

        try {

            $id_pemasukan = PemasukanTabungan::where('id', 'LIKE', '%PMT-' . date('m-y') . '%')->max('id');
            $kodeBarang = $id_pemasukan;
            $urutan = (int) substr($kodeBarang, 10, 5);
            $urutan++;
            $tahun = date('m-y');
            $huruf = "PMT-";
            $kodecollect = $huruf . $tahun . sprintf("%06s", $urutan);

            $get_karyawan = MasterKaryawan::find($request->input('karyawan'));

            $pemasukan_tabungan = new PemasukanTabungan();

            $pemasukan_tabungan->id = $kodecollect;
            $pemasukan_tabungan->id_karyawan = $request->input('karyawan');
            $pemasukan_tabungan->nm_karyawan = $get_karyawan->nm_karyawan;
            $pemasukan_tabungan->tipe = 'pemasukan';
            $pemasukan_tabungan->tgl = $request->input('tgl_pemasukan');
            $pemasukan_tabungan->nilai = str_replace(',', '', $request->input('nilai_pemasukan'));
            $pemasukan_tabungan->keterangan = $request->input('keterangan');
            $pemasukan_tabungan->status = '0';

            $pemasukan_tabungan->save();

            $valid = 1;
            $msg = 'Selamat, pemasukan tabungan berhasil dibuat !';
            DB::commit();
        } catch (\Exception $e) {
            $valid = 0;
            $msg = 'Maaf, pemasukan tabungan gagal dibuat, silahkan coba kembali !';

            DB::rollback();
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function del_pemasukan_tabungan(Request $request)
    {
        DB::beginTransaction();

        try {
            PemasukanTabungan::destroy($request->input('id'));

            DB::commit();

            $return_color = 'success';
            $title_return = 'Berhasil';
            $msg = 'Selamat, Pemasukan tabungan berhasil dihapus !';
        } catch (\Throwable $th) {
            DB::rollback();

            $return_color = 'error';
            $title_return = 'Gagal';
            $msg = 'Selamat, Pemasukan tabungan gagal dihapus !';
        }

        echo json_encode([
            'return_color' => $return_color,
            'title_return' => $title_return,
            'msg' => $msg
        ]);
    }

    public function view_pemasukan_tabungan(Request $request)
    {
        $data_pemasukan = PemasukanTabungan::find($request->input('id'));

        return view('dashboard.pemasukan_tabungan.view', [
            'pemasukan' => $data_pemasukan
        ]);
    }

    public function edit_pemasukan_tabungan_modal(Request $request)
    {
        $data_pemasukan = PemasukanTabungan::find($request->input('id'));
        $data_karyawan = DB::select('SELECT a.id_karyawan, a.nm_karyawan FROM ms_karyawan a ORDER BY a.nm_karyawan ASC');

        return view('dashboard.pemasukan_tabungan.add', [
            'get_pemasukan' => $data_pemasukan,
            'get_karyawan' => $data_karyawan
        ]);
    }

    public function edit_pemasukan_tabungan(Request $request)
    {
        DB::beginTransaction();

        try {
            $get_karyawan = MasterKaryawan::find($request->input('karyawan'));
            $pemasukan_tabungan = PemasukanTabungan::find($request->input('id_pemasukan'));

            $pemasukan_tabungan->id_karyawan = $request->input('karyawan');
            $pemasukan_tabungan->nm_karyawan = $get_karyawan->nm_karyawan;
            $pemasukan_tabungan->tipe = 'pemasukan';
            $pemasukan_tabungan->tgl = $request->input('tgl_pemasukan');
            $pemasukan_tabungan->nilai = str_replace(',', '', $request->input('nilai_pemasukan'));
            $pemasukan_tabungan->keterangan = $request->input('keterangan');
            $pemasukan_tabungan->status = '0';

            $pemasukan_tabungan->save();
            DB::commit();

            return response()->json([
                'status' => 1,
                'msg' => 'Selamat, perubahan data pemasukan berhasil disimpan !'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 0,
                'msg' => 'Maaf, perubahan data pemasukan tabungan gagal disimpan !'
            ]);
        }
    }

    public function approval_pemasukan_tabungan(Request $request)
    {
        DB::beginTransaction();

        try {
            $pemasukan_tabungan = PemasukanTabungan::find($request->input('id'));
            $pemasukan_tabungan->status = '1';

            $pemasukan_tabungan->save();

            $get_tabungan = PemasukanTabungan::find($request->input('id'));
            
            $get_nilai_tabungan = TabunganNilai::where('id_karyawan', '=', $get_tabungan->id_karyawan);
            if(!empty($get_nilai_tabungan)){
                $tabungan_nilai = new TabunganNilai();

                $tabungan_nilai->id_karyawan = $get_tabungan->id_karyawan;
                $tabungan_nilai->nm_karyawan = $get_tabungan->nm_karyawan;
                $tabungan_nilai->nilai_tabungan = $get_tabungan->nilai;

                $tabungan_nilai->save();
            }else{
                $tabungan_nilai = TabunganNilai::where('id_karyawan', '=', $get_tabungan->id_karyawan);

                $tabungan_nilai->nilai_tabungan = ($get_nilai_tabungan->nilai_tabungan + $get_tabungan->nilai);

                $tabungan_nilai->save();
            }
            
            DB::commit();

            $return_color = 'success';
            $title_return = 'Berhasil';
            $msg = 'Selamat, Pemasukan tabungan berhasil approve !';
        } catch (\Throwable $th) {
            DB::rollback();

            $return_color = 'error';
            $title_return = 'Gagal';
            $msg = 'Selamat, Pemasukan tabungan gagal approve !';
        }

        return response()->json([
            'return_color' => $return_color,
            'title_return' => $title_return,
            'msg' => $msg
        ]);
    }
}
