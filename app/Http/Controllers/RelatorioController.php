<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prova;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redacao()
    {
        $provas = Prova::with('participanteProva')->get();

        return view('reports.redacao', compact('provas'));
    }

    public function processarredacao(Request $request)
    {
        try {
            $prova_id = $request->input('prova_id');
            $data['prova_id'] = [$prova_id];
            return PDF::loadView('reports.folhaderedacao', $data)
                ->stream();
        } catch (\Throwable $th) {
            return [
                'error' => true,
                'message' => $th->getMessage()
            ];
        }
    }
}
