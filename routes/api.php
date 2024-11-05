<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
Route::post('/admin-user/login', [AuthController::class,'adminLogin'])->middleware('check.admin');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/roles', RoleController::class);
    Route::apiResources([
      'users' => UserController::class,
      'products' => ProductController::class
    ]);
    Route::get('/categories', [ItemTypeController::class]);
    Route::post('/categories', [ItemTypeController::class,'store']);
    Route::get('/auth/admin-remember', function (Request $request) {
        $request->session()->regenerate();
        return $request->user();
    });
    Route::post('/admin-user/logout', [AuthController::class,'logout']);
});
