<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Exibir página inicial
     */
    public function index()
    {
        $usuario = Auth::user();
        return view('home', compact('usuario'));
    }
}
