<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // something
        $user = User::all();
        return response()->json($user);
    }
    public function create()
    {
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
    public function login(Request $request)
    {
        $user = User::where('name', $request->usernameValue);
        if (!$user && !Hash::check($request->passwordValue, $user->password)) {
            throw ValidationException::withMessages([
              'message' => ['Username or Password is incorrect !!!'],
            ]);
        }
        $token = $user->createToken($user->name, ['server:create'])->plainTextToken;
        return response()->json(['token' => $token]);
        try {
            $user = User::findOrFail($id);
            return response($user)->json();
        } catch (ModelNotFoundException $e) {
            echo $e->getMessage();
        }
    }
    public function logout($id)
    {
    }
}
