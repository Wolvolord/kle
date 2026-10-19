<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Kayıt Ol
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

// Giriş Yap
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Çıkış
Route::post('/logout', [AuthController::class, 'logout']);

// Anasayfa (sadece giriş yapanlar)
Route::get('/', function () {
    return view('home');
})->middleware('auth');
