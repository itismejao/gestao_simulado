<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\Curso;

class TurmaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $turmas = Turma::all();

        $turma = Turma::find($request->input('turma_id'));

        $cursos = Curso::all();

        return view('form.turma', compact('turmas','turma','cursos'));
    }

    public function store(Request $request){

        $request->validate([
            'nome_turma'=>'required',
            'curso_id'=>'required|integer',
            'ano'=>'integer'
        ]);

        $turma = new Turma([
            'ano' =>  $request->get('ano'),
            'nome_turma' => $request->get('nome_turma'),
            'curso_id' => $request->get('curso_id')
        ]);

        $turma->save();

        return redirect('/turma')->with('success', 'Turma cadastrada!'); 

    }

    public function edit($id)
    {
        $turma = Turma::find($id);
        return view('form.turma', compact('turma'));
    }

    public function update(Request $request){

        $request->validate([
            'turma_id' => 'required|integer'
        ]);

        $turma = Turma::find($request->get('turma_id'));

        $turma->nome_turma = $request->get('nome_turma');

        $turma->ano = $request->get('ano');

        $turma->curso_id = $request->get('curso_id');

        $turma->save();

        return redirect('/turma')->with('success', 'Turma alterada!'); 

    }

    public function destroy(Request $request) {

        $request->validate([
            'turma_id' => 'required|integer'
        ]);

        $turma = Turma::find($request->input('turma_id'));

        if(!$turma->participante->isEmpty()){
            return redirect('/turma')->with('error', 'Existem participantes vinculadas à turma, não pode ser excluida!');
        }

        $turma->delete();
 
        return redirect('/turma')->with('success', 'Turma removida!');
    }
}
