<?php

use App\Models\Menus;
use App\Models\UserPermission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

function notification($notif = null)
{
    return $notif;
}

function list_menus()
{
    $get_sidebar_menus = Menus::where('status', '=', '1')->get();

    return $get_sidebar_menus;
}

function get_user_permission()
{
    $get_list_user_permission = UserPermission::select('id_permission')->where('id_user', '=', Auth::user()->username)->get();
    $array_id_permission = array();
    foreach ($get_list_user_permission as $permission) :
        $array_id_permission[] = $permission->id_permission;
    endforeach;

    return $array_id_permission;
}

function check_menus_user_permission($menus_access)
{
    $get_id_permission = DB::table('permission')->select('id')->where('nm_permission', '=', $menus_access)->where('ket', '=', 'View')->get()->toArray();
    $id_permission = $get_id_permission[0]->id;

    $get_list_user_permission = UserPermission::select('id_permission')->where('id_user', '=', Auth::user()->username)->where('id_permission', '=', $id_permission)->get()->toArray();

   

    if(count($get_list_user_permission) <= 0){
        return '0';
    }
}
