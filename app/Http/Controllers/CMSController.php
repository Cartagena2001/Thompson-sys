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

    public function create() {

        $cmsVars = CMS::get()->toArray();

        return view('config.index',compact('cmsVars'));
    }

    public function store(Request $request) {
        
        //validar campos
        $request->validate([
            'numWhat' => 'required',
            'numWhatURL' => 'required',
            'numFijo' => 'required',
            'numFijoURL' => 'required',
            'perfilFB' => 'required',
            'perfilIG' => 'required',
            'dirrOfi' => 'required',
            'horOfi' => 'required',
            'dirBod' => 'required',
            'horBod' => 'required',
            'emailContacto' => 'required',
            'emailOrder' => 'required',
        ]);

        //guardar parametros CMS
        $numWhat = CMS::where('variable', '=', 'numWhat')->get();
        $numWhat = $request->post('numWhat');
        $numWhat->save();

        $numWhatURL = CMS::where('variable', '=', 'numWhatURL')->get();
        $numWhatURL = $request->post('numWhatURL');
        $numWhatURL->save();

        $numFijo = CMS::where('variable', '=', 'numFijo')->get();
        $numFijo = $request->post('numFijo');
        $numFijo->save();

        $numFijoURL = CMS::where('variable', '=', 'numFijoURL')->get();
        $numFijoURL = $request->post('numFijoURL');
        $numFijoURL->save();

        $perfilFB = CMS::where('variable', '=', 'fbURL')->get();
        $perfilFB = $request->post('perfilFB');
        $perfilFB->save();

        $perfilIG = CMS::where('variable', '=', 'igURL')->get();
        $perfilIG = $request->post('perfilIG');
        $perfilIG->save();

        $dirrOfi = CMS::where('variable', '=', 'dirOF')->get();
        $dirrOfi = $request->post('dirrOfi');
        $dirrOfi->save();

        $horOfi = CMS::where('variable', '=', 'horarioOF')->get();
        $horOfi = $request->post('horOfi');
        $horOfi->save();

        $dirBod = CMS::where('variable', '=', 'dirBod')->get();
        $dirBod = $request->post('dirBod');
        $dirBod->save();

        $horarioBod = CMS::where('variable', '=', 'horarioBod')->get();
        $horarioBod = $request->post('horBod');
        $horarioBod->save();

        $emailContacto = CMS::where('variable', '=', 'corrContacto')->get();
        $emailContacto = $request->post('emailContacto');
        $emailContacto->save();

        $emailOrder = CMS::where('variable', '=', 'corrOrden')->get();
        $emailOrder = $request->post('emailOrder');
        $emailOrder->save();

        return redirect()->route('cms.index');

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






