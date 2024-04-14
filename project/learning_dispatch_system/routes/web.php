<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Login\GeneralLoginContoroller;

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

Route::get('/', [GeneralLoginContoroller::class, 'index']);
Route::get('login', [GeneralLoginContoroller::class, 'index'])->name('generalLogin');
Route::post('authentication', [GeneralLoginContoroller::class, 'authentication'])->name('generalUserAuth');


// Route::fallback(fn() => );