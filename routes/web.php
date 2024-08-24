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


//Rutas Super Admin
Route::group(['middleware' => ['auth','superadmin']], function () {

    //Config CMS
    Route::get('/configuracion/cms', [App\Http\Controllers\CMSController::class, 'index'])->name('cms.index');
    Route::patch('/configuracion/cms', [App\Http\Controllers\CMSController::class, 'update'])->name('cms.update');

    //Config Usuarios
    Route::get('/configuracion/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
    Route::get('/configuracion/users/create', [App\Http\Controllers\UsersController::class, 'create'])->name('users.create');
    Route::patch('/configuracion/users/create', [App\Http\Controllers\UsersController::class, 'store'])->name('users.store');
    Route::get('/configuracion/users/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('users.edit');
    Route::put('/configuracion/users/edit/{id}', [App\Http\Controllers\UsersController::class, 'update'])->name('users.update');
    Route::post('/configuracion/users/edit/{id}', [App\Http\Controllers\UsersController::class, 'passwordUpdate'])->name('user.password.update');

    //Test para enviar correos
    Route::get('/configuracion/email-test',[PHPMailerController::class, 'index'])->name('send.php.mailer');
    Route::post('/configuracion/send',[PHPMailerController::class, 'sendEmail'])->name('send.php.mailer.submit')->middleware('verified');

    //Pop-up

    //Bitácora
    Route::get('/configuracion/bitacora', [App\Http\Controllers\BitacoraController::class, 'index'])->name('bitacora');
    Route::get('/configuracion/bitacora/evento/{id}', [App\Http\Controllers\BitacoraController::class, 'show'])->name('bitacora.evento.detalle');


});


//Rutas Super Admin, Admin
Route::group(['middleware' => ['auth','admin']], function () {

    //Estadisticas
    Route::get('/dashboard/estadisticas', [App\Http\Controllers\EstadisticasController::class, 'index'])->name('estadisticas.index');

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
    Route::resource('/dashboard/marcas', App\Http\Controllers\MarcaController::class);
    Route::resource('/dashboard/categorias', App\Http\Controllers\CategoriaController::class);
    Route::resource('/dashboard/productos', App\Http\Controllers\ProductoController::class);

    //Ruta para importar los productos
    Route::post('/dashboard/productos/import', [App\Http\Controllers\ProductoController::class, 'import'])->name('productos.import');

    Route::post('producto.updateUbiBO', [App\Http\Controllers\ProductoController::class, 'updateUbiBO'])->name('producto.updateUbiBO');
    Route::post('producto.updateUbiOF', [App\Http\Controllers\ProductoController::class, 'updateUbiOF'])->name('producto.updateUbiOF');




    //Rutas gestionar Contactos
    Route::get('/dashboard/contactos', [App\Http\Controllers\ContactoController::class, 'index'])->name('contactos.index');
    Route::get('/dashboard/contactos/{id}', [App\Http\Controllers\ContactoController::class, 'show'])->name('contactos.show');


    //Rutas para consultar reportes
    Route::get('/dashboard/reportes', [App\Http\Controllers\ReportesController::class, 'index'])->name('reportes.index');
    Route::get('/dashboard/reportes/productos', [App\Http\Controllers\ReportesController::class, 'productos'])->name('reportes.productos');
    Route::get('/dashboard/reportes/clientes', [App\Http\Controllers\ReportesController::class, 'clientes'])->name('reportes.clientes');
    Route::get('/dashboard/reportes/marcas', [App\Http\Controllers\ReportesController::class, 'marcas'])->name('reportes.marcas');
    Route::get('/dashboard/reportes/categorias', [App\Http\Controllers\ReportesController::class, 'categorias'])->name('reportes.categorias');
    Route::get('/dashboard/reportes/ordenes', [App\Http\Controllers\ReportesController::class, 'ordenes'])->name('reportes.ordenes');

    //Marcas autorizadas
    Route::get('/dashboard/permisos', [App\Http\Controllers\ClientesController::class, 'admPermMarca'])->name('clientes.marcasasoc');
    Route::post('/dashboard/permisos', [App\Http\Controllers\ClientesController::class, 'updateMarcas'])->name('clientes.marcaUpdate');
    Route::post('/dashboard/clientes/mod/{id}', [App\Http\Controllers\ClientesController::class, 'actModCat'])->name('clientes.actModCat');

    //Rutas para gestionar ordenes
    Route::resource('/dashboard/ordenes/oficina', App\Http\Controllers\OrdenesController::class);
    Route::put('/dashboard/ordenes/oficina/enProceso/{id}', [App\Http\Controllers\OrdenesController::class, 'enProceso'])->name('ordenes.enProceso');
    Route::put('/dashboard/ordenes/oficina/preparada/{id}', [App\Http\Controllers\OrdenesController::class, 'preparada'])->name('ordenes.preparada');
    Route::put('/dashboard/ordenes/oficina/aPagar/{id}', [App\Http\Controllers\OrdenesController::class, 'aPagar'])->name('ordenes.pagar');
    Route::put('/dashboard/ordenes/oficina/pagada/{id}', [App\Http\Controllers\OrdenesController::class, 'pagada'])->name('ordenes.pagada');
    Route::put('/dashboard/ordenes/oficina/finalizada/{id}', [App\Http\Controllers\OrdenesController::class, 'finalizada'])->name('ordenes.finalizada');
    Route::put('/dashboard/ordenes/oficina/cancelada/{id}', [App\Http\Controllers\OrdenesController::class, 'cancelada'])->name('ordenes.cancelada');
    Route::put('/dashboard/ordenes/oficina/uploadCif/{id}', [App\Http\Controllers\OrdenesController::class, 'upload'])->name('ordenecif.upload');
    Route::put('/dashboard/ordenes/oficina/uploadHoj/{id}', [App\Http\Controllers\OrdenesController::class, 'uploadH'])->name('ordenehoj.upload');
    Route::put('/dashboard/ordenes/oficina/uploadCompP/{id}', [App\Http\Controllers\OrdenesController::class, 'uploadComp'])->name('compPago.upload');

    //Rutas para gestionar clientes
    Route::get('/dashboard/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('clientes.index');
    Route::get('/dashboard/clientes/{id}', [App\Http\Controllers\ClientesController::class, 'show'])->name('clientes.show');

    Route::put('/dashboard/clientes/taller/{id}', [App\Http\Controllers\ClientesController::class, 'taller'])->name('clientes.taller');
    Route::put('/dashboard/clientes/distribuidor/{id}', [App\Http\Controllers\ClientesController::class, 'distribuidor'])->name('clientes.distribuidor');
    Route::put('/dashboard/clientes/preciocosto/{id}', [App\Http\Controllers\ClientesController::class, 'precioCosto'])->name('clientes.pcosto');
    Route::put('/dashboard/clientes/precioop/{id}', [App\Http\Controllers\ClientesController::class, 'precioOP'])->name('clientes.pop');

    //Rutas para gestionar aspirantes
    Route::get('/dashboard/aspirantes', [App\Http\Controllers\AspirantesController::class, 'index'])->name('aspirantes.index');
    Route::get('/dashboard/aspirantes/{id}', [App\Http\Controllers\AspirantesController::class, 'show'])->name('aspirantes.show');
    Route::put('/dashboard/aspirantes/aprobado/{id}', [App\Http\Controllers\AspirantesController::class, 'aprobado'])->name('aspirantes.aprobado');
    Route::put('/dashboard/aspirantes/rechazado/{id}', [App\Http\Controllers\AspirantesController::class, 'rechazado'])->name('aspirantes.rechazado');
    Route::put('/dashboard/aspirantes/taller/{id}', [App\Http\Controllers\AspirantesController::class, 'taller'])->name('aspirantes.taller');
    Route::put('/dashboard/aspirantes/distribuidor/{id}', [App\Http\Controllers\AspirantesController::class, 'distribuidor'])->name('aspirantes.distribuidor');
    Route::put('/dashboard/aspirantes/preciocosto/{id}', [App\Http\Controllers\AspirantesController::class, 'precioCosto'])->name('aspirantes.pcosto');
    Route::put('/dashboard/aspirantes/precioop/{id}', [App\Http\Controllers\AspirantesController::class, 'precioOP'])->name('aspirantes.pop');

    Route::post('/dashboard/aspirantes/{id}', [App\Http\Controllers\AspirantesController::class, 'updateMarcas'])->name('aspirante.updmarcas');
    Route::post('/dashboard/aspirantes/mod/{id}', [App\Http\Controllers\AspirantesController::class, 'actModCat'])->name('aspirante.actModCat');


    //Ruta para acceder archivos privados (ver)
    Route::get('/file/serve/pdf/{data}', [App\Http\Controllers\FileAccessController::class, 'servePDF']);

    //Ruta para acceder archivos privados (descargar)
    //Route::get('/file/download/{file}', [App\Http\Controllers\FileAccessController::class, 'download']);
    

    //Ruta para consultar submenu categorias de productos
    Route::post('/submenucatmarca', [App\Http\Controllers\SubmenuController::class, 'getsubmenus']);

    Route::get('/dashboard/aspirantes', )->name('aspirantes.index');

});


//Rutas SuperAdmin, Admin, Bodega y Cliente
Route::group(['middleware' => ['auth']], function () {

    //Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Ruta cargar info aspirante a cliente
    //Route::patch('/home', [App\Http\Controllers\PerfilController::class, 'loadInfo'])->name('forminscripc.load');
    Route::post('/home', [App\Http\Controllers\PerfilController::class, 'loadInfo']);

    //Rutas para el perfil
    Route::get('/perfil/configuracion', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil.index');
    Route::post('/perfil/configuracion', [App\Http\Controllers\PerfilController::class, 'passwordUpdate'])->name('perfil.password.update');
    Route::patch('/perfil/configuracion', [App\Http\Controllers\PerfilController::class, 'update'])->name('perfil.update');

    //Ruta para los manuales
    Route::get('/dashboard/manuales', [App\Http\Controllers\ManualesController::class, 'index'])->name('manuales.index');


    //Rutas para aspirantes (formulario)
    Route::get('/formulario-inscripcion', [App\Http\Controllers\PerfilController::class, 'indexInfoSent'])->name('info.enviada');
    
    Route::post('/formulario-inscripcion', [App\Http\Controllers\PerfilController::class, 'loadInfo'])->name('forminscrip.load');

    //Rutas para tienda y catalogo
    Route::get('/dashboard/catalogo', [App\Http\Controllers\TiendaController::class, 'indexCat'])->name('catalogo.index');
    Route::get('/dashboard/catalogo/{id}/{slug}', [App\Http\Controllers\TiendaController::class, 'showProd'])->name('catalogo.show');

    Route::get('/dashboard/tienda', [App\Http\Controllers\TiendaController::class, 'index'])->name('tienda.index');
    Route::get('/dashboard/tienda/{id}/{slug}', [App\Http\Controllers\TiendaController::class, 'show'])->name('tienda.show');

    Route::get('/dashboard/compra-masiva', [App\Http\Controllers\TiendaController::class, 'showCat'])->name('compra.masiva.index');

    //Rutas para interacion con el carrito
    Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/add', [App\Http\Controllers\CarritoController::class, 'add'])->name('carrito.add');
    Route::put('/carrito/update/{id}', [App\Http\Controllers\CarritoController::class, 'update'])->name('carrito.update');
    Route::delete('/carrito/delete/{id}', [App\Http\Controllers\CarritoController::class, 'delete'])->name('carrito.delete');
    Route::post('/carrito/clear', [App\Http\Controllers\CarritoController::class, 'clear'])->name('carrito.clear');

    //Rutas para solicitar orden y consultarla antes de pago (proceso de compra en tienda)
    Route::get('/orden', [App\Http\Controllers\OrdenController::class, 'index'])->name('orden.index')->middleware('auth');
    Route::post('/orden', [App\Http\Controllers\OrdenController::class, 'store'])->name('orden.store')->middleware('auth');

    //Validaciones previas del carrito de compras antes de finalizar la orden
    Route::post('/carrito/validar', [App\Http\Controllers\CarritoController::class, 'validar'])->name('carrito.validar')->middleware('auth');

    //Ruta para acceder archivos privados (ver)
    Route::get('/file/serve/cifs/{data}', [App\Http\Controllers\FileAccessController::class, 'serveCif']);
    Route::get('/file/serve/comp_pago/{data}', [App\Http\Controllers\FileAccessController::class, 'serveCp']);
    Route::get('/file/serve/hojas_sal/{data}', [App\Http\Controllers\FileAccessController::class, 'serveHs']); 

});


//Rutas Clientes
Route::group(['middleware' => ['auth', 'client']], function () {

    //Ordenes del Cliente
    Route::get('/perfil/ordenes', [App\Http\Controllers\PerfilController::class, 'ordenes'])->name('perfil.ordenes');
    Route::get('/perfil/ordenes/detalle/{id}', [App\Http\Controllers\PerfilController::class, 'ordenes_detalle'])->name('perfil.orden.detalle');   

});


//Rutas Bodega
Route::group(['middleware' => ['auth', 'bodega']], function () {

    //Rutas de órdenes para bodega
    Route::resource('/dashboard/ordenes/bodega', App\Http\Controllers\OrdenesBodegaController::class);
    Route::put('/dashboard/ordenes/bodega/preparada/{id}', [App\Http\Controllers\OrdenesBodegaController::class, 'preparada'])->name('ordenes.preparadaB');
    Route::put('/dashboard/ordenes/bodega/finalizada/{id}', [App\Http\Controllers\OrdenesBodegaController::class, 'finalizada'])->name('ordenes.finalizadaB');
    Route::put('/dashboard/ordenes/bodega/uploadHoj/{id}', [App\Http\Controllers\OrdenesBodegaController::class, 'uploadBod'])->name('ordenehojB.uploadB');

    //Actualizar cant despachada y # de bultos
    Route::post('producto.updateCantD', [App\Http\Controllers\ProductoController::class, 'updateCantD'])->name('producto.updateCantD');
    Route::post('producto.updateNb', [App\Http\Controllers\ProductoController::class, 'updateNb'])->name('producto.updateNb');

});


//Rutas Contactos (enviar formulario)
Route::post('/', [App\Http\Controllers\ContactoController::class, 'store'])->name('contactos.store');



