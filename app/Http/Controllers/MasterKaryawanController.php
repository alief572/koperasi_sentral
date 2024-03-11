<?php

namespace App\Http\Controllers;

use App\Models\MasterKaryawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MasterKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.master_karyawan.index', [
            'title' => 'Master Karyawan',
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

        $this->validate($request, [
            'nm_karyawan' => ['required', 'max:255'],
            'no_hp' => ['required', 'numeric'],
            'email' => ['required', 'email:dns'],
            'tgl_lahir' => ['date'],
            'tempat_lahir' => ['max:255'],
            'gender' => ['max:255'],
            'agama' => ['max:255'],
            'tgl_mulai_kerja' => ['date'],
            'tgl_resign' => ['date'],
            'pendidikan_terakhir' => ['max:255'],
            'no_kartu_keluarga' => ['numeric'],
            'no_bpjs' => ['numeric'],
            'no_npwp' => ['numeric'],
            'bank' => ['max:255'],
            'nomor_akun_bank' => ['numeric'],
            'nama_akun_bank' => ['max:255'],
            'swift_code' => ['numeric']
        ]);

        $id_karyawan = MasterKaryawan::where('id_karyawan', 'LIKE', '%KAR-' . date('m-y') . '%')->max('id_karyawan');
        $kodeBarang = $id_karyawan;
        $urutan = (int) substr($kodeBarang, 10, 5);
        $urutan++;
        $tahun = date('m-y');
        $huruf = "KAR-";
        $kodecollect = $huruf . $tahun . sprintf("%06s", $urutan);
        // print_r($kodecollect);
        // exit;

        DB::beginTransaction();
        try {
            $karyawan = new MasterKaryawan;

            $karyawan->id_karyawan = $kodecollect;
            $karyawan->nm_karyawan = $request->input('nm_karyawan');
            $karyawan->no_hp = $request->input('no_hp');
            $karyawan->email = $request->input('email');
            $karyawan->birth_place = $request->input('tempat_lahir');
            $karyawan->birth_date = $request->input('tgl_lahir');
            $karyawan->gender = $request->input('gender');
            $karyawan->religion = $request->input('agama');
            $karyawan->tgl_mulai_kerja = $request->input('tgl_mulai_kerja');
            $karyawan->tgl_resign = $request->input('tgl_resign');
            $karyawan->pendidikan_terakhir = $request->input('pendidikan_terakhir');
            $karyawan->no_kartu_keluarga = $request->input('no_kartu_keluarga');
            $karyawan->no_bpjs = $request->input('no_bpjs');
            $karyawan->no_npwp = $request->input('no_npwp');
            $karyawan->alamat = $request->input('alamat');
            $karyawan->bank_name = $request->input('bank');
            $karyawan->bank_account_number = $request->input('nomor_akun_bank');
            $karyawan->bank_account_name = $request->input('nama_akun_bank');
            $karyawan->bank_address = $request->input('alamat_bank');
            $karyawan->swift_code = $request->input('swift_code');

            $karyawan->save();

            DB::commit();

            return response()->json(['success' => 'Data karyawan telah tersimpan !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $valid = 0;

            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterKaryawan $masterKaryawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterKaryawan $masterKaryawan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterKaryawan $masterKaryawan)
    {
        $this->validate($request, [
            'nm_karyawan' => ['required', 'max:255'],
            'no_hp' => ['required', 'numeric'],
            'email' => ['required', 'email:dns'],
            'tgl_lahir' => ['date'],
            'tempat_lahir' => ['max:255'],
            'gender' => ['max:255'],
            'agama' => ['max:255'],
            'tgl_mulai_kerja' => ['date'],
            'tgl_resign' => ['date'],
            'pendidikan_terakhir' => ['max:255'],
            'no_kartu_keluarga' => ['numeric'],
            'no_bpjs' => ['numeric'],
            'no_npwp' => ['numeric'],
            'bank' => ['max:255'],
            'nomor_akun_bank' => ['numeric'],
            'nama_akun_bank' => ['max:255'],
            'swift_code' => ['numeric']
        ]);

        DB::beginTransaction();
        try {
            $karyawan = MasterKaryawan::find($request->input('id_karyawan'));

            $karyawan->nm_karyawan = $request->input('nm_karyawan');
            $karyawan->no_hp = $request->input('no_hp');
            $karyawan->email = $request->input('email');
            $karyawan->birth_place = $request->input('tempat_lahir');
            $karyawan->birth_date = $request->input('tgl_lahir');
            $karyawan->gender = $request->input('gender');
            $karyawan->religion = $request->input('agama');
            $karyawan->tgl_mulai_kerja = $request->input('tgl_mulai_kerja');
            $karyawan->tgl_resign = $request->input('tgl_resign');
            $karyawan->pendidikan_terakhir = $request->input('pendidikan_terakhir');
            $karyawan->no_kartu_keluarga = $request->input('no_kartu_keluarga');
            $karyawan->no_bpjs = $request->input('no_bpjs');
            $karyawan->no_npwp = $request->input('no_npwp');
            $karyawan->alamat = $request->input('alamat');
            $karyawan->bank_name = $request->input('bank');
            $karyawan->bank_account_number = $request->input('nomor_akun_bank');
            $karyawan->bank_account_name = $request->input('nama_akun_bank');
            $karyawan->bank_address = $request->input('alamat_bank');
            $karyawan->swift_code = $request->input('swift_code');

            $karyawan->save();

            DB::commit();

            return response()->json(['success' => 'Data karyawan telah tersimpan !'], 200);
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
            MasterKaryawan::destroy($request->input('id_karyawan'));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }
}
