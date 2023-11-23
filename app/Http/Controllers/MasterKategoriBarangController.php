<?php

namespace App\Http\Controllers;

use App\Models\MasterKategoriBarang;
use App\Http\Requests\StoreMasterKategoriBarangRequest;
use App\Http\Requests\UpdateMasterKategoriBarangRequest;
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
    public function store(StoreMasterKategoriBarangRequest $request)
    {
        //
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
    public function update(UpdateMasterKategoriBarangRequest $request, MasterKategoriBarang $masterKategoriBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterKategoriBarang $masterKategoriBarang)
    {
        //
    }
}
