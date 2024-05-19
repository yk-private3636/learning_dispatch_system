<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Login\PasswordResetController;
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
    Route::get('login', [GeneralLoginController::class, 'index'])->name('general.login');
    Route::post('authentication', [GeneralLoginController::class, 'authentication'])->name('general.auth');
    Route::get('login/o-auth/{driverName}', [GeneralLoginController::class, 'redirectToProvider'])->name('general.login.oAuth');
    Route::get('login/callback/{driverName}', [GeneralLoginController::class, 'handleProviderCallback'])->name('general.login.oAuth.callback');

    Route::get('/login/forget', [PasswordResetController::class, 'loginForgetShow'])->name('login.forget.show');
    Route::post('/procedure/password/reset', [PasswordResetController::class, 'procedure'])->name('procedure.password.reset');
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'passwordResetShow'])->middleware('accurateToken')->name('password.reset.show');
    Route::put('/password/reset', [PasswordResetController::class, 'passwordReset'])->name('password.reset');

    /** 会員登録 **/
    Route::resource('user', UserController::class)->only([
        'create', 'store'
    ]);
});

/** 管理者 **/
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
});

Route::middleware(['adminPrefixOnly'])->group(function() {
    Route::fallback([LoginController::class, 'index']);
});