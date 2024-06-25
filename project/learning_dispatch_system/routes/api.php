<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PartsGetManagementController;
use App\Http\Controllers\Admin\Login\LoginController;
use App\Http\Controllers\Admin\Login\PasswordResetController;

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
    /** 認証 **/
    Route::get('/authenticating', [AdminUserController::class, 'adminAuthenticating'])->name('authenticating');
    Route::post('/authentication', [LoginController::class, 'authentication'])->name('authentication');

    /** パスワード再設定 **/
    Route::post('/password/procedure/reset', [PasswordResetController::class, 'procedure'])->name('procedure.password.reset');
    Route::get('password/reset/{token}', [PasswordResetController::class, 'passwordResetAccurateToken'])->middleware('accurateToken')->name('password.reset.accurate.token');
    Route::put('/password/reset', [PasswordResetController::class, 'passwordReset'])->name('password.reset');

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/user-list/index', [AdminUserController::class, 'index'])->name('userList.index');

        Route::prefix('parts-data')->name('partsData.')->group(function() {
            Route::get('usage-status', [PartsGetManagementController::class, 'usageStatusGroup'])->name('usageStatus');
        });
    });
});

Route::prefix('general')->name('general.')->group(function() {
    /** ユーザーID自動作成 **/
    Route::get('/user-id/create', [UserController::class, 'userIdCreate'])->name('user.id.create');
});
