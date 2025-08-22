<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;

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

Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');
Route::get('/search', [ItemController::class, 'search'])->name('item.search');

Route::middleware('auth')->group(
    function () {

        Route::get('/purchase/{item_id}', [ItemController::class, 'order'])->name('purchase.order');

        Route::get('/mypage/profile', [ProfileController::class, 'create'])->name('profile.create');
        Route::post('/mypage/profile', [ProfileController::class, 'store'])->name('profile.store');

        Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');

        Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');

        Route::post('/item/{item_id}/like', [ItemController::class, 'toggleLike'])->name('item.like');
    }
);
