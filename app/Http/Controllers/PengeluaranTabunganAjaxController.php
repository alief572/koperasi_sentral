<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranTabungan;
use App\Models\MasterKaryawan;
use App\Models\TabunganNilai;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PengeluaranTabunganAjaxController extends Controller
{
    public function get_pengeluaran_tabungan(Request $request)
    {
        $search_val = $request->input('search');
        // print_r($search_val);
        // exit;

        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
        $search = request()->input('search.value');

        if ($search_val !== "" && $search_val !== null) {
            $data = PengeluaranTabungan::where('tipe', '=', 'pengeluaran')
                ->whereAny([
                    'nm_karyawan',
                    'tgl',
                    'nilai',
                    'keterangan',
                    'IF(status = "1", Complete, IF(status = "2", Reject, Draft))'
                ], 'LIKE', '%' . $search_val . '%')
                ->skip($start)
                ->take($length);

            $all_data = PengeluaranTabungan::where('tipe', '=', 'pengeluaran')
                ->whereAny([
                    'nm_karyawan',
                    'tgl',
                    'nilai',
                    'keterangan',
                    'IF(status = "1", Complete, IF(status = "2", Reject, Draft))'
                ], 'LIKE', '%' . $search_val . '%')
                ->limit(50);
        } else {
            $data = PengeluaranTabungan::where('tipe', '=', 'pengeluaran')
                ->skip($start)
                ->take($length);
            $all_data =  PengeluaranTabungan::where('tipe', '=', 'pengeluaran')->limit(50);
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

            $edit = '<button type="button" class="btn btn-sm btn-success text-light edit_pengeluaran_tabungan edit_pengeluaran_tabungan_' . $list_data->id . '" data-id="' . $list_data->id . '"><i class="fa fa-pencil"></i></button>';
            $view = '<button type="button" class="btn btn-sm btn-info view view_' . $list_data->id . '" data-id="' . $list_data->id . '"><i class="fa fa-eye"></i></button>';
            $delete = '<button type="button" class="btn btn-sm btn-danger del_pengeluaran del_pengeluaran_' . $list_data->id . '" data-id="' . $list_data->id . '"><i class="fa fa-trash"></i></button>';
            $approval = '<button type="button" class="btn btn-sm bg-warning text-dark approval approval_' . $list_data->id . '" data-id="' . $list_data->id . '" data-id_karyawan="'.$list_data->id_karyawan.'"><i class="fa fa-check"></i></button>';
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

    public function add_pengeluaran_modal()
    {

        // $get_karyawan = MasterKaryawan::all();

        return view('dashboard.pengeluaran_tabungan.add');
    }

    public function get_karyawan_pengeluaran(Request $request)
    {
        // $getData = MasterKaryawan::where('nm_karyawan', 'LIKE', '%' . ($request->input('searchTerm')) . '%')->limit(50)->get();

        $getData = DB::select('SELECT a.* FROM ms_karyawan a WHERE (SELECT count(aa.id) FROM ms_tabungan aa WHERE aa.id_karyawan = a.id_karyawan AND aa.status = "0" AND aa.tipe = "pengeluaran") < 1 AND a.nm_karyawan LIKE "%' . $request->input('searchTerm') . '%" ORDER BY a.nm_karyawan ASC LIMIT 50');

        $hasil = [];

        foreach ($getData as $list_data) {
            $hasil[] = [
                'id' => $list_data->id_karyawan,
                'text' => $list_data->nm_karyawan
            ];
        }

        echo json_encode($hasil);
    }

    public function save_pengeluaran_tabungan(Request $request)
    {
        DB::beginTransaction();

        try {

            $id_pengeluaran = PengeluaranTabungan::where('id', 'LIKE', '%PGT-' . date('m-y') . '%')->max('id');
            $kodeBarang = $id_pengeluaran;
            $urutan = (int) substr($kodeBarang, 10, 5);
            $urutan++;
            $tahun = date('m-y');
            $huruf = "PGT-";
            $kodecollect = $huruf . $tahun . sprintf("%06s", $urutan);

            $get_karyawan = MasterKaryawan::find($request->input('karyawan'));

            $pengeluaran_tabungan = new PengeluaranTabungan();

            $pengeluaran_tabungan->id = $kodecollect;
            $pengeluaran_tabungan->id_karyawan = $request->input('karyawan');
            $pengeluaran_tabungan->nm_karyawan = $get_karyawan->nm_karyawan;
            $pengeluaran_tabungan->tipe = 'pengeluaran';
            $pengeluaran_tabungan->tgl = $request->input('tgl_pengeluaran');
            $pengeluaran_tabungan->nilai = str_replace(',', '', $request->input('nilai_pengeluaran'));
            $pengeluaran_tabungan->keterangan = $request->input('keterangan');
            $pengeluaran_tabungan->status = '0';

            $pengeluaran_tabungan->save();

            $valid = 1;
            $msg = 'Selamat, pengeluaran tabungan berhasil dibuat !';
            DB::commit();
        } catch (\Exception $e) {
            print_r($e->getMessage());
            exit;

            $valid = 0;
            $msg = 'Maaf, pengeluaran tabungan gagal dibuat, silahkan coba kembali !';

            DB::rollback();
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function del_pengeluaran_tabungan(Request $request)
    {
        DB::beginTransaction();

        try {
            PengeluaranTabungan::destroy($request->input('id'));

            DB::commit();

            $return_color = 'success';
            $title_return = 'Berhasil';
            $msg = 'Selamat, Pengeluaran tabungan berhasil dihapus !';
        } catch (\Throwable $th) {
            DB::rollback();

            $return_color = 'error';
            $title_return = 'Gagal';
            $msg = 'Selamat, Pengeluaran tabungan gagal dihapus !';
        }

        echo json_encode([
            'return_color' => $return_color,
            'title_return' => $title_return,
            'msg' => $msg
        ]);
    }

    public function view_pengeluaran_tabungan(Request $request)
    {
        $data_pengeluaran = PengeluaranTabungan::find($request->input('id'));

        return view('dashboard.pengeluaran_tabungan.view', [
            'pengeluaran' => $data_pengeluaran
        ]);
    }

    public function edit_pengeluaran_tabungan_modal(Request $request)
    {
        $data_pengeluaran = PengeluaranTabungan::find($request->input('id'));
        $data_karyawan = DB::select('SELECT a.id_karyawan, a.nm_karyawan FROM ms_karyawan a ORDER BY a.nm_karyawan ASC');

        return view('dashboard.pengeluaran_tabungan.add', [
            'get_pengeluaran' => $data_pengeluaran,
            'get_karyawan' => $data_karyawan
        ]);
    }

    public function edit_pengeluaran_tabungan(Request $request)
    {
        DB::beginTransaction();

        try {
            $get_karyawan = MasterKaryawan::find($request->input('karyawan'));
            $pengeluaran_tabungan = PengeluaranTabungan::find($request->input('id_pengeluaran'));

            $pengeluaran_tabungan->id_karyawan = $request->input('karyawan');
            $pengeluaran_tabungan->nm_karyawan = $get_karyawan->nm_karyawan;
            $pengeluaran_tabungan->tipe = 'pengeluaran';
            $pengeluaran_tabungan->tgl = $request->input('tgl_pengeluaran');
            $pengeluaran_tabungan->nilai = str_replace(',', '', $request->input('nilai_pengeluaran'));
            $pengeluaran_tabungan->keterangan = $request->input('keterangan');
            $pengeluaran_tabungan->status = '0';

            $pengeluaran_tabungan->save();
            DB::commit();

            return response()->json([
                'status' => 1,
                'msg' => 'Selamat, perubahan data pengeluaran berhasil disimpan !'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 0,
                'msg' => 'Maaf, perubahan data pengeluaran tabungan gagal disimpan !'
            ]);
        }
    }

    public function approval_pengeluaran_tabungan(Request $request)
    {
        DB::beginTransaction();

        try {
            $pengeluaran_tabungan = PengeluaranTabungan::find($request->input('id'));
            $pengeluaran_tabungan->status = '1';

            $pengeluaran_tabungan->save();

            $get_tabungan = PengeluaranTabungan::find($request->input('id'));

            $get_nilai_tabungan = TabunganNilai::where('id_karyawan', '=', $request->input('id_karyawan'))->get();
            // print_r($get_tabungan);
            // exit;
            // if(!empty($get_nilai_tabungan)){
            //     $tabungan_nilai = new TabunganNilai();

            //     $tabungan_nilai->id_karyawan = $get_tabungan->id_karyawan;
            //     $tabungan_nilai->nm_karyawan = $get_tabungan->nm_karyawan;
            //     $tabungan_nilai->nilai_tabungan = $get_tabungan->nilai;

            //     $tabungan_nilai->save();
            // }else{
            //     $tabungan_nilai = TabunganNilai::where('id_karyawan', '=', $get_tabungan->id_karyawan);

            //     $tabungan_nilai->nilai_tabungan = ($get_nilai_tabungan->nilai_tabungan - $get_tabungan->nilai);

            //     $tabungan_nilai->save();
            // }
            DB::commit();

            $return_color = 'success';
            $title_return = 'Berhasil';
            $msg = 'Selamat, Pengeluaran tabungan berhasil di approve !';
        } catch (\Throwable $th) {
            DB::rollback();

            $return_color = 'error';
            $title_return = 'Gagal';
            $msg = 'Selamat, Pengeluaran tabungan gagal di approve !';
        }

        return response()->json([
            'return_color' => $return_color,
            'title_return' => $title_return,
            'msg' => $msg
        ]);
    }

    public function get_tabungan_pengeluaran(Request $request){
        $id_karyawan = $request->input('id_karyawan');

        $get_tabungan = DB::select('SELECT IF(SUM(a.nilai) IS NOT NULL, SUM(a.nilai), 0) as nilai_pemasukan, 0 AS nilai_pengeluaran FROM ms_tabungan a WHERE a.id_karyawan = "'.$id_karyawan.'" AND a.tipe = "pemasukan" AND a.status = "1" UNION ALL SELECT 0 AS nilai_pemasukan, IF(SUM(b.nilai) IS NOT NULL, SUM(b.nilai), 0) as nilai_pengeluaran FROM ms_tabungan b WHERE b.id_karyawan = "'.$id_karyawan.'" AND b.tipe = "pengeluaran" AND b.status = "1"');

        // print_r($get_tabungan);
        // exit;

        $hasil = 0;
        foreach($get_tabungan as $tabungan) :
            $hasil += ($tabungan->nilai_pemasukan - $tabungan->nilai_pengeluaran);
        endforeach;

        $hasil = number_format($hasil, 2);

        echo $hasil;
    }
}
