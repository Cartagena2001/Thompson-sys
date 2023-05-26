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

//Rutas para el dashboard
Route::resource('/dashboard/marcas', App\Http\Controllers\MarcaController::class)->middleware('auth');
Route::resource('/dashboard/categorias', App\Http\Controllers\CategoriaController::class)->middleware('auth');
Route::resource('/dashboard/productos', App\Http\Controllers\ProductoController::class)->middleware('auth');

//Ruta para importar los productos
Route::post('/dashboard/productos/import', [App\Http\Controllers\ProductoController::class, 'import'])->name('productos.import')->middleware('auth');

//Rutas para ordenes
Route::resource('/dashboard/ordenes', App\Http\Controllers\OrdenesController::class)->middleware('auth');
Route::put('/dashboard/ordenes/enProceso/{id}', [App\Http\Controllers\OrdenesController::class, 'enProceso'])->name('ordenes.enProceso')->middleware('auth');
Route::put('/dashboard/ordenes/finalizada/{id}', [App\Http\Controllers\OrdenesController::class, 'finalizada'])->name('ordenes.finalizada')->middleware('auth');
Route::put('/dashboard/ordenes/cancelada/{id}', [App\Http\Controllers\OrdenesController::class, 'cancelada'])->name('ordenes.cancelada')->middleware('auth');

//Rutas para aspirantes
Route::get('/dashboard/aspirantes', [App\Http\Controllers\AspirantesController::class, 'index'])->name('aspirantes.index')->middleware('auth');
Route::get('/dashboard/aspirantes/{id}', [App\Http\Controllers\AspirantesController::class, 'show'])->name('aspirantes.show')->middleware('auth');
Route::put('/dashboard/aspirantes/aprovado/{id}', [App\Http\Controllers\AspirantesController::class, 'aprovado'])->name('aspirantes.aprovado')->middleware('auth');
Route::put('/dashboard/aspirantes/rechazado/{id}', [App\Http\Controllers\AspirantesController::class, 'rechazado'])->name('aspirantes.rechazado')->middleware('auth');

//Rutas para clientes
Route::get('/dashboard/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('clientes.index')->middleware('auth');
Route::get('/dashboard/clientes/{id}', [App\Http\Controllers\ClientesController::class, 'show'])->name('clientes.show')->middleware('auth');
Route::put('/dashboard/clientes/cobre/{id}', [App\Http\Controllers\ClientesController::class, 'cobre'])->name('clientes.cobre')->middleware('auth');
Route::put('/dashboard/clientes/plata/{id}', [App\Http\Controllers\ClientesController::class, 'plata'])->name('clientes.plata')->middleware('auth');
Route::put('/dashboard/clientes/oro/{id}', [App\Http\Controllers\ClientesController::class, 'oro'])->name('clientes.oro')->middleware('auth');
Route::put('/dashboard/clientes/platino/{id}', [App\Http\Controllers\ClientesController::class, 'platino'])->name('clientes.platino')->middleware('auth');
Route::put('/dashboard/clientes/diamante/{id}', [App\Http\Controllers\ClientesController::class, 'diamante'])->name('clientes.diamante')->middleware('auth');
Route::put('/dashboard/clientes/taller/{id}', [App\Http\Controllers\ClientesController::class, 'taller'])->name('clientes.taller')->middleware('auth');
Route::put('/dashboard/clientes/distribucion/{id}', [App\Http\Controllers\ClientesController::class, 'distribucion'])->name('clientes.distribucion')->middleware('auth');


//Rutas para tienda
Route::get('/dashboard/tienda', [App\Http\Controllers\TiendaController::class, 'index'])->name('tienda.index');
Route::get('/dashboard/tienda/{producto:slug}', [App\Http\Controllers\TiendaController::class, 'show'])->name('tienda.show');

//Rutas para el carrito
Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito.index')->middleware('verified');
Route::post('/carrito/add', [App\Http\Controllers\CarritoController::class, 'add'])->name('carrito.add')->middleware('verified');
Route::put('/carrito/update/{id}', [App\Http\Controllers\CarritoController::class, 'update'])->name('carrito.update')->middleware('verified');
Route::delete('/carrito/delete/{id}', [App\Http\Controllers\CarritoController::class, 'delete'])->name('carrito.delete')->middleware('verified');
Route::post('/carrito/clear', [App\Http\Controllers\CarritoController::class, 'clear'])->name('carrito.clear')->middleware('verified');

//Rutas para las ordenes del carrito
Route::get('/orden', [App\Http\Controllers\OrdenController::class, 'index'])->name('orden.index')->middleware('verified');
Route::post('/orden', [App\Http\Controllers\OrdenController::class, 'store'])->name('orden.store')->middleware('verified');
Route::post('/carrito/validar', [App\Http\Controllers\CarritoController::class, 'validar'])->name('carrito.validar')->middleware('verified');


//Rutas para el perfil
Route::get('/perfil/configuracion', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil.index')->middleware('verified');
Route::patch('/perfil/configuracion', [App\Http\Controllers\PerfilController::class, 'update'])->name('perfil.update')->middleware('verified');
Route::get('/perfil/ordenes', [App\Http\Controllers\PerfilController::class, 'ordenes'])->name('perfil.ordenes')->middleware('verified');
Route::get('/perfil/ordenes/detalle/{id}', [App\Http\Controllers\PerfilController::class, 'ordenes_detalle'])->name('perfil.orden.detalle')->middleware('verified');


