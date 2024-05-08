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
            if(!empty($check_view) || !empty($check_add) || !empty($check_delete) || !empty($check_manage)){
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
                        $get_main_perm = DB::table('permission')->select('nm_menu')->where('id', '=', $ch_add)->get();
                        $get_add_perm = DB::table('permission')->select('id')->where('ket', '=', 'Add')->andWhere('nm_menu', '=', $get_main_perm->nm_menu)->get();
                        $hasil[] = [
                            'id_user' => $id_user,
                            'id_permission' => $get_add_perm->id
                        ];
                    endforeach;
                }
    
                if(!empty($check_manage)){
                    foreach ($check_manage as $ch_manage) :
                        $get_main_perm = DB::table('permission')->select('nm_menu')->where('id', '=', $ch_manage)->get();
                        $get_manage_perm = DB::table('permission')->select('id')->where('ket', '=', 'Manage')->andWhere('nm_menu', '=', $get_main_perm->nm_menu)->get();
                        $hasil[] = [
                            'id_user' => $id_user,
                            'id_permission' => $get_manage_perm->id
                        ];
                    endforeach;
                }
    
                if(!empty($check_delete)){
                    foreach ($check_delete as $ch_delete) :
                        $get_main_perm = DB::table('permission')->select('nm_menu')->where('id', '=', $ch_delete)->get();
                        $get_del_perm = DB::table('permission')->select('id')->where('ket', '=', 'Delete')->andWhere('nm_menu', '=', $get_main_perm->nm_menu)->get();
                        $hasil[] = [
                            'id_user' => $id_user,
                            'id_permission' => $get_del_perm->id
                        ];
                    endforeach;
                }
    
                UserPermission::insert($hasil);
    
                DB::commit();
                $valid = 1;
            }else{
                $valid = 0;
            }
        } catch (Exception $e) {
            dd($e->getMessage()); // Display the error message
        }

        echo json_encode(['status' => $valid]);
    }
}
