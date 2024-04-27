<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('index');
    }

    public function login(Request $req, $no_permission = null){
        $credentials = $req->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();
 
            return redirect()->intended('/dashboard');
        }else{
            return back()->with('login_error','Username or Password is incorrect !');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
