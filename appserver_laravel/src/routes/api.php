<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\Authenticate;

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

Route::get("/auth/google", [AuthController::class, 'redirectToGoogle']);
Route::get("/auth/google/callback", [AuthController::class, 'handleGoogleCallback']);

Route::middleware([Authenticate::class])->group(function() {
});

Route::post("/auth/createJwt", [AuthController::class, 'createJwt']);
Route::get("/auth/validateJwt", [AuthController::class, 'validateJwt']);

Route::get("/auth/check-auth", [AuthController::class, 'checkAuth']);

