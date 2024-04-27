<?php

namespace App\Http\Controllers;

use App\Models\Menus;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){

        // Your array of objects
        $arrayOfObjects = [
            ['id' => 1, 'name' => 'John', 'age' => 25],
            ['id' => 2, 'name' => 'Doe', 'age' => 30],
            ['id' => 3, 'name' => 'Jane', 'age' => 28]
        ];

        // Specific value you want to filter by
        $specificValue = 'John';

        // Filter the array based on a specific column value
        $filteredArray = array_filter($arrayOfObjects, function($obj) use ($specificValue) {
            return $obj['name'] == $specificValue;
        });

        // Output the filtered array
        // print_r($filteredArray);
        // exit;

        $get_menus = Menus::where('link', '=', '#')->where('parent_id', '=', '0')->get();
        $get_submenus_1 = Menus::where('link', '=', '#')->where('parent_id', '!=', '0')->get();
        $get_submenus_2 = Menus::where('link', '!=', '#')->where('parent_id', '!=', '0')->get();
        return view('dashboard.index',[
            'title' => 'Dashboard',
            'logged_user' => Auth::user(),
            'get_menu' => $get_menus,
            'get_submenus_1' => $get_submenus_1,
            'get_submenus_2' => $get_submenus_2
        ]);
    }
}
