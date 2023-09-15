<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/books/1', function () {
    return view('detailbook');
})->name('detailbook');

Route::middleware('auth')->group(function () {
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/carts', [CartController::class, 'index'])
        ->name('cart.index');
});


require __DIR__ . '/auth.php';
