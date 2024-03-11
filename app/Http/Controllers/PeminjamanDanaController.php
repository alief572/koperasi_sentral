<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanDana;
use App\Models\MasterKaryawan;
use App\Http\Requests\StorePeminjamanDanaRequest;
use App\Http\Requests\UpdatePeminjamanDanaRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class PeminjamanDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.peminjaman_dana.index', [
            'title' => 'Peminjaman dana',
            'logged_user' => Auth::user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(PeminjamanDana $peminjamanDana)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeminjamanDana $peminjamanDana)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeminjamanDanaRequest $request, PeminjamanDana $peminjamanDana)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeminjamanDana $peminjamanDana)
    {
        //
    }
}
