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
            'title' => 'Master User',
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
            'data_user_permission' => UserPermission::where('id', '=', $id),
            'list_menu' => DB::table('menus as a')
            ->select('a.*, b.id as permit_id')
            ->leftJoin('permission as b', 'b.');
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
