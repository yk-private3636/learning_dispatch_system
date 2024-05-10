<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Login\GeneralLoginController;
use App\Http\Controllers\Admin\Login\LoginController;


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

/** 一般ユーザー **/
Route::middleware(['guest'])->group(function() {
    /** ログイン **/
    Route::get('/', [GeneralLoginController::class, 'index']);
    Route::get('login', [GeneralLoginController::class, 'index'])->name('generalLogin');
    Route::post('authentication', [GeneralLoginController::class, 'authentication'])->name('generalUserAuth');

    Route::get('/login/forget', [UserController::class, 'loginForgetShow'])->name('login.forget.show');
    Route::post('/password/procedure/reset', [GeneralLoginController::class, 'passwordProcedureReset'])->name('password.procedure.reset');
    Route::get('/password/reset/{token}', [UserController::class, 'passwordResetShow'])->middleware('accurateToken')->name('password.reset.show');
    Route::put('/password/reset', [UserController::class, 'passwordReset'])->name('password.reset');
});

/** 管理者 **/
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
});

Route::middleware(['adminPrefixOnly'])->group(function(){
    Route::fallback([LoginController::class, 'index']);
});