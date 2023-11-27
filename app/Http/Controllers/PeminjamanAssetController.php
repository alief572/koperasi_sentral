<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanAsset;
use App\Models\PeminjamanAsset2;
use App\Models\MasterKaryawan;
use App\Models\MasterBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class PeminjamanAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.peminjaman_asset.index',[
            'title' => 'Peminjaman Asset',
            'logged_user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'tgl_awal_peminjaman' => ['required','date'],
            'tgl_pengembalian' => ['required','date'],
            'karyawan' => ['required']
        ]);

        $tgl_awal_peminjaman = $request->input('tgl_awal_peminjaman');
        $tgl_pengembalian = $request->input('tgl_pengembalian');
        $karyawan = $request->input('karyawan');
        $keterangan = $request->input('keterangan');

        $get_karyawan = MasterKaryawan::find($karyawan);
        $nm_karyawan = $get_karyawan->nm_karyawan;

        $id_pjm2 = PeminjamanAsset::where('id_peminjaman_asset', 'LIKE', '%PJM1-' . date('m-y') . '%')->max('id_peminjaman_asset');
        $kodeBarang = $id_pjm2;
        $urutan = (int) substr($kodeBarang, 11, 5);
        $urutan++;
        $tahun = date('m-y');
        $huruf = "PJM1-";
        $kodecollect = $huruf . $tahun . sprintf("%06s", $urutan);

        DB::beginTransaction();
        try {
            $peminjaman_asset = new PeminjamanAsset;

            $peminjaman_asset->id_peminjaman_asset = $kodecollect;
            $peminjaman_asset->id_karyawan = $karyawan;
            $peminjaman_asset->nm_karyawan = $nm_karyawan;
            $peminjaman_asset->tgl_awal_peminjaman = $tgl_awal_peminjaman;
            $peminjaman_asset->tgl_pengembalian = $tgl_pengembalian;
            $peminjaman_asset->keterangan = $keterangan;
            $peminjaman_asset->sts = 0;

            $peminjaman_asset->save();

            $get_asset = PeminjamanAsset2::where('id_peminjaman_asset', '=', auth()->user()->username)->get();
            foreach($get_asset as $list_asset){
                MasterBarang::where('id_barang', '=', $list_asset->id_asset)->update([
                    'sts' => 2
                ]);
            }
            PeminjamanAsset2::where('id_peminjaman_asset', '=', auth()->user()->username)->update(['id_peminjaman_asset' => $kodecollect]);


            DB::commit();
            return response()->json(['success' => 'Data Peminjaman Asset telah tersimpan !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PeminjamanAsset $peminjamanAsset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeminjamanAsset $peminjamanAsset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PeminjamanAsset $peminjamanAsset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeminjamanAsset $peminjamanAsset)
    {
        //
    }
}
