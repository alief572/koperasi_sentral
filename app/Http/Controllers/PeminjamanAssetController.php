<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanAsset;
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
        //
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
