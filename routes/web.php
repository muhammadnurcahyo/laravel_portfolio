<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// login ke dashboard
Route::get('/auth/',  [authController::class, "index"])->name('login')->middleware('guest'); //untuk login
Route::get('/dashboard/',  function(){
    return "selamat datang " . Auth::user()->email . "  di halaman dashboard";
})->middleware('auth');


// login google
Route::get('/auth/redirect',  [authController::class, "redirect"])->middleware('guest');
Route::get('/auth/callback',  [authController::class, "callback"])->middleware('guest');
// akhir google

// ketika sudah login
Route::redirect('home', 'dashboard' );

// untuk logout
Route::get('/auth/logout',  [authController::class, "logout"]);





// note:
// arti middleware('guest') adalah untuk orang yg belum pernah login
// middleware('auth') untuk mencegah akses lgsg ke dashboard
// name('login') adalah lanjutan dari middleware untuk mengembalikan data yg belum login harus login dulu