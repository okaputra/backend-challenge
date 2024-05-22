<?php

use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransaksiController;

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

Route::post('/register', [AuthController::class, 'register'])->name('verification.send');
Route::post('/verify/email', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/login', [AuthController::class, 'login']);

// Socialite Auth
Route::get('/oauth/{social_media}', [SocialAuthController::class, 'redirect']);
Route::get('/oauth/{social_media}/callback', [SocialAuthController::class, 'callback']);

// Dashboard
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware(['auth:sanctum', 'verified']);

// Produk
Route::get('list/products', [ProductController::class, 'index']);
Route::resource('products', 'App\Http\Controllers\ProductController')->middleware(['auth:sanctum', 'verified', 'admin']);

// Transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->middleware(['auth:sanctum', 'verified', 'admin']);
Route::get('/transaksi/{user}', [TransaksiController::class, 'userTransaksi'])->middleware(['auth:sanctum', 'verified']);

