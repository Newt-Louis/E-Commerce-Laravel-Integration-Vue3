<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function adminLogin(Request $request)
    {
        $credentials = [
          'name' => $request->usernameValue,
          'password' => $request->passwordValue,
        ];
        if ($request->rememberMe) {
            /** @var \Iluminate\Auth\SessionGuard $guard */
            $guard = Auth::guard('web');
            $guard->setRememberDuration(60 * 24 * 30);
        }
        if (Auth::attempt($credentials, $request->rememberMe)) {
            $request->session()->regenerate();
            return response()->json([
              "message" => "Successfully Login",
              "adminUser" => Auth::user()], 200);
        }
        return response()->json(['message' => 'Wrong Username or Password'], 404);
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response('Successfully Logout', 200);
    }
}
