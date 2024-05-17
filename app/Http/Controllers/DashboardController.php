<?php

namespace App\Http\Controllers;

use App\Models\Menus;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.index',[
            'title' => 'Dashboard',
            'logged_user' => Auth::user()
        ]);
    }
}
