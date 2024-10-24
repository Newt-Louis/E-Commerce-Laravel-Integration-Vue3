<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('usernameValue')) {
            $user = User::firstWhere('name', $request->input('usernameValue'));

            if ($user && in_array($user->role_id, [1,2,3])) {
                return $next($request);
            } else {
                return response()->json(['message' => 'User are not allow to login this page !'], 401);
            }
        } else {
            return response()->json(['message' => 'Bad Request !!!'], 500);
        }
    }
}
