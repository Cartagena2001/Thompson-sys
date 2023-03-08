<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\User;

class OrdenesController extends Controller
{
    public function index()
    {
        $ordenes = Orden::Paginate();
        $users = User::all();
        return view('ordenes.index' , compact('ordenes' , 'users'));
    }
}
