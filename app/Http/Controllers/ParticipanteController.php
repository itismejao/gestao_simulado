<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\Participante;

class ParticipanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $participantes = Participante::all();

        $participante = Participante::find($request->input('participante_id'));

        $turmas = Turma::all();

        return view('form.participante', compact('participantes','participante','turmas'));
    }

    public function store(Request $request){

        $request->validate([
            'nome'=>'required',
            'matricula'=>'required',
            'turma_id'=>'integer'
        ]);

        $participante = new Participante([
            'matricula' =>  $request->get('matricula'),
            'nome' => $request->get('nome'),
            'turma_id' => $request->get('turma_id')
        ]);

        $participante->save();

        return redirect('/participante')->with('success', 'Participante cadastrado!'); 

    }

    public function edit($id)
    {
        $participante = Participante::find($id);
        return view('form.participante', compact('participante'));
    }

    public function update(Request $request){

        $request->validate([
            'participante_id' => 'required|integer'
        ]);

        $participante = Participante::find($request->get('participante_id'));

        $participante->nome = $request->get('nome');

        $participante->matricula = $request->get('matricula');

        $participante->turma_id = $request->get('turma_id');

        $participante->save();

        return redirect('/participante')->with('success', 'Participante alterado!'); 

    }

    public function destroy(Request $request) {

        $participante = Participante::find($request->input('participante_id'));
        $participante->delete();
 
        return redirect('/participante')->with('success', 'Participante removido!');
    }
}
