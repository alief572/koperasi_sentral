<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MasterBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.master_barang.index',[
            'title' => 'Master Barang',
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
            'nm_barang' => ['required','max:255'],
            'kategori_barang' => ['required']
        ]);

        $id_barang = MasterBarang::where('id_barang', 'LIKE', '%BAR-' . date('m-y') . '%')->max('id_barang');
        $kodeBarang = $id_barang;
        $urutan = (int) substr($kodeBarang, 10, 5);
        $urutan++;
        $tahun = date('m-y');
        $huruf = "BAR-";
        $kodecollect = $huruf . $tahun . sprintf("%06s", $urutan);

        DB::beginTransaction();
        try {
            $barang = new MasterBarang;

            $barang->id_barang = $kodecollect;
            $barang->nm_barang = $request->input('nm_barang');
            $barang->id_kategori_barang = $request->input('kategori_barang');
            $barang->sts = 1;

            $barang->save();

            DB::commit();

            return response()->json(['success' => 'Data Barang telah tersimpan !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $valid = 0;

            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterBarang $masterBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterBarang $masterBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterBarang $masterBarang)
    {
        $this->validate($request,[
            'nm_barang' => ['required','max:255'],
            'kategori_barang' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $barang = MasterBarang::find($request->input('id_barang'));

            $barang->nm_barang = $request->input('nm_barang');
            $barang->id_kategori_barang = $request->input('kategori_barang');
            // $barang->sts = 1;

            $barang->save();

            DB::commit();

            return response()->json(['success' => 'Data Barang telah tersimpan !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $valid = 0;

            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterBarang $masterBarang)
    {
        //
    }
}
