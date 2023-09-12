<?php
namespace App\Http\Controllers;

use App\Models\CMS;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class CMSController
 * @package App\Http\Controllers
 */
class CMSController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $cmsVars = CMS::get()->toArray();
        
        return view('config.editCMS', compact('cmsVars'));
    }

    public function create() {

        $cmsVars = CMS::get()->toArray();

        return view('config.index', compact('cmsVars'));
    }

    // funcion para actualizar la informacion de la página
    public function update(Request $request)
    {

        //validar campos
        $request->validate([
            'numWhat' => 'required',
            'numWhatURL' => 'required',
            'numFijo' => 'required',
            'numFijoURL' => 'required',
            'fbURL' => 'required',
            'igURL' => 'required',
            'dirOF' => 'required',
            'horarioOF' => 'required',
            'dirBod' => 'required',
            'horarioBod' => 'required',
            'corrContacto' => 'required',
            'corrOrden' => 'required',
            'catalogMod' => 'required',
            'mantMod' => 'required'
        ]);

        //guardar parametros CMS

        $numWhat = CMS::find(1);
        $numWhat->parametro = $request->get('numWhat');
        $numWhat->update();

        $numWhatURL = CMS::find(2);
        $numWhatURL->parametro = $request->get('numWhatURL');
        $numWhatURL->update();

        $numFijo = CMS::find(3);
        $numFijo->parametro = $request->get('numFijo');
        $numFijo->update();

        $numFijoURL = CMS::find(4);
        $numFijoURL->parametro = $request->get('numFijoURL');
        $numFijoURL->update();

        $fbURL = CMS::find(5);
        $fbURL->parametro = $request->get('fbURL');
        $fbURL->update();

        $igURL = CMS::find(6);
        $igURL->parametro = $request->get('igURL');
        $igURL->update();

        $dirOF = CMS::find(7);
        $dirOF->parametro = $request->get('dirOF');
        $dirOF->update();

        $horarioOF = CMS::find(8);
        $horarioOF->parametro = $request->get('horarioOF');
        $horarioOF->update();

        $dirBod = CMS::find(9);
        $dirBod->parametro = $request->get('dirBod');
        $dirBod->update();

        $horarioBod = CMS::find(10);
        $horarioBod->parametro = $request->get('horarioBod');
        $horarioBod->update();

        $corrContacto = CMS::find(11);
        $corrContacto->parametro = $request->get('corrContacto');
        $corrContacto->update();

        $corrOrden = CMS::find(12);
        $corrOrden->parametro = $request->get('corrOrden');
        $corrOrden->update();

        $catalogMod = CMS::find(13);
        $catalogMod->parametro = $request->get('catalogMod');
        $catalogMod->update();

        $mantMod = CMS::find(14);
        $mantMod->parametro = $request->get('mantMod');
        $mantMod->update();
        
        //redireccionar
        return redirect()->route('cms.index')->with('toast_success', 'Configuración actualizada correctamente');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $cmsVars = CMS::get()->toArray();

        return view('welcome',compact('cmsVars'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cmsVars = CMS::find($id);

        return view('welcome', compact('cmsVars'));
    }







}






