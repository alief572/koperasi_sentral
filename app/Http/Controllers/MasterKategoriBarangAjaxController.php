<?php

namespace App\Http\Controllers;

use App\Models\MasterKategoriBarang;

use Illuminate\Http\Request;

class MasterKategoriBarangAjaxController extends Controller
{
    public function kategori_barang_add_modal()
    {
        return view('dashboard.master_kategori_barang.add');
    }

    public function get_kategori_barang(Request $request)
    {
        $search_val = $request->input('search');
        // print_r($search_val);
        // exit;

        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
        $search = request()->input('search.value');

        if ($search_val !== "" && $search_val !== null) {
            $data = MasterKategoriBarang::where('nm_kategori_barang', 'LIKE', '%' . $search_val . '%')
                ->skip($start)
                ->take($length);

            $all_data = MasterKategoriBarang::where('nm_kategori_barang', 'LIKE', '%' . $search_val . '%')
                ;
        } else {
            $data = MasterKategoriBarang::skip($start)->take($length);
            $all_data =  MasterKategoriBarang::all();
        }

        $get_data = $data->get();
        $total = $all_data->count();

        $hasil = [];
        foreach ($get_data as $list_data) {

            $hasil[] = [
                'id' => $list_data->id,
                'nm_kategori_barang' => $list_data->nm_kategori_barang,
                'buttons' => '
            <form id="delete_form">
                <button type="button" class="btn btn-sm btn-warning text-light edit_kategori_barang" data-id="' . $list_data->id . '"><i class="fa fa-edit"></i></button>
                    ' . csrf_field() . '
                    <input type="hidden" name="id" value="' . $list_data->id . '">
                    <button type="submit" class="btn btn-sm btn-danger" data-id="' . $list_data->id . '"><i class="fa fa-trash"></i></button>
                </form>
            '
            ];
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $hasil
        ]);
    }

    public function get_data_kategori_barang($id){
        $get_data = MasterKategoriBarang::find($id);

        return view('dashboard.master_kategori_barang.add',['get_kategori_barang' => $get_data]);
    }
}
