<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class UserController extends Controller
{
    public function index (Request $request){
        // something
        $user = User::all();
        return Route::view('/admin', 'admin', $user);
    }
}
