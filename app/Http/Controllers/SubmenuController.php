<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Marca;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class SubmenuController extends Controller
{

    /**
     * Display a listing of registers.
     *
     * @return \Illuminate\Http\Response
     */
    public function getsubmenus(Request $request){

        if ($request->marcaSeleccionada == null) {
            return Response([
              'submenu' => '',
            ]);
        } else { 

            $marca = Marca::find($request->marcaSeleccionada);
            //dd($marca);

            $catasociadas = $marca->categoria()->withPivot('categoria_id')->get();//->pluck('id', 'nombre');//->toArray();
            //dd($catasociadas);

            return Response([
              'submenu' => $catasociadas,
            ]);
        }
    
    }


}
