<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatusController;

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
// public routes
Route::post('register', [AuthController::class, "register"])->name('register');
Route::post('login', [AuthController::class, "login"])->name('login');


// protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('status', StatusController::class);
    Route::post('logout', [AuthController::class, "logout"]);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     Route::apiResource('status', StatusController::class);
// });