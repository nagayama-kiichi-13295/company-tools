<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MyPageController;

Route::get('/', function () {
    return redirect('/login');
});

// ログイン
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// 新規登録
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

// ログアウト
Route::post('/logout', [LoginController::class, 'logout']);

// ホーム
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');

// フリマ
Route::resource('products', ProductController::class)
    ->middleware('auth');

// 購入者フロー
Route::post('/products/{product}/purchase', [ProductController::class, 'purchase'])
    ->middleware('auth')->name('products.purchase');

Route::post('/products/{product}/complete', [ProductController::class, 'complete'])
    ->middleware('auth')->name('products.complete');

// 購入者チャット
Route::get('/products/{product}/messages', [MessageController::class, 'index'])
    ->middleware('auth')->name('messages.index');

Route::post('/products/{product}/messages', [MessageController::class, 'store'])
    ->middleware('auth')->name('messages.store');

// お気に入り登録
Route::get('/favorites', [FavoriteController::class, 'index'])
    ->middleware('auth')->name('favorites.index');
Route::post('/products/{product}/favorite', [FavoriteController::class, 'toggle'])
    ->middleware('auth')->name('favorites.toggle');

// MyPage
Route::get('/mypage', [MyPageController::class, 'index'])
    ->middleware('auth')->name('mypage.index');