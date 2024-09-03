<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // something
        $user = User::all();
        return response()->json($user);
    }
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user);
        } catch (ModelNotFoundException $e) {
            echo $e->getMessage();
        }
    }
    public function login(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response($user)->json();
        } catch (ModelNotFoundException $e) {
            echo $e->getMessage();
        }
    }
}
