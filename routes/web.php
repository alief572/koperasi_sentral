<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterKaryawanController;
use App\Http\Controllers\MasterUserController;
use App\Models\MasterKaryawan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login & Logout
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);

Route::post('/login', [LoginController::class, 'login']);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Master User
Route::resource('/master_user', MasterUserController::class)->middleware('auth');

// Master Karyawan
Route::resource('/master_karyawan', MasterKaryawanController::class)->middleware('auth');

// Ajax Get Data
Route::get('/get_user', function () {
    $data = User::all();
    return response()->json(['data' => $data]);
})->name('get_user');

Route::get('/get_data_user/{id}', function ($id) {
    $data = User::find($id);

    return response()->json($data);
})->name('get_data_user');

Route::get('/get_karyawan', function (Request $request) {
    $search_val = $request->input('search');
    // print_r($search_val);
    // exit;

    $draw = request()->input('draw');
    $start = request()->input('start');
    $length = request()->input('length');
    $search = request()->input('search.value');

    if ($search_val !== "" && $search_val !== null) {
        $data = MasterKaryawan::where('nm_karyawan', 'LIKE', '%' . $search_val . '%')
            ->orWhere('no_hp', 'LIKE', '%' . $search_val . '%')
            ->orWhere('email', 'LIKE', '%' . $search_val . '%')
            ->skip($start)
            ->take($length);

        $all_data = MasterKaryawan::where('nm_karyawan', 'LIKE', '%' . $search_val . '%')
        ->orWhere('no_hp', 'LIKE', '%' . $search_val . '%')
        ->orWhere('email', 'LIKE', '%' . $search_val . '%')
        ->limit(50);
    } else {
        $data = MasterKaryawan::skip($start)
        ->take($length);
        $all_data =  MasterKaryawan::limit(50);
    }

    $get_data = $data->get();
    $total = $all_data->count();

    $hasil = [];
    foreach ($get_data as $list_data) {
        $hasil[] = [
            'id_karyawan' => $list_data->id_karyawan,
            'nm_karyawan' => $list_data->nm_karyawan,
            'no_hp' => $list_data->no_hp,
            'email' => $list_data->email,
            'buttons' => '
                <button type="button" class="btn btn-sm btn-info view_karyawan" data-id_karyawan="'.$list_data->id_karyawan.'"><i class="fa fa-eye"></i></button>
                <button type="button" class="btn btn-sm btn-warning text-light edit_karyawan" data-id_karyawan="'.$list_data->id_karyawan.'"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-sm btn-danger del_karyawan" data-id_karyawan="'.$list_data->id_karyawan.'"><i class="fa fa-trash"></i></button>
            '
        ];
    }

    return response()->json([
        'draw' => $draw,
        'recordsTotal' => $total,
        'recordsFiltered' => $total,
        'data' => $hasil
    ]);
})->name('get_karyawan');

Route::get('/get_data_karyawan/{id}', function($id){
    $get_data = MasterKaryawan::find($id);

    return json_encode(['data' => $get_data]);
})->middleware('auth');
