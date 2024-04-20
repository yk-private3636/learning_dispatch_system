<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function() {
    /** 一般ユーザー **/
    Route::get('/', [GeneralLoginController::class, 'index']);
    Route::get('login', [GeneralLoginController::class, 'index'])->name('generalLogin');
    Route::post('authentication', [GeneralLoginController::class, 'authentication'])->name('generalUserAuth');

    /** 管理者 **/
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('login', [LoginController::class, 'index'])->name('login');
    });
});



// Route::fallback(fn() => );