<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/mypage', fn () => view('mypage'));

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});

Route::middleware(['auth', 'verified'])->get('/redirect', function () {
    if (
        empty(auth()->user()->postcode) ||
        empty(auth()->user()->address)
    ) {
        return redirect()->route('profile.edit');
    }

    return redirect('/mypage');
});
