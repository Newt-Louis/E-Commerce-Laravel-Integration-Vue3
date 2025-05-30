<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CapacityController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
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
    ]);
    Route::prefix('products')->group(function () {
        Route::apiResource('/', ProductController::class);
        Route::get('/origin', [ProductController::class,'originIndex']);
        Route::get('/supplier', [ProductDetailController::class, 'supplierIndex']);
        Route::post('/filter', [ProductController::class,'productFilter']);
    });
    // Route::get('/product/origin', [ProductController::class,'originIndex']);
    Route::get('/collections', [CollectionController::class,'index']);
    Route::post('/collections', [CollectionController::class,'store']);
    Route::delete('/collections/{collection}', [CollectionController::class,'destroy']);
    Route::get('/categories', [ItemTypeController::class,'index']);
    Route::post('/categories', [ItemTypeController::class,'store']);
    Route::get('/capacities', [CapacityController::class,'index']);
    Route::post('/capacities', [CapacityController::class,'store']);
    Route::get('/auth/admin-remember', function (Request $request) {
        $request->session()->regenerate();
        return $request->user();
    });
    Route::post('/admin-user/logout', [AuthController::class,'logout']);
    Route::post('/test-language-detection',AvatarController::class);
});
