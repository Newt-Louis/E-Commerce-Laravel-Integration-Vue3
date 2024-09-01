<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */
Route::get("/{any}", function () {
    return view("client");
})->where("any", "^(?!api\/|admin)[\/\w\.-]*");

Route::get("/admin/{any?}", function () {
    return view("admin");
})->where("any", ".*");

/* Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    // ... các route admin khác
}); */