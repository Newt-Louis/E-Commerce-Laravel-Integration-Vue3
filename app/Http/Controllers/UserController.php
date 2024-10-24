<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'avatar'])->get();

        return UserResource::collection($users);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validate = $request->validated();
        if ($validate) {
            $user = User::create($validate);
            /** @var \App\Models\User $user */
            $path = 'avatars/'.$user->name;
            Storage::makeDirectory($path);
            if (!$request->hasFile('avatar')) {
                Avatar::create([
                  'path' => $path,
                  'user_id' => $user->id,
                ]);
                Log::info('không xác nhận được file');
            } else {
                /** @var \App\Models\User $user */
                $validateFile = $request->validated(
                    [
                    'avatar' => 'image|max:2048',
                  ],
                    [
                    'avatar.image' => 'Avatar must be image file !',
                    'avatar.max' => 'Avatar maximum capacity is 2MB',
                  ]
                );
                if ($validateFile) {
                    $file = $request->file('avatar');
                    $fileName = uniqid().'_'. $file[0]->getClientOriginalName();
                    $filePath = Storage::putFileAs($path, $file[0], $fileName);
                    Avatar::create([
                      'path' => $path,
                      'filename' => $fileName,
                      'user_id' => $user->id
                    ]);
                    Log::info('Xác nhận được file');
                }
            }
        }

        return $this->index();
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
    // public function edit(User $user)
    // {
    //     //
    // }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::find($validatedData->id);
        $user->update($validatedData);
        if ($request->hasFile('avatar')) {
            $files = Storage::disk('local')->files('avatars/'.$user->name);
            if (count($files) > 0) {
                Storage::disk('local')->delete($files);
            }
            $file = $request->file('avatar');
            $fileName = uniqid().'_'.$file[0]->getClientOriginalName();
            $filePath = Storage::putFileAs('avatars/'.$user->name, $request->file('avatar'), $fileName);
            $avatar = Avatar::where('user_id', $user->id)->get();
            $avatar->update([
              'path' => 'avatars/'.$user->name,
              'filename' => $fileName,
            ]);
        }
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
