<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Exception;

class UserPermissionAjaxController extends Controller
{
    public function edit_user_permission(Request $request){
        $id_user = $request->input('id_user');

        $check_view = $request->input('check_view');
        $check_add = $request->input('check_add');
        $check_manage = $request->input('check_manage');
        $check_delete = $request->input('check_delete');

        DB::beginTransaction();

        

        try {
            UserPermission::where('id_user', '=', $id_user)->delete();

            $hasil = [];
            if(!empty($check_view)){
                foreach ($check_view as $ch_view) :
                    $hasil[] = [
                        'id_user' => $id_user,
                        'id_permission' => $ch_view
                    ];
                endforeach;
            }

            if(!empty($check_add)){
                foreach ($check_add as $ch_add) :
                    $hasil[] = [
                        'id_user' => $id_user,
                        'id_permission' => $ch_add
                    ];
                endforeach;
            }

            if(!empty($check_manage)){
                foreach ($check_manage as $ch_manage) :
                    $hasil[] = [
                        'id_user' => $id_user,
                        'id_permission' => $ch_manage
                    ];
                endforeach;
            }

            if(!empty($check_delete)){
                foreach ($check_delete as $ch_delete) :
                    $hasil[] = [
                        'id_user' => $id_user,
                        'id_permission' => $ch_delete
                    ];
                endforeach;
            }

            UserPermission::insert($hasil);

            DB::commit();
            $valid = 1;
        } catch (Exception $e) {
            $valid = 0;
        }

        echo json_encode(['status' => $valid]);
    }
}
