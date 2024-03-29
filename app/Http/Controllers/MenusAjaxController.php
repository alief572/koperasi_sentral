<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class MenusAjaxController extends Controller
{
    public function get_menus(Request $request)
    {
        $search_val = $request->input('search');
        // print_r($search_val);
        // exit;

        $draw = request()->input('draw');
        $start = request()->input('start');
        $length = request()->input('length');
        $search = request()->input('search.value');

        if ($search_val !== "" && $search_val !== null) {
            $data = Menus::whereAny([
                'id',
                'title',
                'parent_id',
                'permission_id'
            ], 'LIKE', '%' . $search_val . '%')
                ->skip($start)
                ->take($length);

            $all_data = Menus::whereAny([
                'id',
                'title',
                'parent_id',
                'permission_id'
            ], 'LIKE', '%' . $search_val . '%');
        } else {
            $data = Menus::skip($start)->take($length);
            $all_data =  Menus::all();
        }

        $get_data = $data->get();
        $total = $all_data->count();

        $hasil = [];
        $no = 1;
        foreach ($get_data as $list_data) {

            $sts = '';
            if ($list_data->status == '1') {
                $sts = '<div class="badge badge-success">Active</div>';
            } else {
                $sts = '<div class="badge badge-danger">Non Active</div>';
            }

            $hasil[] = [
                'no' => $no,
                'id' => $list_data->id,
                'title' => $list_data->title,
                'link' => $list_data->link,
                'parent_id' => $list_data->parent_id,
                'permission_id' => $list_data->permission_id,
                'status' => $sts,
                'buttons' => '
                    <button type="button" class="btn btn-sm btn-danger del_menus del_menus_' . $list_data->id . '" data-id="' . $list_data->id . '">
                        <i class="fa fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-warning text-light">
                        <i class="fa fa-edit"></i>
                    </button>
                '
            ];

            $no++;
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $hasil
        ]);
    }

    public function add_menus()
    {
        return view('dashboard.menus.add', [
            'list_menu' => Menus::all()
        ]);
    }

    public function save_menus(Request $request)
    {
        // if (count($get_nm_karyawan) > 0) {
        //     $karyawan_nm = $get_nm_karyawan->name;
        // }

        $post = $request->input();

        $parent_menu = $post['parent_menu'];
        if ($parent_menu == '') {
            $parent_menu = '0';
        }

        DB::beginTransaction();
        try {
            $permission_type = ['View', 'Add', 'Delete', 'Manage'];
            foreach ($permission_type as $per_type) {
                Permission::create([
                    'nm_permission' => str_replace(' ', '_', $post['nama_menu']) . $per_type,
                    'ket' => $per_type,
                    'nm_menu' => $post['nama_menu']
                ]);
            }

            Menus::create([
                'title' => $post['nama_menu'],
                'link' => $post['link_menu'],
                'icon' => $post['icon_menu'],
                'parent_id' => $parent_menu,
                'status' => $post['status'],
                'order' => $post['order_menu']
            ]);

            $valid = 1;
            $msg = 'Selamat, Data telah berhasil di input !';
            DB::commit();
        } catch (QueryException $e) {
            DB::rollback();
            $valid = 0;
            $msg = 'Maaf, Data gagal diinput !';
            // print_r($e->getMessage());
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }

    public function del_menus(Request $request)
    {
        $post = $request->input();

        $id = $post['id'];

        DB::beginTransaction();
        try {
            Menus::destroy($id);

            $valid = 1;
            $msg = 'Selamat, Data telah berhasil di hapus !';
            DB::commit();
        } catch (QueryException $e) {
            DB::rollback();
            $valid = 0;
            $msg = 'Maaf, Data gagal di hapus !';
            // print_r($e->getMessage());
        }

        echo json_encode([
            'status' => $valid,
            'msg' => $msg
        ]);
    }
}
