<?php

use App\Http\Controllers\api\v1\MessageController;
use App\Http\Controllers\api\v1\MessageRelationPhoneController;
use App\Http\Controllers\api\v1\PhoneController;
use App\Http\Controllers\api\v1\ReportController;
use Illuminate\Support\Facades\Route;

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
Route::prefix('v1')->group(function () {
    Route::apiResource('message', MessageController::class);

    Route::get('message/{message}/phone', [MessageRelationPhoneController::class, 'getPhones']);
    Route::put('message/{message}/phone/{phone}', [MessageRelationPhoneController::class, 'addPhone']);
    Route::delete('message/{message}/phone/{phone}', [MessageRelationPhoneController::class, 'delPhone']);

    Route::apiResource('phone', PhoneController::class);
    Route::get('report', [ReportController::class, 'index']);
});
