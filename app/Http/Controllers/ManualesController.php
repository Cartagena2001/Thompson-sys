<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualesController extends Controller
{
    public function index()
    {
        return view('manuales.index');
    }
}
