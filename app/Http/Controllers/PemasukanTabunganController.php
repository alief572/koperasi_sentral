<?php

namespace App\Http\Controllers;

use App\Models\PemasukanTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemasukanTabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pemasukan_tabungan.index', [
            'title' => 'Pemasukan Tabungan',
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
    public function show(PemasukanTabungan $pemasukanTabungan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PemasukanTabungan $pemasukanTabungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PemasukanTabungan $pemasukanTabungan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PemasukanTabungan $pemasukanTabungan)
    {
        //
    }
}
