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
Route::get('/create', [ProductsController::class, 'createView'])->middleware(['auth', 'verified'])->name('create');
Route::post('/create', [ProductsController::class, 'create'])->middleware(['auth', 'verified'])->name('create');
Route::get('/edit/{id}', [ProductsController::class, 'editView'])->middleware(['auth', 'verified'])->name('edit');
Route::post('/edit', [ProductsController::class, 'edit'])->middleware(['auth', 'verified'])->name('edit');
Route::delete('/delete/{id}', [ProductsController::class, 'delete'])->middleware(['auth', 'verified'])->name('delete');

require __DIR__ . '/auth.php';
