<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use App\Models\User;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('dashboard.user_permission.index', [
            'title' => 'User Permission',
            'logged_user' => Auth::user(),
            'list_users' => User::all()
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
    public function show(UserPermission $userPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dashboard.user_permission.user_permission', [
            'title' => 'Edit User Permission',
            'logged_user' => Auth::user(),
            'data_user' => User::find($id),
            'list_menu' => Menus::all(),
            'list_permission' => DB::table('permission')->get(),
            'user_permission' => DB::table('user_permission')->leftJoin('users', 'users.username' , '=', 'user_permission.id_user')->select('user_permission.id_permission')->where('users.id', '=', $id)->get()->toArray(),
            'count_user_permission' => count(UserPermission::select('id_permission')->where('id_user', '=', Auth::user()->username)->get()->toArray())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPermission $userPermission)
    {
        //
    }
}
