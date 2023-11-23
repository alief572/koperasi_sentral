<?php

namespace App\Http\Controllers;

use \App\Models\MasterBarang;
use Illuminate\Http\Request;

class MasterBarangAjaxController extends Controller
{
    public function barang_add_modal(){
        return view('dashboard.master_barang.add');
    }

    public function get_data_barang($id){
        $get_data = MasterBarang::find($id);

        return view('dashboard.master_barang.add',['get_barang' => $get_data]);
    }

    public function get_view_barang($id){
        $get_data = MasterBarang::find($id);

        return view('dashboard.master_barang.view',['barang' => $get_data]);
    }
}
