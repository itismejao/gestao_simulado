<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use Illuminate\Support\MessageBag;

class CursoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $cursos = Curso::all();

        $curso = Curso::find($request->input('curso_id'));

        return view('form.curso', compact('cursos','curso'));
    }

    public function store(Request $request){

        $request->validate([
            'nome'=>'required'
        ]); 

        $curso = new Curso([
            'nome' => $request->get('nome')
        ]);

        $curso->save();

        return redirect('/curso')->with('success', 'Curso cadastrado!'); 

    }

    public function edit($id)
    {
        $curso = Curso::find($id);
        return view('form.curso', compact('curso'));
    }

    public function update(Request $request){

        $request->validate([
            'curso_id' => 'required|integer',
            'nome'=>'required'
        ]);

        $curso = Curso::find($request->get('curso_id'));

        $curso->nome = $request->get('nome');

        $curso->save();

        return redirect('/curso')->with('success', 'Curso alterado!'); 

    }

    public function destroy(Request $request) {

        $request->validate([
            'curso_id' => 'required|integer'
        ]);

        $curso = Curso::find($request->input('curso_id'));
        
        if(!$curso->turma->isEmpty()){
            return redirect('/curso')->with('error', 'Existem turmas vinculadas ao curso, não pode ser excluido!');
        }

        $curso->delete();
 
        return redirect('/curso')->with('success', 'Curso removido!');
    }
}
