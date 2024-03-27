<?php

namespace App\Http\Controllers;

use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class TabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $get_tabungan_karyawan = DB::table('ms_tabungan as a')
        ->select(
            'a.nm_karyawan',
            'a.id_karyawan',
            DB::raw('(SELECT SUM(b.nilai) FROM ms_tabungan b WHERE b.id_karyawan = a.id_karyawan AND b.tipe = "pemasukan" AND b.status = "1") as nilai_pemasukan'),
            DB::raw('(SELECT SUM(c.nilai) FROM ms_tabungan c WHERE c.id_karyawan = a.id_karyawan AND c.tipe = "pengeluaran" AND c.status = "1") as nilai_pengeluaran')
        )
        ->groupBy('a.id_karyawan')
        ->orderBy('a.nm_karyawan', 'asc')
        ->get();

        return view('dashboard.tabungan_karyawan.index', [
            'title' => 'Tabungan Karyawan',
            'logged_user' => Auth::user(),
            'active_controller' => get_class($this),
            'site_url' => url()->current(),
            'data_tabungan_karyawan' => $get_tabungan_karyawan
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
    public function show(Tabungan $tabungan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tabungan $tabungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tabungan $tabungan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tabungan $tabungan)
    {
        //
    }
}
