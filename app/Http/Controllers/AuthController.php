<?php

namespace App\Http\Controllers;

use App\Models\User;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
          'name' => $request->usernameValue,
          'password' => $request->passwordValue,
        ];
        if (Auth::attempt($credentials, $request->rememberMe)) {
            /** @var \App\Models\User */
            $user = Auth::user();
            if (!Gate::allows('admin-login', $user)) {
                return response()->json(['message' => 'User are not allow to access this page !'], 403);
            }
            $token = $user->createToken($user->name, ['*'], Carbon::now()->addMinutes(5))->plainTextToken;
            return response()->json([
              "message" => "Successfully Login",
              "adminUser" => $user,
              "adminToken" => $token], 200);
        } else {
            Auth::logout();
            return response()->json(['message' => 'Wrong Username or Password'], 404);
        }
    }
    public function check_remember_access(Request $request)
    {
        if (Auth::viaRemember()) {
            /** @var \App\Models\User */
            $user = Auth::user();
            $token = $user->createToken($user->name, ['*'], Carbon::now()->addMinutes(5))->plainTextToken;
            return response()->json([
              "message" => "Successfully Login",
              "adminUser" => $user,
              "adminToken" => $token], 200);
        } else {
            return response()->json(["isRemember" => false], 404);
        }
    }
}
