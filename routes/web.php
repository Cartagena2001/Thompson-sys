<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PHPMailerController;
use Illuminate\Support\Facades\Route;
use App\Models\CMS;
use App\Models\Contacto;

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
    $cmsVars = CMS::get()->toArray();
    $contacto = new Contacto();
    
    return view('welcome',compact('cmsVars', 'contacto'));
})->name('inicio');

//Politica de Privacidad
Route::get('/politica-de-privacidad', function () {
    $cmsVars = CMS::get()->toArray();

    return view('polpriv', compact('cmsVars'));
});

//Terminos y Condiciones
Route::get('/terminos-y-condiciones', function () {
    $cmsVars = CMS::get()->toArray();
    
    return view('terms', compact('cmsVars'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::patch('/home', [App\Http\Controllers\PerfilController::class, 'loadInfo'])->name('forminscripc.load')->middleware('auth');

//api
Route::get('/api/getWeeklySales', [App\Http\Controllers\HomeController::class, 'getWeeklySales'])->name('api.getWeeklySales');
Route::get('/api/getSalesByDay', [App\Http\Controllers\HomeController::class, 'getSalesByDay'])->name('api.getSalesByDay');
Route::get('/api/getYearlySalesChart', [App\Http\Controllers\HomeController::class, 'getYearlySalesChart'])->name('api.getYearlySalesChart');
Route::get('/api/getMonthlySalesChart', [App\Http\Controllers\EstadisticasController::class, 'getMonthlySalesChart'])->name('api.getMonthlySalesChart');
Route::get('/api/getOrderStatusCount', [App\Http\Controllers\EstadisticasController::class, 'getOrderStatusCount'])->name('api.getOrderStatusCount');
Route::get('/api/getNewCustomersChart', [App\Http\Controllers\EstadisticasController::class, 'getNewCustomersChart'])->name('api.getNewCustomersChart');
Route::get('/api/getLowStockProductsChart', [App\Http\Controllers\EstadisticasController::class, 'getLowStockProductsChart'])->name('api.getLowStockProductsChart');
Route::get('/api/getTopStockProductsChart', [App\Http\Controllers\EstadisticasController::class, 'getTopStockProductsChart'])->name('api.getTopStockProductsChart');


//Rutas para el dashboard
Route::resource('/dashboard/marcas', App\Http\Controllers\MarcaController::class)->middleware('auth');
Route::resource('/dashboard/categorias', App\Http\Controllers\CategoriaController::class)->middleware('auth');
Route::post('producto.updateUbiBO', [App\Http\Controllers\ProductoController::class, 'updateUbiBO'])->name('producto.updateUbiBO')->middleware('auth');
Route::post('producto.updateUbiOF', [App\Http\Controllers\ProductoController::class, 'updateUbiOF'])->name('producto.updateUbiOF')->middleware('auth');
Route::resource('/dashboard/productos', App\Http\Controllers\ProductoController::class)->middleware('auth');


//Ruta para importar los productos
Route::post('/dashboard/productos/import', [App\Http\Controllers\ProductoController::class, 'import'])->name('productos.import')->middleware('auth');


//Rutas para ordenes
Route::resource('/dashboard/ordenes/oficina', App\Http\Controllers\OrdenesController::class)->middleware('auth');

Route::put('/dashboard/ordenes/oficina/enProceso/{id}', [App\Http\Controllers\OrdenesController::class, 'enProceso'])->name('ordenes.enProceso')->middleware('auth');
Route::put('/dashboard/ordenes/oficina/preparada/{id}', [App\Http\Controllers\OrdenesController::class, 'preparada'])->name('ordenes.preparada')->middleware('auth');
Route::put('/dashboard/ordenes/oficina/enEspera/{id}', [App\Http\Controllers\OrdenesController::class, 'enEspera'])->name('ordenes.espera')->middleware('auth');
Route::put('/dashboard/ordenes/oficina/pagada/{id}', [App\Http\Controllers\OrdenesController::class, 'pagada'])->name('ordenes.pagada')->middleware('auth');
Route::put('/dashboard/ordenes/oficina/finalizada/{id}', [App\Http\Controllers\OrdenesController::class, 'finalizada'])->name('ordenes.finalizada')->middleware('auth');
Route::put('/dashboard/ordenes/oficina/cancelada/{id}', [App\Http\Controllers\OrdenesController::class, 'cancelada'])->name('ordenes.cancelada')->middleware('auth');

Route::put('/dashboard/ordenes/oficina/uploadCif/{id}', [App\Http\Controllers\OrdenesController::class, 'upload'])->name('ordenecif.upload')->middleware('auth');
Route::put('/dashboard/ordenes/oficina/uploadHoj/{id}', [App\Http\Controllers\OrdenesController::class, 'uploadBod'])->name('ordenehoj.upload')->middleware('auth');

Route::resource('/dashboard/ordenes/bodega', App\Http\Controllers\OrdenesBodegaController::class)->middleware('auth');

//Rutas para aspirantes
Route::get('/dashboard/aspirantes', [App\Http\Controllers\AspirantesController::class, 'index'])->name('aspirantes.index')->middleware('auth');
Route::get('/dashboard/aspirantes/{id}', [App\Http\Controllers\AspirantesController::class, 'show'])->name('aspirantes.show')->middleware('auth');
Route::put('/dashboard/aspirantes/aprobado/{id}', [App\Http\Controllers\AspirantesController::class, 'aprobado'])->name('aspirantes.aprobado')->middleware('auth');
Route::put('/dashboard/aspirantes/rechazado/{id}', [App\Http\Controllers\AspirantesController::class, 'rechazado'])->name('aspirantes.rechazado')->middleware('auth');

Route::put('/dashboard/aspirantes/taller/{id}', [App\Http\Controllers\AspirantesController::class, 'taller'])->name('aspirantes.taller')->middleware('auth');
Route::put('/dashboard/aspirantes/distribuidor/{id}', [App\Http\Controllers\AspirantesController::class, 'distribuidor'])->name('aspirantes.distribuidor')->middleware('auth');
Route::put('/dashboard/aspirantes/preciocosto/{id}', [App\Http\Controllers\AspirantesController::class, 'precioCosto'])->name('aspirantes.pcosto')->middleware('auth');
Route::put('/dashboard/aspirantes/precioop/{id}', [App\Http\Controllers\AspirantesController::class, 'precioOP'])->name('aspirantes.pop')->middleware('auth');

Route::post('/dashboard/aspirantes/{id}', [App\Http\Controllers\AspirantesController::class, 'updateMarcas'])->name('aspirante.updmarcas')->middleware('auth');

//Rutas para aspirantes II
Route::get('/formulario-inscripcion', [App\Http\Controllers\PerfilController::class, 'indexInfoSent'])->name('info.enviada')->middleware('auth');
Route::patch('/formulario-inscripcion', [App\Http\Controllers\PerfilController::class, 'loadInfo'])->name('forminscrip.load')->middleware('auth');


//Rutas Contactos
Route::get('/dashboard/contactos', [App\Http\Controllers\ContactoController::class, 'index'])->name('contactos.index')->middleware('auth');
Route::get('/dashboard/contactos/{id}', [App\Http\Controllers\ContactoController::class, 'show'])->name('contactos.show')->middleware('auth');
Route::post('/', [App\Http\Controllers\ContactoController::class, 'store'])->name('contactos.store');


//Rutas para clientes
Route::get('/dashboard/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('clientes.index')->middleware('auth');
Route::get('/dashboard/clientes/{id}', [App\Http\Controllers\ClientesController::class, 'show'])->name('clientes.show')->middleware('auth');

Route::put('/dashboard/clientes/taller/{id}', [App\Http\Controllers\ClientesController::class, 'taller'])->name('clientes.taller')->middleware('auth');
Route::put('/dashboard/clientes/distribuidor/{id}', [App\Http\Controllers\ClientesController::class, 'distribuidor'])->name('clientes.distribuidor')->middleware('auth');
Route::put('/dashboard/clientes/preciocosto/{id}', [App\Http\Controllers\ClientesController::class, 'precioCosto'])->name('clientes.pcosto')->middleware('auth');
Route::put('/dashboard/clientes/precioop/{id}', [App\Http\Controllers\ClientesController::class, 'precioOP'])->name('clientes.pop')->middleware('auth');


//Marcas autorizadas
Route::get('/dashboard/permisos', [App\Http\Controllers\ClientesController::class, 'admPermMarca'])->name('clientes.marcasasoc')->middleware('auth');
Route::post('/dashboard/permisos', [App\Http\Controllers\ClientesController::class, 'updateMarcas'])->name('clientes.marcaUpdate')->middleware('auth');


//Rutas para tienda
Route::get('/dashboard/catalogo', [App\Http\Controllers\TiendaController::class, 'indexCat'])->name('catalogo.index')->middleware('auth');
//Route::get('/dashboard/catalogo/{producto:slug}', [App\Http\Controllers\TiendaController::class, 'showProd'])->name('catalogo.show')->middleware('auth');
Route::get('/dashboard/catalogo/{id}/{slug}', [App\Http\Controllers\TiendaController::class, 'showProd'])->name('catalogo.show')->middleware('auth');

Route::get('/dashboard/tienda', [App\Http\Controllers\TiendaController::class, 'index'])->name('tienda.index')->middleware('auth');
//Route::get('/dashboard/tienda/{producto:slug}', [App\Http\Controllers\TiendaController::class, 'show'])->name('tienda.show')->middleware('auth');
Route::get('/dashboard/tienda/{id}/{slug}', [App\Http\Controllers\TiendaController::class, 'show'])->name('tienda.show')->middleware('auth');

Route::get('/dashboard/compra-masiva', [App\Http\Controllers\TiendaController::class, 'showCat'])->name('compra.masiva.index')->middleware('auth');


//Rutas para el carrito
Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito.index')->middleware('auth');
Route::post('/carrito/add', [App\Http\Controllers\CarritoController::class, 'add'])->name('carrito.add')->middleware('auth');
Route::put('/carrito/update/{id}', [App\Http\Controllers\CarritoController::class, 'update'])->name('carrito.update')->middleware('auth');
Route::delete('/carrito/delete/{id}', [App\Http\Controllers\CarritoController::class, 'delete'])->name('carrito.delete')->middleware('auth');
Route::post('/carrito/clear', [App\Http\Controllers\CarritoController::class, 'clear'])->name('carrito.clear')->middleware('auth');

//Rutas para las ordenes del carrito
Route::get('/orden', [App\Http\Controllers\OrdenController::class, 'index'])->name('orden.index')->middleware('auth');
Route::post('/orden', [App\Http\Controllers\OrdenController::class, 'store'])->name('orden.store')->middleware('auth');

Route::post('/carrito/validar', [App\Http\Controllers\CarritoController::class, 'validar'])->name('carrito.validar')->middleware('auth');


//Rutas para el perfil
Route::get('/perfil/configuracion', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil.index')->middleware('auth');
Route::post('/perfil/configuracion', [App\Http\Controllers\PerfilController::class, 'passwordUpdate'])->name('perfil.password.update')->middleware('auth');
Route::patch('/perfil/configuracion', [App\Http\Controllers\PerfilController::class, 'update'])->name('perfil.update')->middleware('auth');


//Ordenes
Route::get('/perfil/ordenes', [App\Http\Controllers\PerfilController::class, 'ordenes'])->name('perfil.ordenes')->middleware('auth');
Route::get('/perfil/ordenes/detalle/{id}', [App\Http\Controllers\PerfilController::class, 'ordenes_detalle'])->name('perfil.orden.detalle')->middleware('auth');


//Rutas para los reportes
Route::get('/dashboard/reportes', [App\Http\Controllers\ReportesController::class, 'index'])->name('reportes.index')->middleware('auth');
Route::get('/dashboard/reportes/productos', [App\Http\Controllers\ReportesController::class, 'productos'])->name('reportes.productos')->middleware('auth');
Route::get('/dashboard/reportes/clientes', [App\Http\Controllers\ReportesController::class, 'clientes'])->name('reportes.clientes')->middleware('auth');
Route::get('/dashboard/reportes/marcas', [App\Http\Controllers\ReportesController::class, 'marcas'])->name('reportes.marcas')->middleware('auth');
Route::get('/dashboard/reportes/categorias', [App\Http\Controllers\ReportesController::class, 'categorias'])->name('reportes.categorias')->middleware('auth');
Route::get('/dashboard/reportes/ordenes', [App\Http\Controllers\ReportesController::class, 'ordenes'])->name('reportes.ordenes')->middleware('auth');

//Rutas para las estadisticas
Route::get('/dashboard/estadisticas', [App\Http\Controllers\EstadisticasController::class, 'index'])->name('estadisticas.index')->middleware('auth');


//Ruta para los manuales
Route::get('/dashboard/manuales', [App\Http\Controllers\ManualesController::class, 'index'])->name('manuales.index')->middleware('auth');


//Config CMS
Route::get('/configuracion/cms', [App\Http\Controllers\CMSController::class, 'index'])->name('cms.index')->middleware('auth');
Route::patch('/configuracion/cms', [App\Http\Controllers\CMSController::class, 'update'])->name('cms.update')->middleware('auth');

//Bitácora
Route::get('/configuracion/bitacora', [App\Http\Controllers\BitacoraController::class, 'index'])->name('bitacora')->middleware('auth');
Route::get('/configuracion/bitacora/evento/{id}', [App\Http\Controllers\BitacoraController::class, 'show'])->name('bitacora.evento.detalle')->middleware('auth');

//Config Usuarios (SuperAdmin)
Route::get('/configuracion/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index')->middleware('auth');
Route::get('/configuracion/users/create', [App\Http\Controllers\UsersController::class, 'create'])->name('users.create')->middleware('auth');
Route::patch('/configuracion/users/create', [App\Http\Controllers\UsersController::class, 'store'])->name('users.store')->middleware('auth');
Route::get('/configuracion/users/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('users.edit')->middleware('auth');

Route::put('/configuracion/users/edit/{id}', [App\Http\Controllers\UsersController::class, 'update'])->name('users.update')->middleware('auth');
Route::post('/configuracion/users/edit', [App\Http\Controllers\PerfilController::class, 'passwordUpdate'])->name('user.password.update')->middleware('auth');
















