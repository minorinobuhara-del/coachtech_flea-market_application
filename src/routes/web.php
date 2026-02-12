<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseAddressController;

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

//商品一覧ページ
Route::get('/', [ItemController::class, 'index'])->name('items.index');

//商品検索機能
Route::get('/search', [ItemController::class, 'search'])->name('items.search');

//商品詳細ページ
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

//いいね機能
Route::post('/item/{item}/like', [LikeController::class, 'toggle'])->middleware('auth')->name('item.like');

//コメント機能
Route::post('/item/{item}/comment', [CommentController::class, 'store'])
    ->name('item.comment')->middleware('auth');


Route::middleware(['auth', 'verified'])->group(function () {

    // 会員画面 → プロフィール（マイページ表示）へ
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

//購入ページ
Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item}', [PurchaseController::class, 'show'])
        ->name('purchase.show');

    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])
        ->name('purchase.store');
});

//カード決済処理
Route::get('/payment/{item}', [PaymentController::class, 'create'])
    ->middleware('auth')
    ->name('payment.create');


//購入先住所入力・編集ページ
Route::middleware('auth')->group(function () {

    Route::get('/purchase/address/{item}',
        [PurchaseAddressController::class, 'edit']
    )->name('purchase.address.edit');

    Route::post('/purchase/address/{item}',
        [PurchaseAddressController::class, 'update']
    )->name('purchase.address.update');

});