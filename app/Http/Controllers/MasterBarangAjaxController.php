<?php

namespace App\Http\Controllers;

use \App\Models\MasterBarang;
use \App\Models\MasterKategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MasterBarangAjaxController extends Controller
{
    public function barang_add_modal(){
        return view('dashboard.master_barang.add',[
            'kategori_barang' => MasterKategoriBarang::all()
        ]);
    }

    public function get_data_barang($id){
        $get_data = MasterBarang::find($id);

        return view('dashboard.master_barang.add',[
            'get_barang' => $get_data,
            'kategori_barang' => MasterKategoriBarang::all()
        ]);
    }

    public function get_view_barang($id){
        $get_data = MasterBarang::find($id);

        return view('dashboard.master_barang.view',['barang' => $get_data]);
    }
}
