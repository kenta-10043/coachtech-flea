<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;

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

Route::get('/mypage/profile', [ProfileController::class, 'create'])->name('profile.create');
Route::post('/mypage/profile', [ProfileController::class, 'store'])->name('profile.store');

Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');
