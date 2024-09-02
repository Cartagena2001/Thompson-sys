<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\User;
use App\Models\EstadoProducto;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

use App\Models\CMS;


class TiendaController extends Controller
{

    /**
     * Display a listing of the resource. (Muestra el catalogo de productos - grid de compras)
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //verificar el usuario en sesión
        $usr = auth()->User();

        $marcasAuto = $usr->marcas;
        $marcasAutorizadas = str_split($marcasAuto);

        //Busca y ordena productos al entrar desde el menú
        //pero 1ro valida si es un cliente
        if ( $usr->rol_id == 2) {

            $productos = Producto::whereHas('categoria', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereHas('marca', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();

            $categoriasDisp = collect();
            
            foreach ($marcas as $brandA) {

                $categoriasDisp->push($brandA->categoria()->where('estado', '=', 'Activo')->withPivot('categoria_id')->get());

            }
            
            $categorias = $categoriasDisp->collapse();

        } else {

            //Si es superAdmin, admin o bodega

            $productos = Producto::whereHas('categoria', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereHas('marca', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();
            
            $categoriasDisp = collect();
            
            foreach ($marcas as $brandA) {

                $categoriasDisp->push($brandA->categoria()->where('estado', '=', 'Activo')->withPivot('categoria_id')->get());

            }
            
            $categorias = $categoriasDisp->collapse();

        }

        $cmsVars = CMS::get()->toArray();
        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento

        $categoriaActual = 0;
        $marcaActual = 0;

        /* FILTROS */
        
        //if ver si esta selecionado el filtro de marca y no categoria
        if( $request->input('marca') > 0 && $request->input('categoria') == 0 ){

            $marca_id = $request->input('marca'); //name devuelve el ID de la marca
            
            //devuelve los productos según la marca seleccionada en filtro

            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('marca_id', $marca_id)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            } else {

                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('marca_id', $marca_id)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);
            }

            $marcasSele = Marca::find($marca_id);

            $marcaActual = $marca_id;
            
            $categorias = $marcasSele->categoria()->where('estado', '=', 'Activo')->withPivot('categoria_id')->get();
            
            $categoriaActual = 0;

        } //if ver si esta selecionado el filtro de categoria y marca no
        elseif ( $request->input('categoria') > 0 && $request->input('marca') == 0 ){

            $categoria_id = $request->input('categoria'); //name devuelve el ID de categoría
            
            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                //devuelve los productos según la categoria seleccionada en filtro   
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('categoria_id', $categoria_id)->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);



            } else {

                //devuelve los productos según la categoria seleccionada en filtro   
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('categoria_id', $categoria_id)->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);
            }

            $categoria = Categoria::find($categoria_id);

            $categoriaActual = $categoria_id;

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();

            $marcaCorresp = Marca::whereIn('id', function($query) use ($categoriaActual){
                                $query->select('marca_id')->from('marca_cat')->where('categoria_id', '=', $categoriaActual); 
                            })->where('estado', '=', 'Activo')->firstOrFail();
            
            $marcaActual = $marcaCorresp->id;
             
        } //if ver si esta selecionado el filtro de marca y cambio de categoria o viceversa
        elseif ( $request->input('categoria') > 0 && $request->input('marca') > 0 ){

            $marca_id = $request->input('marca'); //name devuelve el ID de la marca

            $categoria_id = $request->input('categoria'); //name devuelve el ID de categoría

            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                //devuelve los productos según la marca seleccionada en filtro  
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('marca_id', $marca_id)->where('categoria_id', $categoria_id)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            } else {
 
                //devuelve los productos según la marca seleccionada en filtro  
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('marca_id', $marca_id)->where('categoria_id', $categoria_id)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);
            }
            
            $marca = Marca::find($marca_id);
            $categoria = Categoria::find($categoria_id);

            $marcaActual = $marca_id;
            $categoriaActual = $categoria_id;
            
            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();

            $categorias = Categoria::whereIn('id', function($query) use ($marcaActual){
                            $query->select('categoria_id')->from('marca_cat')->whereIn('marca_id', [$marcaActual]); 
                          })->where('estado', '=', 'Activo')->get();
             
        } elseif ( $request->input('categoria') == 0 && $request->input('marca') == 0) {
            //$marcas = Marca::all();
            //$categorias = Categoria::all();
            $categoriaActual = 0;
            $marcaActual = 0;  
        }
        //fin filtros cat y marca


        //if ver si esta selecionado el filtro busq por OEM
        if( $request->input('busq') != null || $request->input('busq') != '' ){

            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                $busqOEM = $request->input('busq');

                //devuelve los productos que coincidan con el OEM ingresado en filtro
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                            })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->where('oem', 'like', '%'.$busqOEM.'%')->paginate(1000000000);

            } else {

                $busqOEM = $request->input('busq');

                //devuelve los productos que coincidan con el OEM ingresado en filtro
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                            })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->where('oem', 'like', '%'.$busqOEM.'%')->paginate(1000000000);

            }    
        }//fin filtro busq OEM


        //if ver si esta selecionado el filtro busq por Nombre
        if( $request->input('busqN') != null || $request->input('busqN') != '' ){

            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                $busqNombre = $request->input('busqN');

                //devuelve los productos que coincidan con el nombre ingresado en filtro
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->where('nombre', 'like', '%'.$busqNombre.'%')->paginate(1000000000);

            } else {

                $busqNombre = $request->input('busqN');

                //devuelve los productos que coincidan con el OEM ingresado en filtro
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->where('nombre', 'like', '%'.$busqNombre.'%')->paginate(1000000000);

            }    
        }//fin filtro busq Nombre


        $categoriaActualname = null;
        //obtener el nombre de la categoria actual para mostrarlo en el titulo de la pagina
        
        if($categoriaActual != null){
            $categoriaActualname = Categoria::find($categoriaActual);
        }else{
            $categoriaActualname = "Todas";
        }
          
        //$estadoProductos = EstadoProducto::all();

        $productosDisponibles = Producto::whereHas('categoria', function($query){
                                    $query->where('estado', '=', 'Activo');
                                })->whereHas('marca', function($query){
                                    $query->where('estado', '=', 'Activo');
                                })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->get();

        return view('productos.productos-grid', compact('productos', 'productosDisponibles', 'categorias', 'marcas', 'marcaActual', 'categoriaActual', 'categoriaActualname', 'cat_mod', 'mant_mod', 'marcasAutorizadas'));

    }


/**
     * Display a listing of the resource (Muestra el catalogo de productos - no compra)
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCat(Request $request)
    {
        //verificar el usuario en sesión
        $usr = auth()->User();

        $marcasAuto = $usr->marcas;
        $marcasAutorizadas = str_split($marcasAuto);

        //Busca y ordena productos al entrar desde el menú
        //pero 1ro valida si es un cliente
        if ( $usr->rol_id == 2) {
            
            $productos = Producto::whereHas('categoria', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereHas('marca', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();

            $categoriasDisp = collect();
            
            foreach ($marcas as $brandA) {

                $categoriasDisp->push($brandA->categoria()->where('estado', '=', 'Activo')->withPivot('categoria_id')->get());

            }
            
            $categorias = $categoriasDisp->collapse();

        } else {

            //Si es superAdmin, admin o bodega

            $productos = Producto::whereHas('categoria', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereHas('marca', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();
            
            $categoriasDisp = collect();
            
            foreach ($marcas as $brandA) {

                $categoriasDisp->push($brandA->categoria()->where('estado', '=', 'Activo')->withPivot('categoria_id')->get());

            }
            
            $categorias = $categoriasDisp->collapse();
        }

        $cmsVars = CMS::get()->toArray();
        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento

        $categoriaActual = 0;
        $marcaActual = 0;

        /* FILTROS */

        //if ver si esta selecionado el filtro de marca y no categoria
        if( $request->input('marca') > 0 && $request->input('categoria') == 0 ){

            $marca_id = $request->input('marca'); //name devuelve el ID de la marca
            
            //devuelve los productos según la marca seleccionada en filtro

            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('marca_id', $marca_id)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            } else {

                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('marca_id', $marca_id)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);
            }

            $marcasSele = Marca::find($marca_id);

            $marcaActual = $marca_id;
            
            $categorias = $marcasSele->categoria()->where('estado', '=', 'Activo')->withPivot('categoria_id')->get();
            
            $categoriaActual = 0;

        } //if ver si está selecionado el filtro de categoria y marca no
        elseif ( $request->input('categoria') > 0 && $request->input('marca') == 0 ){

            $categoria_id = $request->input('categoria'); //name devuelve el ID de categoría
            
            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                //devuelve los productos según la categoria seleccionada en filtro   
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('categoria_id', $categoria_id)->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);



            } else {

                //devuelve los productos según la categoria seleccionada en filtro   
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('categoria_id', $categoria_id)->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);
            }

            $categoria = Categoria::find($categoria_id);

            $categoriaActual = $categoria_id;

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();

            $marcaCorresp = Marca::whereIn('id', function($query) use ($categoriaActual){
                                $query->select('marca_id')->from('marca_cat')->where('categoria_id', '=', $categoriaActual); 
                            })->where('estado', '=', 'Activo')->firstOrFail();
            
            $marcaActual = $marcaCorresp->id;
             
        } //if ver si esta selecionado el filtro de marca y cambio de categoria o viceversa
        elseif ( $request->input('categoria') > 0 && $request->input('marca') > 0 ){

            $marca_id = $request->input('marca'); //name devuelve el ID de la marca

            $categoria_id = $request->input('categoria'); //name devuelve el ID de categoría

            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                //devuelve los productos según la marca seleccionada en filtro  
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('marca_id', $marca_id)->where('categoria_id', $categoria_id)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            } else {
 
                //devuelve los productos según la marca seleccionada en filtro  
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->where('marca_id', $marca_id)->where('categoria_id', $categoria_id)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);
            }
            
            $marca = Marca::find($marca_id);
            $categoria = Categoria::find($categoria_id);

            $marcaActual = $marca_id;
            $categoriaActual = $categoria_id;
            
            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();

            $categorias = Categoria::whereIn('id', function($query) use ($marcaActual){
                            $query->select('categoria_id')->from('marca_cat')->whereIn('marca_id', [$marcaActual]); 
                          })->where('estado', '=', 'Activo')->get();
            
        } elseif ( $request->input('categoria') == 0 && $request->input('marca') == 0) {
            //$marcas = Marca::all();
            //$categorias = Categoria::all();
            $categoriaActual = 0;
            $marcaActual = 0;  
        }
        //fin filtros cat y marca


        //if ver si esta selecionado el filtro busq por OEM
        if( $request->input('busq') != null || $request->input('busq') != '' ){

            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                $busqOEM = $request->input('busq');

                //devuelve los productos que coincidan con el OEM ingresado en filtro
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                            })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->where('oem', 'like', '%'.$busqOEM.'%')->paginate(1000000000);

            } else {

                $busqOEM = $request->input('busq');

                //devuelve los productos que coincidan con el OEM ingresado en filtro
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                            })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->where('oem', 'like', '%'.$busqOEM.'%')->paginate(1000000000);

            }    
        }//fin filtro busq OEM


        //if ver si esta selecionado el filtro busq por Nombre
        if( $request->input('busqN') != null || $request->input('busqN') != '' ){

            //pero 1ro valida si es un cliente
            if ( $usr->rol_id == 2) {

                $busqNombre = $request->input('busqN');

                //devuelve los productos que coincidan con el nombre ingresado en filtro
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->where('nombre', 'like', '%'.$busqNombre.'%')->paginate(1000000000);

            } else {

                $busqNombre = $request->input('busqN');

                //devuelve los productos que coincidan con el OEM ingresado en filtro
                $productos = Producto::whereHas('categoria', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereHas('marca', function($query){
                                $query->where('estado', '=', 'Activo');
                             })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->where('nombre', 'like', '%'.$busqNombre.'%')->paginate(1000000000);

            }    
        }//fin filtro busq Nombre

        $categoriaActualname = null;
        //obtener el nombre de la categoria actual para mostrarlo en el titulo de la pagina

        if($categoriaActual != null){
            $categoriaActualname = Categoria::find($categoriaActual);
        }else{
            $categoriaActualname = "Todas";
        }
          
        //$estadoProductos = EstadoProducto::all();

        $productosDisponibles = Producto::whereHas('categoria', function($query){
                                    $query->where('estado', '=', 'Activo');
                                })->whereHas('marca', function($query){
                                    $query->where('estado', '=', 'Activo');
                                })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->get();

        return view('productos.catalogo', compact('productos', 'productosDisponibles', 'categorias', 'marcas', 'marcaActual', 'categoriaActual', 'categoriaActualname', 'cat_mod', 'mant_mod'));
    }

    /*
    public function showByCategoria(Request $request)
    {
        $categoria_id = $request->input('categoria');

        if ($categoria_id == 0) {
            $productos = Producto::all();
        } else {
           $productos = Producto::where('categoria_id', $categoria_id)->get(); 
        }
        
        return view('productos.productos-grid')->with('productos', $productos);
    }


    public function showByMarca(Request $request)
    {
        $categoria_id = $request->input('categoria');
        $productos = Producto::where('categoria_id', $categoria_id)->get();

        return view('productos.productos-grid')->with('productos', $productos);
    }
    */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource. (Muestra el producto singular de la tienda)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug) 
    {

        // $producto = Producto::find($id);
        //$producto = Producto::where('id', '=', $id)->get();
        $producto = Producto::where('id', $id)->firstOrFail();
        //$producto = Producto::where('slug', $slug)->firstOrFail();
        $cmsVars = CMS::get()->toArray();

        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento
        
        return view('productos.detalle-producto', compact('producto', 'cat_mod', 'mant_mod'));
    }


    /**
     * Display the specified resource. (Muestra el producto singular del catalogo)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showProd($id, $slug)
    {
        // $producto = Producto::find($id);
        $producto = Producto::where('id', $id)->firstOrFail();
        $cmsVars = CMS::get()->toArray();

        $cat_mod = $cmsVars[12]['parametro']; //modo catalogo
        $mant_mod = $cmsVars[13]['parametro']; //modo mantenimiento
        

        return view('productos.detalle-producto-cat', compact('producto', 'cat_mod', 'mant_mod'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //Despliega vista de compra masiva
    public function showCat(Request $request)
    {
        //verificar el usuario en sesión
        $usr = auth()->User();

        $marcasAuto = $usr->marcas;
        $marcasAutorizadas = str_split($marcasAuto);

        //Busca y ordena productos al entrar desde el menú
        //pero 1ro valida si es un cliente
        if ( $usr->rol_id == 2) {

            $productos = Producto::whereHas('categoria', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereHas('marca', function($query){
                $query->where('estado', '=', 'Activo');
            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('unidad_por_caja', '>', 0)->where('estado_producto_id', 1)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();

            $categoriasDisp = collect();
            
            foreach ($marcas as $brandA) {

                $categoriasDisp->push($brandA->categoria()->where('estado', '=', 'Activo')->withPivot('categoria_id')->get());

            }
            
            $categorias = $categoriasDisp->collapse();

            //dd($categorias);

            //$categorias = Categoria::where('estado', '=', 'Activo')->get();
            //$categorias = Categoria::all();
            //$categorias = Categoria::wherePivot('marca_id', 1)->get();

        } else {

            $productos = Producto::whereHas('marca', function($query){
                $query->where('estado_producto_id', 1);
            })->whereIn('marca_id', $marcasAutorizadas)->where('existencia', '>', 0)->where('imagen_1_src', '!=', null)->paginate(1000000000);

            $marcas = Marca::whereIn('id', $marcasAutorizadas)->where('estado', '=', 'Activo')->get();
            $categorias = Categoria::where('estado', '=', 'Activo')->get();

            //$productos = Producto::where('imagen_1_src', '!=', null)->paginate(1000000000);
            //$marcas = Marca::all();
            //$categorias = Categoria::all();

        }

        return view('productos.compra-masiva', compact('productos', 'categorias', 'marcas'));
    }


 
}
