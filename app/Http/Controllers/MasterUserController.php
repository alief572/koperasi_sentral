<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Session;


class MasterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $viewPermission1   = 'Master_User.View';
    protected $addPermission1    = 'Master_User.Add';
    protected $managePermission1 = 'Master_User.Manage';
    protected $deletePermission1 = 'Master_User.Delete';

    public function index()
    {
       
        if(check_menus_user_permission($this->viewPermission1) == '0'){
            return redirect()->route('dashboard')->with("permission_error", "Sorry, you don't have permission to access the menu !");
        }else{
            return view('dashboard.master_user.index', [
                'title' => 'Master User',
                'logged_user' => Auth::user(),
                'list_users' => User::all()
            ]);
        }
        // print_r(check_menus_user_permission($this->viewPermission1));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = $request->validate([
            'nm_user' => 'required|max:255',
            'username' => 'required|max:255',
            'password' => 'required',
            'email' => 'required|email:dns'
        ]);

        $username = $request->input('username');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $nm_user = $request->input('nm_user');

        DB::beginTransaction();
        try {
            $user = new User;

            $user->name = $nm_user;
            $user->email = $email;
            $user->username = $username;
            $user->password = $password;
            $user->sts = 1;
            $user->save();

            DB::commit();
            $valid = 1;

            return response()->json(['success' => 'Data user telah tersimpan !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $valid = 0;

            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'nm_user' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|email:dns',
            'id_karyawan' => 'required'
        ]);


        $id = $request->input('id');
        $username = $request->input('username');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $nm_user = $request->input('nm_user');
        $id_karyawan = $request->input('id_karyawan');

        $updateData = array();
        $updateData['name'] = $nm_user;
        $updateData['email'] = $email;
        $updateData['username'] = $username;
        $updateData['id_karyawan'] = $id_karyawan;
        if ($request->input('password') !== "" && $request->input('password') !== null) {
            $updateData['password'] = $password;
        }

        DB::beginTransaction();
        try {
            User::where('id', $id)->update($updateData);

            DB::commit();
            return response()->json(['success' => 'Data user telah tersimpan !'], 200);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            User::destroy($request->input('id'));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
    }
}
