<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prova;

class GeradorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $provas = Prova::with('participanteProva')->get();

        return view('gerador',  ['provas' => $provas]);
    }
}
