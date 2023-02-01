<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $usuarios = Usuario::all();

        $usuario = Usuario::find($request->input('usuario_id'));

        return view('form.usuario', compact('usuarios','usuario'));
    }

    public function store(Request $request){

        $request->validate([
            'nome'=>'required',
            'matricula'=>'required',
            'turma_id'=>'integer'
        ]);

        $usuario = new Usuario([
            'matricula' =>  $request->get('matricula'),
            'nome' => $request->get('nome'),
            'turma_id' => $request->get('turma_id')
        ]);

        $usuario->save();

        return redirect('/usuario')->with('success', 'Usuário cadastrado!'); 

    }

    public function edit($id)
    {
        $usuario = Usuario::find($id);
        return view('form.usuario', compact('usuario'));
    }

    public function update(Request $request){

        $request->validate([
            'usuario_id' => 'required|integer'
        ]);

        $usuario = Usuario::find($request->get('usuario_id'));

        $usuario->nome = $request->get('nome');

        $usuario->matricula = $request->get('matricula');

        $usuario->turma_id = $request->get('turma_id');

        $usuario->save();

        return redirect('/usuario')->with('success', 'Usuario alterado!'); 

    }

    public function destroy(Request $request) {

        $usuario = Usuario::find($request->input('usuario_id'));
        $usuario->delete();
 
        return redirect('/usuario')->with('success', 'Usuario removido!');
    }
}
