<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterBarangController;
use App\Http\Controllers\MasterBarangAjaxController;
use App\Http\Controllers\MasterKaryawanController;
use App\Http\Controllers\MasterKategoriBarangController;
use App\Http\Controllers\MasterKategoriBarangAjaxController;
use App\Http\Controllers\MasterUserController;
use App\Http\Controllers\MenusAjaxController;
use App\Http\Controllers\PemasukanTabunganController;
use App\Http\Controllers\PemasukanTabunganAjaxController;
use App\Http\Controllers\PeminjamanAssetAjaxController;
use App\Http\Controllers\PeminjamanAssetController;
use App\Http\Controllers\PeminjamanDanaController;
use App\Http\Controllers\PeminjamanDanaAjaxController;
use App\Http\Controllers\PengeluaranTabunganController;
use App\Http\Controllers\PengeluaranTabunganAjaxController;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\TabunganAjaxController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\UserPermissionAjaxController;
use App\Http\Controllers\UserPermissionController;
use App\Models\MasterKaryawan;
use App\Models\MasterBarang;
use App\Models\MasterKategoriBarang;
use App\Models\PemasukanTabungan;
use App\Models\PengeluaranTabungan;
use App\Models\Tabungan;
use App\Models\Menus;
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
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Master User
Route::resource('/master_user', MasterUserController::class)->middleware('auth');

// Master Karyawan
Route::resource('/master_karyawan', MasterKaryawanController::class)->middleware('auth');

// Master Barang
Route::resource('/master_barang', MasterBarangController::class)->middleware('auth');

// Master Kategori Barang
Route::resource('/master_kategori_barang', MasterKategoriBarangController::class)->middleware('auth');

// Peminjaman Asset
Route::resource('/peminjaman_asset', PeminjamanAssetController::class)->middleware('auth');

// Peminjaman Dana
Route::resource('/peminjaman_dana', PeminjamanDanaController::class)->middleware('auth');

// Pemasukan Tabungan
Route::resource('/pemasukan_tabungan', PemasukanTabunganController::class)->middleware('auth');

// Pengeluaran Tabungan
Route::resource('/pengeluaran_tabungan', PengeluaranTabunganController::class)->middleware('auth');

// Pengeluaran Tabungan
Route::resource('/tabungan_karyawan', TabunganController::class)->middleware('auth');

// Menus
Route::resource('/menus', MenusController::class)->middleware('auth');

// User Permission
Route::resource('/user_permission', UserPermissionController::class)->middleware('auth');

// Ajax Get Data
Route::get('/get_user', function () {
    $data = User::all();
    return response()->json(['data' => $data]);
})->name('get_user');

Route::get('/get_data_user/{id}', function ($id) {
    $data = User::find($id);
    $get_karyawan = MasterKaryawan::all();

    $list_karyawan = '<option value="">- Pilih Karyawan -</option>';
    foreach($get_karyawan as $karyawan) :
        $selected = '';
        if($data->id_karyawan == $karyawan->id_karyawan):
            $selected = 'selected';
        endif;
        $list_karyawan .= '<option value="'.$karyawan->id_karyawan.'" '.$selected.'>'.$karyawan->nm_karyawan.'</option>';
    endforeach;

    return response()->json(['data_user' => $data, 'list_karyawan' => $list_karyawan]);
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
    $no = $start + 1;
    foreach ($get_data as $list_data) {
        $hasil[] = [
            'no' => $no,
            'id_karyawan' => $list_data->id_karyawan,
            'nm_karyawan' => $list_data->nm_karyawan,
            'no_hp' => $list_data->no_hp,
            'email' => $list_data->email,
            'buttons' => '
                <button type="button" class="btn btn-sm btn-info view_karyawan" data-id_karyawan="' . $list_data->id_karyawan . '"><i class="fa fa-eye"></i></button>
                <button type="button" class="btn btn-sm btn-warning text-light edit_karyawan" data-id_karyawan="' . $list_data->id_karyawan . '"><i class="fa fa-edit"></i></button>
                <form id="delete_form">
                    ' . csrf_field() . '
                    <input type="hidden" name="id_karyawan" value="' . $list_data->id_karyawan . '">
                    <button type="submit" class="btn btn-sm btn-danger" data-id_karyawan="' . $list_data->id_karyawan . '"><i class="fa fa-trash"></i></button>
                </form>
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
})->name('get_karyawan');

Route::get('/get_data_karyawan/{id}', function ($id) {
    $get_data = MasterKaryawan::find($id);

    return json_encode(['data' => $get_data]);
})->middleware('auth');

Route::get('/get_view_karyawan/{id}', function ($id) {
    $get_data = MasterKaryawan::find($id);

    $pendidikan = [
        0 => 'Tidak Sekolah',
        1 => 'SD',
        2 => 'SMP',
        3 => 'SMA',
        4 => 'D3',
        5 => 'S1',
        6 => 'S2',
        7 => 'S3'
    ];

    $bank = [
        '008' => 'Bank Mandiri',
        '002' => 'Bank Rakyat Indonesia (BRI)',
        '009' => 'Bank Negara Indonesia (BNI)',
        '022' => 'Bank CIMB Niaga',
        '011' => 'Bank Danamon',
        '013' => 'Bank Permata',
        '019' => 'Bank Panin',
        '016' => 'Bank Maybank',
        '099' => 'Bank HSBC',
        '426' => 'Bank Mega',
        '200' => 'Bank Tabungan Negara (BTN)',
        '427' => 'Bank Syariah Indonesia (BSI)',
        '147' => 'Bank Muamalat',
        '451' => 'Bank Mayapad',
        '411' => 'Bank Artha Graha',
        '010' => 'Bank UOB Indonesia',
        '401' => 'Bank Shinhan Indonesia',
        '028' => 'Bank OCBC NISP',
        '023' => 'Bank Commonwealth',
        '029' => 'Bank Capital Indonesia',
        '167' => 'Bank QNB Indonesia',
        '212' => 'Bank Woori Saudara Indonesia 1906',
        '531' => 'Bank Amar Indonesia',
        '061' => 'Bank ANZ Indonesi',
        '057' => 'Bank BNP Paribas Indonesia',
        '213' => 'Bank BTPN',
        '547' => 'Bank BTPN Syariah',
        '425' => 'Bank JTrust Indonesia',
        '429' => 'Bank Maybank Syariah Indonesia',
        '453' => 'Bank Danamon Syariah',
        '452' => 'Bank Permata Syariah',
        '147' => 'Bank Muamalat Indonesia',
        '451' => 'Bank Syariah Mandiri',
        '422' => 'Bank BRI Syariah',
        '427' => 'BNI Syariah',
        '422' => 'Bank Syariah Indonesia (Eks BRI Syariah)',
        '427' => 'Bank Syariah Indonesia (Eks BNI Syariah)'
    ];

    return view('dashboard.master_karyawan.view', [
        'hasil' => $get_data,
        'pendidikan_terakhir' => $pendidikan[$get_data->pendidikan_terakhir],
        'bank' => $bank[$get_data->bank_name]
    ]);
});

Route::get('/get_barang', function (Request $request) {
    $search_val = $request->input('search');
    // print_r($search_val);
    // exit;

    $draw = request()->input('draw');
    $start = request()->input('start');
    $length = request()->input('length');
    $search = request()->input('search.value');

    if ($search_val !== "" && $search_val !== null) {
        $data = MasterBarang::where('nm_barang', 'LIKE', '%' . $search_val . '%')
            ->skip($start)
            ->take($length);

        $all_data = MasterBarang::where('nm_barang', 'LIKE', '%' . $search_val . '%')
            ->limit(50);
    } else {
        $data = MasterBarang::skip($start)->take($length);
        $all_data =  MasterBarang::limit(50);
    }

    $get_data = $data->get();
    $total = $all_data->count();

    $hasil = [];
    foreach ($get_data as $list_data) {
        if ($list_data->sts == 1) {
            $status = '<div class="badge badge-success">Tersedia</div>';
        } else {
            $status = '<div class="badge badge-danger">Tidak Tersedia</div>';
        }

        $hasil[] = [
            'id_barang' => $list_data->id_barang,
            'nm_barang' => $list_data->nm_barang,
            'kategori_barang' => $list_data->kategori_barang->nm_kategori_barang,
            'sts' => $status,
            'buttons' => '
            <form id="delete_form">
                <button type="button" class="btn btn-sm btn-info view_barang" data-id_barang="' . $list_data->id_barang . '"><i class="fa fa-eye"></i></button>
                <button type="button" class="btn btn-sm btn-warning text-light edit_barang" data-id_barang="' . $list_data->id_barang . '"><i class="fa fa-edit"></i></button>
                    ' . csrf_field() . '
                    <input type="hidden" name="id_barang" value="' . $list_data->id_barang . '">
                    <button type="submit" class="btn btn-sm btn-danger" data-id_barang="' . $list_data->id_barang . '"><i class="fa fa-trash"></i></button>
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
})->name('get_barang');

// Ajax Modul Master Barang
Route::get('/barang_add_modal', [MasterBarangAjaxController::class, 'barang_add_modal'])->middleware('auth')->name('barang_add_modal');
Route::get('/get_data_barang/{id}', [MasterBarangAjaxController::class, 'get_data_barang'])->middleware('auth');
Route::get('/get_view_barang/{id}', [MasterBarangAjaxController::class, 'get_view_barang'])->middleware('auth');

// Ajax Modul Master Kategori Barang
Route::get('/kategori_barang_add_modal', [MasterKategoriBarangAjaxController::class, 'kategori_barang_add_modal'])->middleware('auth')->name('kategori_barang_add_modal');
Route::get('/get_kategori_barang', [MasterKategoriBarangAjaxController::class, 'get_kategori_barang'])->middleware('auth')->name('get_kategori_barang');
Route::get('/get_data_kategori_barang/{id}', [MasterKategoriBarangAjaxController::class, 'get_data_kategori_barang'])->middleware('auth')->name('get_data_kategori_barang');

// Ajax Modul Peminjaman Asset
Route::get('/get_peminjaman_asset', [PeminjamanAssetAjaxController::class, 'get_peminjaman_asset'])->middleware('auth')->name('get_peminjaman_asset');
Route::get('/add_modal_peminjaman_asset', [PeminjamanAssetAjaxController::class, 'add_modal_peminjaman_asset'])->middleware('auth')->name('add_modal_peminjaman_asset');
Route::post('/get_peminjaman_asset_list_karyawan', [PeminjamanAssetAjaxController::class, 'get_peminjaman_asset_list_karyawan'])->middleware('auth');
Route::post('/get_asset', [PeminjamanAssetAjaxController::class, 'get_asset'])->middleware('auth');
Route::post('/add_item_peminjaman_asset', [PeminjamanAssetAjaxController::class, 'add_item_peminjaman_asset'])->middleware('auth');
Route::delete('/del_item_peminjaman_asset/{id}', [PeminjamanAssetAjaxController::class, 'del_item_peminjaman_asset'])->middleware('auth');
Route::get('/view_detail_peminjaman/{id}', [PeminjamanAssetAjaxController::class, 'view_detail_peminjaman'])->middleware('auth');
Route::put('/approve_peminjaman_asset/{id}', [PeminjamanAssetAjaxController::class, 'approve_peminjaman_asset'])->middleware('auth');
Route::put('/pengembalian_asset/{id}', [PeminjamanAssetAjaxController::class, 'pengembalian_asset'])->middleware('auth');
Route::put('/reject_peminjaman/{id}', [PeminjamanAssetAjaxController::class, 'reject_peminjaman'])->middleware('auth');

// Ajax Modul Peminjaman Dana
Route::get('/get_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'get_peminjaman_dana'])->middleware('auth')->name('get_peminjaman_dana');
Route::get('/add_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'add_peminjaman_dana'])->middleware('auth')->name('add_peminjaman_dana');
Route::get('/get_peminjaman_dana_list_karyawan', [PeminjamanDanaAjaxController::class, 'get_peminjaman_dana_list_karyawan'])->middleware('auth')->name('get_peminjaman_dana_list_karyawan');
Route::post('/add_barang_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'add_barang_peminjaman_dana'])->middleware('auth')->name('add_barang_peminjaman_dana');
Route::delete('/del_barang_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'del_barang_peminjaman_dana'])->middleware('auth')->name('del_barang_peminjaman_dana');
Route::post('/save_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'save_peminjaman_dana'])->middleware('auth')->name('save_peminjaman_dana');
Route::put('/req_approval_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'req_approval_peminjaman_dana'])->middleware('auth')->name('req_approval_peminjaman_dana');
Route::put('/reject_approval_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'reject_approval_peminjaman_dana'])->middleware('auth')->name('reject_approval_peminjaman_dana');
Route::get('/view_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'view_peminjaman_dana'])->middleware('auth')->name('view_peminjaman_dana');
Route::delete('/del_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'del_peminjaman_dana'])->middleware('auth')->name('del_peminjaman_dana');
Route::get('/edit_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'edit_peminjaman_dana'])->middleware('auth')->name('edit_peminjaman_dana');
Route::put('/save_edit_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'save_edit_peminjaman_dana'])->middleware('auth')->name('save_edit_peminjaman_dana');
Route::put('/approval_peminjaman_dana', [PeminjamanDanaAjaxController::class, 'approval_peminjaman_dana'])->middleware('auth')->name('approval_peminjaman_dana');
Route::get('/pembayaran_pinjaman/{id}', [PeminjamanDanaAjaxController::class, 'pembayaran_pinjaman'])->middleware('auth')->name('pembayaran_pinjaman');
Route::post('/save_pembayaran_pinjaman', [PeminjamanDanaAjaxController::class, 'save_pembayaran_pinjaman'])->middleware('auth')->name('save_pembayaran_pinjaman');
Route::put('/complete_peminjaman', [PeminjamanDanaAjaxController::class, 'complete_peminjaman'])->middleware('auth')->name('complete_peminjaman');

// Ajax Pemasukan Tabungan
Route::get('/get_pemasukan_tabungan', [PemasukanTabunganAjaxController::class, 'get_pemasukan_tabungan'])->middleware('auth')->name('get_pemasukan_tabungan');
Route::get('/add_pemasukan_modal', [PemasukanTabunganAjaxController::class, 'add_pemasukan_modal'])->middleware('auth')->name('add_pemasukan_modal');
Route::get('/get_karyawan_pemasukan', [PemasukanTabunganAjaxController::class, 'get_karyawan_pemasukan'])->middleware('auth')->name('get_karyawan_pemasukan');
Route::post('/save_pemasukan_tabungan', [PemasukanTabunganAjaxController::class, 'save_pemasukan_tabungan'])->middleware('auth')->name('save_pemasukan_tabungan');
Route::delete('/del_pemasukan_tabungan', [PemasukanTabunganAjaxController::class, 'del_pemasukan_tabungan'])->middleware('auth')->name('del_pemasukan_tabungan');
Route::get('/view_pemasukan_tabungan', [PemasukanTabunganAjaxController::class, 'view_pemasukan_tabungan'])->middleware('auth')->name('view_pemasukan_tabungan');
Route::get('/edit_pemasukan_tabungan_modal', [PemasukanTabunganAjaxController::class, 'edit_pemasukan_tabungan_modal'])->middleware('auth')->name('edit_pemasukan_tabungan_modal');
Route::put('/edit_pemasukan_tabungan', [PemasukanTabunganAjaxController::class, 'edit_pemasukan_tabungan'])->middleware('auth')->name('edit_pemasukan_tabungan');
Route::put('/approval_pemasukan_tabungan', [PemasukanTabunganAjaxController::class, 'approval_pemasukan_tabungan'])->middleware('auth')->name('approval_pemasukan_tabungan');

// Ajax Pemasukan Tabungan
Route::get('/get_pengeluaran_tabungan', [PengeluaranTabunganAjaxController::class, 'get_pengeluaran_tabungan'])->middleware('auth')->name('get_pengeluaran_tabungan');
Route::get('/add_pengeluaran_modal', [PengeluaranTabunganAjaxController::class, 'add_pengeluaran_modal'])->middleware('auth')->name('add_pengeluaran_modal');
Route::get('/get_karyawan_pengeluaran', [PengeluaranTabunganAjaxController::class, 'get_karyawan_pengeluaran'])->middleware('auth')->name('get_karyawan_pengeluaran');
Route::post('/save_pengeluaran_tabungan', [PengeluaranTabunganAjaxController::class, 'save_pengeluaran_tabungan'])->middleware('auth')->name('save_pengeluaran_tabungan');
Route::delete('/del_pengeluaran_tabungan', [PengeluaranTabunganAjaxController::class, 'del_pengeluaran_tabungan'])->middleware('auth')->name('del_pengeluaran_tabungan');
Route::get('/view_pengeluaran_tabungan', [PengeluaranTabunganAjaxController::class, 'view_pengeluaran_tabungan'])->middleware('auth')->name('view_pengeluaran_tabungan');
Route::get('/edit_pengeluaran_tabungan_modal', [PengeluaranTabunganAjaxController::class, 'edit_pengeluaran_tabungan_modal'])->middleware('auth')->name('edit_pengeluaran_tabungan_modal');
Route::put('/edit_pengeluaran_tabungan', [PengeluaranTabunganAjaxController::class, 'edit_pengeluaran_tabungan'])->middleware('auth')->name('edit_pengeluaran_tabungan');
Route::put('/approval_pengeluaran_tabungan', [PengeluaranTabunganAjaxController::class, 'approval_pengeluaran_tabungan'])->middleware('auth')->name('approval_pengeluaran_tabungan');
Route::post('/get_tabungan_pengeluaran', [PengeluaranTabunganAjaxController::class, 'get_tabungan_pengeluaran'])->middleware('auth')->name('get_tabungan_pengeluaran');

// Ajax Tabungan Karyawan
Route::get('/view_tabungan_karyawan', [TabunganAjaxController::class, 'view_tabungan_karyawan'])->middleware('auth')->name('view_tabungan_karyawan');
Route::post('/search_tabungan_karyawan', [TabunganAjaxController::class, 'search_tabungan_karyawan'])->middleware('auth')->name('search_tabungan_karyawan');

// Ajax Menus
Route::get('/get_menus', [MenusAjaxController::class, 'get_menus'])->middleware('auth')->name('get_menus');
Route::get('/add_menus', [MenusAjaxController::class, 'add_menus'])->middleware('auth')->name('add_menus');
Route::get('/edit_modal_menus', [MenusAjaxController::class, 'edit_modal_menus'])->middleware('auth')->name('edit_modal_menus');
Route::delete('/del_menus', [MenusAjaxController::class, 'del_menus'])->middleware('auth')->name('del_menus');
Route::post('/save_menus', [MenusAjaxController::class, 'save_menus'])->middleware('auth')->name('save_menus');
Route::put('/add_auto_permission', [MenusAjaxController::class, 'add_auto_permission'])->middleware('auth')->name('add_auto_permission');
Route::put('/edit_menus', [MenusAjaxController::class, 'edit_menus'])->middleware('auth')->name('edit_menus');

// Ajax User Permission

Route::get('/get_user_permission', [UserPermissionAjaxController::class, 'get_user_permission'])->middleware('auth')->name('get_user_permission');
Route::post('/edit_user_permission', [UserPermissionAjaxController::class, 'edit_user_permission'])->middleware('auth')->name('edit_user_permission');

