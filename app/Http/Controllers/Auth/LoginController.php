<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\Bitacora;
use App\Models\Evento;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        if (Auth::check()) { 

            $reg = new Bitacora();

            //verificar el usuario en sesión
            $usr = auth()->User();

            $reg->evento_id = 1;
            $reg->user_id = $usr->id;
            $reg->hora_fecha = \Carbon\Carbon::now()->format('d/m/Y, h:m:s a');

            $reg->save();
        }
        

        $this->middleware('guest')->except('logout');
    }


}
