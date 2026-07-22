<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\Admin\GroupTagController;

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

// お知らせ機能
Route::resource('announcements', AnnouncementController::class)
    ->middleware('auth');

// イベント機能
Route::resource('events', EventController::class)
    ->middleware('auth');

Route::post('/events/{event}/join', [EventController::class, 'toggleJoin'])
    ->middleware('auth')->name('events.join');

// 管理者画面
Route::get('/admin', [AdminController::class, 'dashboard'])
    ->middleware('auth')->name('admin.dashboard');

// 社内チャット
Route::get('/chats', [ChatController::class, 'index'])
    ->middleware('auth')->name('chats.index');

Route::get('/chats/{user}', [ChatController::class, 'show'])
    ->middleware('auth')->name('chats.show');

Route::post('/chats/{user}', [ChatController::class, 'store'])
    ->middleware('auth')->name('chats.store');

// メモ

Route::get('/notes/public', [NoteController::class, 'publicIndex'])
    ->middleware('auth')->name('notes.public');

Route::post('/notes/{note}/toggle-public', [NoteController::class, 'togglePublic'])
    ->middleware('auth')->name('notes.togglePublic');

Route::resource('notes', NoteController::class)
    ->middleware('auth');

// 管理者：グループタグ
Route::get('/admin/group-tags', [GroupTagController::class, 'index'])
    ->middleware('auth')->name('admin.group-tags.index');

Route::post('/admin/group-tags', [GroupTagController::class, 'store'])
    ->middleware('auth')->name('admin.group-tags.store');
    
Route::delete('/admin/group-tags/{groupTag}', [GroupTagController::class, 'destroy'])
    ->middleware('auth')->name('admin.group-tags.destroy');

Route::get('/admin/users/{user}/group-tags', [GroupTagController::class, 'assign'])
    ->middleware('auth')->name('admin.group-tags.assign');
Route::put('/admin/users/{user}/group-tags', [GroupTagController::class, 'updateAssignment'])
    ->middleware('auth')->name('admin.group-tags.update');
