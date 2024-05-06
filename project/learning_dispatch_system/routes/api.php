<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Login\LoginController;
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

Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/authenticating', [UserController::class, 'adminAuthenticating'])->name('authenticating');
    Route::post('/authentication', [LoginController::class, 'authentication'])->name('authentication');
    Route::post('/password/procedure/reset', [LoginController::class, 'passwordProcedureReset'])->name('password.procedure.reset');

    Route::get('password/reset/{token}', [UserController::class, 'adminPasswordResetAccurateToken'])->name('password.reset.accurate.token');
    Route::put('/password/reset', [UserController::class, 'adminPasswordReset'])->name('password.reset');

    Route::middleware('auth:sanctum')->group(function(){
    });
});
