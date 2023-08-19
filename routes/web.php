<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home/{page}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// User routes
Route::get('/user/view', [App\Http\Controllers\UserController::class, 'view'])->name('user.view');
Route::put('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');

// UserFavorite routes
Route::post('/user/favorite/post', [\App\Http\Controllers\UserFavoriteController::class, 'post'])->name('user.favorite.post');
Route::delete('/user/favorite/delete', [\App\Http\Controllers\UserFavoriteController::class, 'delete'])->name('user.favorite.delete');
