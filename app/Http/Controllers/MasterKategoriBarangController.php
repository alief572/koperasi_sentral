<?php

namespace App\Http\Controllers;

use App\Models\MasterKategoriBarang;
use App\Http\Requests\StoreMasterKategoriBarangRequest;
use App\Http\Requests\UpdateMasterKategoriBarangRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MasterKategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.master_kategori_barang.index',[
            'title' => 'Master Kategori Barang',
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
            'nm_kategori_barang' => ['required','max:255']
        ]);

        DB::beginTransaction();
        try {
            $kategori_barang = new MasterKategoriBarang;

            $kategori_barang->nm_kategori_barang = $request->input('nm_kategori_barang');

            $kategori_barang->save();

            DB::commit();

            return response()->json(['success' => 'Data Kategori Barang telah tersimpan !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $valid = 0;

            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterKategoriBarang $masterKategoriBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterKategoriBarang $masterKategoriBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'nm_kategori_barang' => ['required','max:255']
        ]);

        DB::beginTransaction();
        try {
            $kategori_barang = MasterKategoriBarang::find($request->input('id'));

            $kategori_barang->nm_kategori_barang = $request->input('nm_kategori_barang');

            $kategori_barang->save();

            DB::commit();

            return response()->json(['success' => 'Data Kategori Barang telah tersimpan !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $valid = 0;

            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            MasterKategoriBarang::destroy($request->input('id'));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }
}
