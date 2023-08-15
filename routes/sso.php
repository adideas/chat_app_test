<?php

use App\Http\Controllers\sso\SSOController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SSO Routes
|--------------------------------------------------------------------------
|
| Here is where you can register SSO routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "sso" middleware group. Make something great!
|
*/

Route::post('/chat-app', [SSOController::class, 'oauthChatApp']);
