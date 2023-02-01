<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prova;
use Carbon\Carbon;

class HomeController extends Controller
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
        $provas = Prova::whereDate('data_aplicacao', '>', Carbon::today()->toDateString())->orderBy('data_aplicacao', 'ASC')->take(3)->get();

        return view('home', compact('provas'));
    }
}
