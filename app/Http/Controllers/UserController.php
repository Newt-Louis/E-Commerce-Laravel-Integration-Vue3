<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'avatar'])->paginate(5);
        UserResource::withoutWrapping();
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
            Storage::disk('public')->makeDirectory($path);
            if (!$request->hasFile('avatar')) {
                Avatar::create([
                  'path' => $path,
                  'user_id' => $user->id,
                ]);
            } else {
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
                    $filePath = Storage::disk('public')->putFileAs($path, $file[0], $fileName);
                    Avatar::create([
                      'path' => $path,
                      'filename' => $fileName,
                      'user_id' => $user->id
                    ]);
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
    public function update(UpdateUserRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $user = User::find($id);
        $avatar = $user->avatar;
        if (!empty($request->input('password'))) {
            $validatedData['password'] = $request->input('password');
        }
        if ($request->hasFile('avatar')) {
            $files = Storage::disk('public')->files($avatar->path);
            if (count($files) > 0) {
                Storage::disk('public')->delete($files);
            }
            $file = $request->file('avatar');
            $fileName = uniqid().'_'.$file[0]->getClientOriginalName();
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            /* Cause Intelephense don't understand method disk will return FilesystemAdapter */
            $disk = Storage::disk('public');
            $disk->putFileAs($avatar->path, $file[0], $fileName);
            $avatar->update([
              'filename' => $fileName,
            ]);
        }
        if ($user->name !== $validatedData['name']) {
            $oldPath = $avatar->path;
            $newPath = dirname($oldPath)."/".$validatedData['name'];
            Storage::disk('public')->move($oldPath, $newPath);
            $avatar->update([
              'path' => $newPath,
            ]);
        }
        $user->update($validatedData);
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = User::find($id);
        $user->delete();
        $user->avatar()->delete();
        return $this->index();
    }
}
