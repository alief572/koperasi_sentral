<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PeminjamanAsset;
use App\Models\PeminjamanAsset2;
use App\Models\MasterKaryawan;
use App\Models\MasterBarang;
use PhpParser\Node\Stmt\TryCatch;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class PeminjamanAssetAjaxController extends Controller
{
    public function get_peminjaman_asset(Request $request)
    {
        $search_val = $request->input('search');
        // print_r($search_val);
        // exit;

        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
        $search = request()->input('search');

        if ($search !== "" && $search !== null) {
            $data = PeminjamanAsset::where('nm_karyawan', 'LIKE', '%' . $search . '%')
                ->orWhere('tgl_awal_peminjaman', 'LIKE', '%' . $search . '%')
                ->orWhere('tgl_pengembalian', 'LIKE', '%' . $search . '%')
                ->skip($start)
                ->take($length);

            $all_data = PeminjamanAsset::where('nm_karyawan', 'LIKE', '%' . $search . '%')
                ->orWhere('tgl_awal_peminjaman', 'LIKE', '%' . $search . '%')
                ->orWhere('tgl_pengembalian', 'LIKE', '%' . $search . '%')
                ->limit(50);
        } else {
            $data = PeminjamanAsset::skip($start)->take($length);
            $all_data =  PeminjamanAsset::limit(50);
        }

        $get_data = $data->get();
        $total = $all_data->count();

        $hasil = [];
        foreach ($get_data as $list_data) {

            if ($list_data->sts == 1) {
                $status = '<div class="badge badge-primary">Approved</div>';
            } else if ($list_data->sts == 2) {
                $status = '<div class="badge badge-success">Returned</div>';
            } else if ($list_data->sts == 3) {
                $status = '<div class="badge badge-danger">Rejected</div>';
            } else {
                $status = '<div class="badge badge-warning text-light">Request Approval</div>';
            }

            $apprv_btn = "";
            if ($list_data->sts == 0) {
                $apprv_btn = '<button type="button" class="btn btn-sm btn-success approve_peminjaman" data-id_peminjaman_asset="' . $list_data->id_peminjaman_asset . '"><i class="fa fa-check"></i></button>';
            } else {
                if ($list_data->sts == 1) {
                    $apprv_btn = '<button type="button" class="btn btn-sm btn-success pengembalian_asset" data-id_peminjaman_asset="' . $list_data->id_peminjaman_asset . '"><i class="fa fa-check"></i></button>';
                }
            }

            $edit_btn = '';
            $del_btn = '';
            $reject_btn = '';
            $view_btn = '<button type="button" class="btn btn-sm btn-info view_barang" data-id_peminjaman_asset="' . $list_data->id_peminjaman_asset . '"><i class="fa fa-eye"></i></button>';
            if ($list_data->sts == 0) {
                $edit_btn = ' <button type="button" class="btn btn-sm btn-warning text-light edit_barang" data-id_peminjaman_asset="' . $list_data->id_peminjaman_asset . '"><i class="fa fa-edit"></i></button>';
                $del_btn = '<button type="submit" class="btn btn-sm btn-danger" data-id_peminjaman_asset="' . $list_data->id_peminjaman_asset . '"><i class="fa fa-trash"></i></button>';

                $reject_btn = '<button type="button" class="btn btn-sm btn-danger reject_peminjaman" data-id_peminjaman_asset="' . $list_data->id_peminjaman_asset . '"><i class="fa fa-ban"></i></button>';
            }

            $hasil[] = [
                'id_peminjaman_asset' => $list_data->id_peminjaman_asset,
                'id_karyawan' => $list_data->id_karyawan,
                'nm_karyawan' => $list_data->nm_karyawan,
                'tgl_awal_peminjaman' => date('d F Y', strtotime($list_data->tgl_awal_peminjaman)),
                'tgl_pengembalian' => date('d F Y', strtotime($list_data->tgl_pengembalian)),
                'sts' => $status,
                'buttons' => '
                <form id="delete_form">
                    ' . $apprv_btn . '
                    ' . $view_btn . '
                    ' . $edit_btn . '
                    ' . $reject_btn . '
                    ' . csrf_field() . '
                    <input type="hidden" name="id_peminjaman_asset" value="' . $list_data->id_peminjaman_asset . '">
                    ' . $del_btn . '
                </form>
                '
            ];
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $hasil
        ]);
    }

    public function add_modal_peminjaman_asset()
    {
        return view('dashboard.peminjaman_asset.add', [
            'karyawan' => MasterKaryawan::all()
        ]);
    }

    public function get_peminjaman_asset_list_karyawan(Request $request)
    {
        // if(!empty($_POST['searchTerm'])){
        //     $getData = MasterKaryawan::where('nm_karyawan','LIKE','%'.$_POST['searchTerm'].'%')->limit(50)->get();
        // }else{
        //     $getData = MasterKaryawan::limit(50)->get();
        // }

        $getData = MasterKaryawan::where('nm_karyawan', 'LIKE', '%' . ($request->input('searchTerm')) . '%')->limit(50)->get();

        $hasil = [];

        foreach ($getData as $list_data) {
            $hasil[] = [
                'id' => $list_data->id_karyawan,
                'text' => $list_data->nm_karyawan
            ];
        }

        // sleep(1);

        echo json_encode($hasil);
    }

    public function get_asset(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        if (!empty($searchTerm)) {
            $getData = MasterBarang::where('nm_barang', 'LIKE', '%' . ($request->input('searchTerm')) . '%')->where('sts', '=', 1)->limit(50)->get();
        } else {
            $getData = MasterBarang::where('sts', '=', 1)->limit(50)->get();
        }

        $hasil = [];

        foreach ($getData as $list_data) {
            $hasil[] = [
                'id' => $list_data->id_barang,
                'text' => $list_data->nm_barang
            ];
        }

        // sleep(1);

        echo json_encode($hasil);
    }

    public function add_item_peminjaman_asset(Request $request)
    {
        $item_asset = $request->input('item_asset');
        $id_peminjaman_asset = $request->input('id_peminjaman_asset');

        $data_asset = MasterBarang::find($item_asset);
        $nm_asset = $data_asset->nm_barang;

        $id_pjm2 = PeminjamanAsset2::where('id_peminjaman_asset2', 'LIKE', '%PJM2-' . date('m-y') . '%')->max('id_peminjaman_asset2');
        $kodeBarang = $id_pjm2;
        $urutan = (int) substr($kodeBarang, 11, 5);
        $urutan++;
        $tahun = date('m-y');
        $huruf = "PJM2-";
        $kodecollect = $huruf . $tahun . sprintf("%06s", $urutan);

        DB::beginTransaction();
        try {
            $peminjaman_asset2 = new PeminjamanAsset2;

            $peminjaman_asset2->id_peminjaman_asset2 = $kodecollect;
            $peminjaman_asset2->id_peminjaman_asset = $id_peminjaman_asset;
            $peminjaman_asset2->id_asset = $item_asset;
            $peminjaman_asset2->nm_asset = $nm_asset;

            $peminjaman_asset2->save();

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
        }
        $hasil = array();
        $get_peminjaman_asset_item = PeminjamanAsset2::where('id_peminjaman_asset', '=', $id_peminjaman_asset)->get();

        $no = 1;
        foreach ($get_peminjaman_asset_item as $list_item) {
            $hasil[] = '
                <tr>
                    <td class="text-center">' . $no . '</td>
                    <td>' . $list_item->barang->nm_barang . '</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger del_item_asset" data-id_peminjaman_asset2="' . $list_item->id_peminjaman_asset2 . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            ';
            $no++;
        }

        echo json_encode($hasil);
    }

    public function del_item_peminjaman_asset(Request $request)
    {
        DB::beginTransaction();
        try {
            PeminjamanAsset2::destroy($request->input('id_peminjaman_asset2'));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }

        $hasil = array();
        $get_peminjaman_asset_item = PeminjamanAsset2::where('id_peminjaman_asset', '=', auth()->user()->id)->get();

        $no = 1;
        foreach ($get_peminjaman_asset_item as $list_item) {
            $hasil[] = '
                <tr>
                    <td class="text-center">' . $no . '</td>
                    <td>' . $list_item->barang->nm_barang . '</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger del_item_asset" data-id_peminjaman_asset2="' . $list_item->id_peminjaman_asset2 . '">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            ';
            $no++;
        }

        echo json_encode($hasil);
    }

    public function view_detail_peminjaman($id)
    {
        return view('dashboard.peminjaman_asset.view', [
            'data_peminjaman' => PeminjamanAsset::find($id),
            'data_asset_peminjaman' => PeminjamanAsset2::where('id_peminjaman_asset', '=', $id)->get()
        ]);
    }

    public function approve_peminjaman_asset($id)
    {
        DB::beginTransaction();
        try {
            $approve_peminjaman = PeminjamanAsset::find($id);
            $approve_peminjaman->sts = 1;

            $approve_peminjaman->save();

            DB::commit();
            return response()->json(['success' => 'Peminjaman Asset telah di approve !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => $th->getMessage()], 422);
        }
    }
    public function pengembalian_asset($id)
    {
        DB::beginTransaction();
        try {
            $approve_peminjaman = PeminjamanAsset::find($id);
            $approve_peminjaman->sts = 2;

            $approve_peminjaman->save();

            $get_peminjaman_asset = PeminjamanAsset2::where('id_peminjaman_asset', '=', $id)->get();
            foreach ($get_peminjaman_asset as $list_asset) {
                MasterBarang::where('id_barang', '=', $list_asset->id_asset)->update([
                    'sts' => 1
                ]);
            }

            DB::commit();
            return response()->json(['success' => 'Asset telah di kembalikan !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    public function reject_peminjaman($id)
    {
        DB::beginTransaction();
        try {
            $approve_peminjaman = PeminjamanAsset::find($id);
            $approve_peminjaman->sts = 3;

            $approve_peminjaman->save();

            $get_peminjaman_asset = PeminjamanAsset2::where('id_peminjaman_asset', '=', $id)->get();
            foreach ($get_peminjaman_asset as $list_asset) {
                MasterBarang::where('id_barang', '=', $list_asset->id_asset)->update([
                    'sts' => 1
                ]);
            }

            DB::commit();
            return response()->json(['success' => 'Permohonan peminjaman telah di reject !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => $th->getMessage()], 422);
        }
    }
}
