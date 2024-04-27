<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Models\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;



class helperController extends Controller
{
    public static function notification($notif = null)
    {
        return $notif;
    }

    public static function list_menus($user_id = null, $permission){
        return 'return list menus !';
    }
}
