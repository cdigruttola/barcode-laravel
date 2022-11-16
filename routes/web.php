<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', [ProductsController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/generate/{id}', [ProductsController::class, 'generate'])->middleware(['auth', 'verified'])->name('generate');
Route::get('/create', [ProductsController::class, 'create'])->middleware(['auth', 'verified'])->name('create');
Route::post('/create', [ProductsController::class, 'create'])->middleware(['auth', 'verified'])->name('create');

require __DIR__ . '/auth.php';
