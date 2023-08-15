<?php

use App\Http\Controllers\oauth\v1\OauthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| OAUTH Routes
|--------------------------------------------------------------------------
|
| Here is where you can register OAUTH routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "oauth" middleware group. Make something great!
|
*/
Route::prefix('v1')->group(function () {
    Route::get('login', [OauthController::class, 'login'])->middleware(['auth.basic.once']);
    Route::get('check', [OauthController::class, 'check'])->middleware('auth');
    Route::get('logout', [OauthController::class, 'logout'])->middleware('auth');
});
