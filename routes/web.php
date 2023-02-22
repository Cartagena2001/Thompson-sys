<?php

use App\Http\Controllers\HomeController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/dashboard/marcas', App\Http\Controllers\MarcaController::class)->middleware('auth');
Route::resource('/dashboard/categorias', App\Http\Controllers\CategoriaController::class)->middleware('auth');
Route::resource('/dashboard/precios', App\Http\Controllers\PrecioController::class)->middleware('auth');
Route::resource('/dashboard/productos', App\Http\Controllers\ProductoController::class)->middleware('auth');
Route::resource('/dashboard/tienda', App\Http\Controllers\TiendaController::class)->middleware('auth');
