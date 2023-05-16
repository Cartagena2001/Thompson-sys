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
Route::resource('/dashboard/productos', App\Http\Controllers\ProductoController::class)->middleware('auth');
//hacer ruta para el import de productos
Route::post('/dashboard/productos/import', [App\Http\Controllers\ProductoController::class, 'import'])->name('productos.import')->middleware('auth');
Route::resource('/dashboard/ordenes', App\Http\Controllers\OrdenesController::class)->middleware('auth');

// Route::resource('/dashboard/tienda', App\Http\Controllers\TiendaController::class)->middleware('auth');

Route::get('/dashboard/tienda', [App\Http\Controllers\TiendaController::class, 'index'])->name('tienda.index');

Route::get('/dashboard/tienda/{producto:slug}', [App\Http\Controllers\TiendaController::class, 'show'])->name('tienda.show');

Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito.index')->middleware('verified');
Route::post('/carrito/add', [App\Http\Controllers\CarritoController::class, 'add'])->name('carrito.add')->middleware('verified');
Route::put('/carrito/update/{id}', [App\Http\Controllers\CarritoController::class, 'update'])->name('carrito.update')->middleware('verified');
Route::delete('/carrito/delete/{id}', [App\Http\Controllers\CarritoController::class, 'delete'])->name('carrito.delete')->middleware('verified');
Route::post('/carrito/clear', [App\Http\Controllers\CarritoController::class, 'clear'])->name('carrito.clear')->middleware('verified');

Route::get('/orden', [App\Http\Controllers\OrdenController::class, 'index'])->name('orden.index')->middleware('verified');
Route::post('/orden', [App\Http\Controllers\OrdenController::class, 'store'])->name('orden.store')->middleware('verified');
Route::post('/carrito/validar', [App\Http\Controllers\CarritoController::class, 'validar'])->name('carrito.validar')->middleware('verified');


