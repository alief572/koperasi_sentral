<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class PengeluaranTabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pengeluaran_tabungan.index', [
            'title' => 'Pengeluaran Tabungan',
            'logged_user' => Auth::user(),
            'active_controller' => get_class($this),
            'site_url' => url()->current()
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
    public function show(PengeluaranTabungan $pengeluaranTabungan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengeluaranTabungan $pengeluaranTabungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengeluaranTabungan $pengeluaranTabungan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengeluaranTabungan $pengeluaranTabungan)
    {
        //
    }
}
