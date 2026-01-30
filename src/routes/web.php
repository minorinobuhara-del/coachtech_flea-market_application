<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\LoginController;

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

//Route::get('/', function () {
    //return view('welcome');
//});

//ログイン処理
Route::post('/login', [LoginController::class, 'login'])->name('login');

//商品一覧ページ
Route::get('/', [ItemController::class, 'index'])->name('items.index');

//商品検索機能
Route::get('/search', [ItemController::class, 'search'])->name('items.search');

//商品詳細ページ
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');


Route::middleware(['auth', 'verified'])->group(function () {

    // 会員画面 → プロフィール（マイページ表示）へ
    //Route::get('/mypage', function () {
        //return view('mypage', [
            //'user' => auth()->user(),
       //]);
    //})->name('mypage');
    Route::get('/mypage', [ProfileController::class, 'mypage'])
    ->middleware(['auth', 'verified'])
    ->name('mypage');


    //プロフィール編集

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

//商品出品ページ
Route::middleware('auth')->group(function () {
    Route::get('/sell', [ItemController::class, 'create'])->name('items.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');
});