<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::with('role')->get();

        return response()->json($user);
    }
    public function create(Request $request)
    {
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validate = $request->validated();
        if ($validate) {
            $user = User::created($validate);
            if (!$request->hasFile('avatar')) {
                /** @var \App\Models\User $user */
                $path = 'avatars/'.$user->name;
                Storage::makeDirectory($path);
                Avatar::created([
                  'path' => $path,
                  'user_id' => $user->id,
                ]);
            }
        }
        Log::info($request);
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
}
