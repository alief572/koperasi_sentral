<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use App\Models\PeminjamanDana;
use App\Models\PeminjamanDanaBarangModel;
use App\Models\MasterKaryawan;
use App\Models\PembayaranPeminjaman;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;


class PeminjamanDanaAjaxController extends Controller
{
    public function get_peminjaman_dana(Request $request)
    {
        $search_val = $request->input('search');
        // print_r($search_val);
        // exit;

        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
        $search = request()->input('search.value');

        if ($search_val !== "" && $search_val !== null) {
            $data = PeminjamanDana::where('nm_karyawan', 'LIKE', '%' . $search_val . '%')
                ->orWhere('nilai_peminjaman', 'LIKE', '%' . $search_val . '%')
                ->orWhere('tenor', 'LIKE', '%' . $search_val . '%')
                ->orWhere('tgl_peminjaman', 'LIKE', '%' . $search_val . '%')
                ->skip($start)
                ->take($length);

            $all_data = PeminjamanDana::where('nm_karyawan', 'LIKE', '%' . $search_val . '%')
                ->orWhere('nilai_peminjaman', 'LIKE', '%' . $search_val . '%')
                ->orWhere('tenor', 'LIKE', '%' . $search_val . '%')
                ->orWhere('tgl_peminjaman', 'LIKE', '%' . $search_val . '%')
                ->limit(50);
        } else {
            $data = PeminjamanDana::skip($start)
                ->take($length);
            $all_data =  PeminjamanDana::limit(50);
        }

        $get_data = $data->get();
        $total = $all_data->count();



        $hasil = [];
        $no = 1;
        foreach ($get_data as $list_data) {
            $sts = '<div class="badge badge-primary text-light">Draft</div>';
            if ($list_data->sts == 'req_approval') {
                $sts = '<div class="badge badge-warning text-light">Request Approval</div>';
            }
            if ($list_data->sts == 'approved') {
                $sts = '<div class="badge badge-success">Approved</div>';
            }
            if ($list_data->sts == 'reject') {
                $sts = '<div class="badge badge-danger">Rejected</div>';
            }
            if ($list_data->sts == 'complete') {
                $sts = '<div class="badge badge-success">Complete</div>';
            }

            $delete_btn = '
                <button type="button" class="btn btn-sm btn-danger del_peminjaman_dana" data-id="' . $list_data->id . '" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
            ';
            if ($list_data->sts !== 'draft') {
                $delete_btn = '';
            }

            $edit_btn = '<button type="button" class="btn btn-sm btn-success edit_peminjaman edit_peminjaman_' . $list_data->id . '" data-id="' . $list_data->id . '" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>';
            if ($list_data->sts !== 'draft') {
                $edit_btn = '';
            }

            $request_app_btn = '<button type="button" class="btn btn-sm btn-warning text-light req_approval" data-id="' . $list_data->id . '" data-toggle="tooltip" title="Request Approval"><i class="fa fa-check"></i></button>';
            if ($list_data->sts !== 'draft') {
                $request_app_btn = '';
            }

            $approve_btn = '<button type="button" class="btn btn-sm btn-success approval_peminjaman_dana" data-id="' . $list_data->id . '" data-toggle="tooltip" title="Approval Peminjaman"><i class="fa fa-check"></i></button>';
            if ($list_data->sts !== 'req_approval') {
                $approve_btn = '';
            }

            $reject_btn = '<button type="button" class="btn btn-sm btn-danger reject_peminjaman" data-id="' . $list_data->id . '" data-toggle="tooltip" title="Reject"><i class="fa fa-close"></i></button>';
            if ($list_data->sts !== 'req_approval') {
                $reject_btn = '';
            }

            $view = '<button type="button" class="btn btn-sm btn-info view_peminjaman view_peminjaman_' . $list_data->id . '" data-id="' . $list_data->id . '" data-toggle="tooltip" title="View Peminjaman"><i class="fa fa-eye"></i></button>';

            $payment_btn = '<button type="button" class="btn btn-sm btn-success pembayaran_pinjaman pembayaran_jaminan_' . $list_data->id . '" data-id="' . $list_data->id . '" data-toggle="tooltip" title="Bayar Pinjaman"><i class="fa fa-money"></i></button>';

            $get_jum_pembayaran = DB::table('ms_pembayaran_peminjaman')->select(DB::raw('count(id) AS jum_pembayaran'))
                ->where('id_peminjaman_dana', '=', $list_data->id)
                ->groupBy('id_peminjaman_dana', 'tenor_ke')
                ->get();


            if ($list_data->sts !== 'approved' || count($get_jum_pembayaran) >= $list_data->tenor) {
                $payment_btn = '';
            }

            $complete_btn = '<button type="button" class="btn btn-sm btn-success complete_peminjaman" data-id="' . $list_data->id . '" data-toggle="tooltip" title="Tutup Peminjaman"><i class="fa fa-check"></i></button>';
            if (count($get_jum_pembayaran) < $list_data->tenor) {
                $complete_btn = '';
            }

            if ($list_data->sts == 'complete') {
                $edit_btn = '';
                $delete_btn = '';
                $request_app_btn = '';
                $approve_btn = '';
                $reject_btn = '';
                $payment_btn = '';
                $complete_btn = '';
            }


            $hasil[] = [
                'no' => $no,
                'nm_karyawan' => $list_data->nm_karyawan,
                'nilai_peminjaman' => 'Rp. ' . number_format($list_data->nilai_peminjaman, 2),
                'tenor' => $list_data->tenor . ' Bulan',
                'tgl_peminjaman' => date('d F Y', strtotime($list_data->tgl_peminjaman)),
                'status' => $sts,
                'pembayaran' => count($get_jum_pembayaran) . ' / ' . $list_data->tenor,
                'buttons' => '
                ' . $edit_btn . '
                ' . $delete_btn . '
                ' . $view . '
               ' . $request_app_btn . '
                ' . $approve_btn . '
                ' . $reject_btn . '
                ' . $payment_btn . '
                ' . $complete_btn . '
            '
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

    public function add_peminjaman_dana(Request $request)
    {
        $id_peminjaman = $request->input('id_peminjaman');
        if ($id_peminjaman == '') {
            $id_peminjaman = auth()->user()->id;
        }

        $get_barang = PeminjamanDanaBarangModel::where('id_peminjaman', '=', $id_peminjaman)->get();

        return view('dashboard.peminjaman_dana.add', ['barang' => $get_barang]);
    }

    public function get_peminjaman_dana_list_karyawan(Request $request)
    {
        $getData = MasterKaryawan::where('nm_karyawan', 'LIKE', '%' . ($request->input('searchTerm')) . '%')->limit(50)->get();

        $hasil = [];

        foreach ($getData as $list_data) {
            // $check_karyawan = PeminjamanDana::where('id_karyawan', '=', $list_data->id_karyawan)->where('sts', 'NOT IN', '("reject","complete")')->count();
            // if ($list_data->id_karyawan == '00023b2b-5b22-346b-9966-0a4fb6b4428e') {
            //     print_r($check_karyawan);
            // }
            // if ($check_karyawan < 1) {
            $hasil[] = [
                'id' => $list_data->id_karyawan,
                'text' => $list_data->nm_karyawan
            ];
            // }
        }

        echo json_encode($hasil);
    }

    public function add_barang_peminjaman_dana(Request $request)
    {
        $this->validate($request, [
            'nama_barang' => ['required', 'max:255']
        ]);

        $id_peminjaman = $request->input('id_peminjaman_dana');
        if ($id_peminjaman == '') {
            $id_peminjaman = auth()->user()->id;
        }
        $nama_barang = $request->input('nama_barang');

        DB::beginTransaction();
        try {
            $barang = new PeminjamanDanaBarangModel();

            $id_pjm2 = PeminjamanDanaBarangModel::where('id', 'LIKE', '%PMJ1-' . date('m-y') . '%')->max('id');
            $kodeBarang = $id_pjm2;
            $urutan = (int) substr($kodeBarang, 11, 5);
            $urutan++;
            $tahun = date('m-y');
            $huruf = "PMJ1-";
            $kode_pmj = $huruf . $tahun . sprintf("%06s", $urutan);

            $barang->id = $kode_pmj;
            $barang->id_peminjaman = $id_peminjaman;
            $barang->nama_barang = $nama_barang;

            $barang->save();

            DB::commit();
            $valid = 1;
        } catch (\Throwable $th) {
            DB::rollback();
            $valid = 0;
        }

        $hasil = array();

        $get_barang_peminjaman_dana = PeminjamanDanaBarangModel::where('id_peminjaman', '=', $id_peminjaman)->get();

        $x = 1;
        foreach ($get_barang_peminjaman_dana as $barang_peminjaman) :
            $hasil[] = '
                <tr>
                    <td class="text-center">' . $x . '</td>
                    <td class="text-center">' . $barang_peminjaman->nama_barang . '</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger del_barang" data-id="' . $barang_peminjaman->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            ';
            $x++;
        endforeach;

        echo json_encode([
            'valid' => $valid,
            'hasil' => $hasil
        ]);
    }

    public function del_barang_peminjaman_dana(Request $request)
    {
        $id = $request->input('id');
        $id_peminjaman = $request->input('id_peminjaman');
        if ($id_peminjaman == '') {
            $id_peminjaman = auth()->user()->id;
        }

        DB::beginTransaction();
        try {
            PeminjamanDanaBarangModel::destroy($id);

            DB::commit();

            $valid = 1;
        } catch (\Throwable $th) {
            DB::rollback();

            $valid = 0;
        }

        $hasil = array();

        $get_barang_peminjaman_dana = PeminjamanDanaBarangModel::where('id_peminjaman', '=', $id_peminjaman)->get();

        $x = 1;
        foreach ($get_barang_peminjaman_dana as $barang_peminjaman) :
            $hasil[] = '
                <tr>
                    <td class="text-center">' . $x . '</td>
                    <td class="text-center">' . $barang_peminjaman->nama_barang . '</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-danger del_barang" data-id="' . $barang_peminjaman->id . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            ';
            $x++;
        endforeach;

        echo json_encode([
            'valid' => $valid,
            'hasil' => $hasil
        ]);
    }

    public function save_peminjaman_dana(Request $request)
    {
        $get_nm_karyawan = MasterKaryawan::find($request->input('nm_karyawan'));

        $karyawan_nm = $get_nm_karyawan->nm_karyawan;
        // if (count($get_nm_karyawan) > 0) {
        //     $karyawan_nm = $get_nm_karyawan->name;
        // }

        $id_pmd1 = PeminjamanDana::where('id', 'LIKE', '%PMD1-' . date('m-y') . '%')->max('id');
        $kodeBarang = $id_pmd1;
        $urutan = (int) substr($kodeBarang, 10, 6);
        $urutan++;
        $tahun = date('m-y');
        $huruf = "PMD1-";
        $kode_pmd = $huruf . $tahun . sprintf("%06s", $urutan);

        DB::beginTransaction();
        try {
            PeminjamanDana::create([
                'id' => $kode_pmd,
                'id_karyawan' => $request->input('nm_karyawan'),
                'nm_karyawan' => $karyawan_nm,
                'tgl_peminjaman' => $request->input('tgl_peminjaman'),
                'tenor' => $request->input('tenor_pinjaman'),
                'nilai_peminjaman' => str_replace(',', '', $request->input('nilai_peminjaman')),
                'sts' => 'draft',
                'keterangan' => $request->input('keterangan'),
                'tipe_pinjaman' => $request->input('tipe_pinjaman')
            ]);


            if ($request->input('tenor_pinjaman') == '2') {
                PeminjamanDanaBarangModel::where('id_peminjaman', '=', auth()->user()->id)->update([
                    'id_peminjaman' => $kode_pmd
                ]);
            }

            $valid = 1;
            $msg = 'Selamat, peminjaman dana telah berhasil di daftarkan !';
            DB::commit();
        } catch (QueryException $e) {
            DB::rollback();
            $valid = 0;
            $msg = 'Maaf, peminjaman dana gagal didaftarkan !';
            // print_r($e->getMessage());
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function req_approval_peminjaman_dana(Request $request)
    {
        DB::beginTransaction();

        try {
            PeminjamanDana::find($request->input('id'))->update([
                'sts' => 'req_approval'
            ]);

            $valid = 1;
            $msg = 'Berhasil, Peminjaman Dana sudah di Request Approval !';
            DB::commit();
        } catch (\Throwable $th) {
            $valid = 0;
            $msg = 'Maaf, Request Approval untuk peminjaman ini gagal !';
            DB::rollBack();
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function reject_approval_peminjaman_dana(Request $request)
    {
        DB::beginTransaction();
        try {
            PeminjamanDana::find($request->id)->update(['sts' => 'reject']);

            $valid = 1;
            $msg = 'Berhasil, Peminjaman Dana berhasil di Reject !';

            DB::commit();
        } catch (\Throwable $th) {
            $valid = 0;
            $msg = 'Gagal, Peminjaman dana gagal di Reject';

            DB::rollBack();
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function view_peminjaman_dana(Request $request)
    {
        $get_peminjaman = PeminjamanDana::find($request->id);

        $get_barang_peminjaman = PeminjamanDanaBarangModel::where('id_peminjaman', '=', $request->id)->get();

        $tipe_peminjaman = '';
        if ($get_peminjaman->tipe_pinjaman == '1') {
            $tipe_peminjaman = 'Peminjaman Dana';
        }
        if ($get_peminjaman->tipe_pinjaman == '2') {
            $tipe_peminjaman = 'Kredit Barang';
        }

        $sts = '<div class="badge badge-primary text-light">Draft</div>';
        if ($get_peminjaman->sts == 'req_approval') {
            $sts = '<div class="badge badge-warning text-light">Request Approval</div>';
        }
        if ($get_peminjaman->sts == 'approved') {
            $sts = '<div class="badge badge-success">Approved</div>';
        }
        if ($get_peminjaman->sts == 'reject') {
            $sts = '<div class="badge badge-danger">Rejected</div>';
        }
        if ($get_peminjaman->sts == 'complete') {
            $sts = '<div class="badge badge-success">Complete</div>';
        }

        $get_pembayaran_peminjaman = PembayaranPeminjaman::where('id_peminjaman_dana', '=', $request->id)->orderBy('tenor_ke')->get();
        $list_pembayaran = '';
        if (count($get_pembayaran_peminjaman) > 0) {
            $no = 1;
            foreach ($get_pembayaran_peminjaman as $pembayaran) :
                $list_pembayaran = $list_pembayaran . '
                    <tr>
                        <td class="text-center">' . $no . '</td>
                        <td class="text-center">' . date('d F Y', strtotime($pembayaran->tgl_tenor)) . '</td>
                        <td class="text-center">Rp. ' . number_format($get_peminjaman->nilai_peminjaman / $get_peminjaman->tenor, 2) . '</td>
                        <td class="text-center">' . date('d F Y', strtotime($pembayaran->tgl_bayar)) . '</td>
                        <td class="text-left">' . $pembayaran->keterangan . '</td>
                    </tr>
                ';
                $no++;
            endforeach;
        }

        return view('dashboard.peminjaman_dana.view', [
            'data_peminjaman' => $get_peminjaman,
            'tipe_peminjaman' => $tipe_peminjaman,
            'list_barang_peminjaman' => $get_barang_peminjaman,
            'status' => $sts,
            'data_pembayaran' => $get_pembayaran_peminjaman,
            'list_pembayaran' => $list_pembayaran
        ]);
    }

    public function del_peminjaman_dana(Request $request)
    {
        DB::beginTransaction();
        try {
            PeminjamanDana::destroy($request->id);
            PeminjamanDanaBarangModel::where('id_peminjaman', '=', $request->id)->delete();

            $valid = 1;
            $msg = 'Selamat, Data Peminjaman Dana sudah berhasil dihapus !';

            DB::commit();
        } catch (\Throwable $th) {
            $valid = 0;
            $msg = 'Maaf, Data Peminjaman Dana gagal dihapus !';

            DB::rollBack();
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function edit_peminjaman_dana(Request $request)
    {
        $get_peminjaman = PeminjamanDana::find($request->id);
        $get_barang_peminjaman = PeminjamanDanaBarangModel::where('id_peminjaman', '=', $request->id)->get();
        $get_karyawan = MasterKaryawan::all();

        return view('dashboard.peminjaman_dana.add', [
            'data_peminjaman' => $get_peminjaman,
            'barang' => $get_barang_peminjaman,
            'data_karyawan' => $get_karyawan
        ]);
    }

    public function save_edit_peminjaman_dana(Request $request)
    {
        $get_karyawan = MasterKaryawan::find($request->input('nm_karyawan'));

        DB::beginTransaction();
        try {
            PeminjamanDana::find($request->id_peminjaman_dana)->update([
                'tipe_pinjaman' => $request->input('tipe_pinjaman'),
                'id_karyawan' => $request->input('nm_karyawan'),
                'nm_karyawan' => $get_karyawan->nm_karyawan,
                'tgl_peminjaman' => $request->input('tgl_peminjaman'),
                'tenor' => $request->input('tenor_pinjaman'),
                'nilai_peminjaman' => $request->input('nilai_peminjaman'),
                'keterangan' => $request->input('keterangan')
            ]);

            if ($request->input('tipe_pinjaman') == '1') {
                PeminjamanDanaBarangModel::where('id_peminjaman', '=', $request->input('id_peminjaman_dana'))->delete();
            }

            $valid = 1;
            $msg = 'Berhasil, Data Peminjaman Dana telah berhasil diubah !';
            DB::commit();
        } catch (\Throwable $th) {
            $valid = 0;
            $msg = 'Gagal, Data Peminjaman Dana gagal diubah !';
            DB::rollback();
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function approval_peminjaman_dana(Request $request)
    {
        DB::beginTransaction();

        try {
            PeminjamanDana::find($request->input('id'))->update(['sts' => 'approved']);

            $valid = 1;
            $msg = 'Berhasil, Peminjaman Dana telah berhasil di Approve !';
            DB::commit();
        } catch (\Throwable $th) {
            $valid = 0;
            $msg = 'Maaf, Peminjaman Dana gagal di Approve !';
            DB::rollback();
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function pembayaran_pinjaman($id)
    {
        $get_peminjaman = PeminjamanDana::find($id);
        $get_pembayaran_pinjaman = PembayaranPeminjaman::where('id_peminjaman_dana', '=', $id)->get();

        return view('dashboard.peminjaman_dana.pembayaran_pinjaman', [
            'data_peminjaman' => $get_peminjaman,
            'data_pembayaran_peminjaman' => $get_pembayaran_pinjaman
        ]);
    }

    public function save_pembayaran_pinjaman(Request $request)
    {

        $get_penawaran = PeminjamanDana::find($request->id_peminjaman);
        DB::beginTransaction();

        // print_r($request->input('check_tenor'));

        try {
            $arr_tenor = array();
            foreach ($request->input('check_tenor') as $tenor) :

                $id_pmb1 = PembayaranPeminjaman::where('id', 'LIKE', '%PMB1-' . date('m-y') . '%')->max('id');
                $kodeBarang = $id_pmb1;
                $urutan = (int) substr($kodeBarang, 10, 6);
                $urutan++;
                $tahun = date('m-y');
                $huruf = "PMB1-";
                $kode_pmb = $huruf . $tahun . sprintf("%06s", $urutan);

                PembayaranPeminjaman::create([
                    'id' => $kode_pmb,
                    'id_peminjaman_dana' => $request->input('id_peminjaman'),
                    'tenor_ke' => $tenor,
                    'tgl_tenor' => $request->input('tgl_tenor_' . $tenor),
                    'tgl_bayar' => $request->input('tgl_bayar_' . $tenor),
                    'keterangan' => $request->input('keterangan_' . $tenor)
                ]);

                $arr_tenor[] = $tenor;
            endforeach;

            $valid = 1;
            $msg = 'Berhasil, Pembayaran Peminjaman untuk Tenor ' . implode(',', $arr_tenor) . ' telah berhasil !';

            DB::commit();
        } catch (QueryException $e) {
            $valid = 0;
            $msg = 'Maaf, Pembayaran Peminjaman untuk Tenor ' . implode(',', $arr_tenor) . ' gagal !';

            DB::rollback();

            // print_r($e->getMessage());
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function complete_peminjaman(Request $request)
    {
        DB::beginTransaction();
        try {
            PeminjamanDana::find($request->input('id'))->update(['sts' => 'complete']);

            $valid = 1;
            $msg = 'Berhasil, Peminjaman berhasil di tutup !';

            DB::commit();
        } catch (\Throwable $th) {
            $valid = 0;
            $msg = 'Maaf, Peminjaman gagal di tutup !';

            DB::rollback();
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }
}
