<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;

class SalaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $salas = Sala::all();

        $sala = Sala::find($request->input('sala_id'));

        return view('form.sala', compact('salas','sala'));
    }

    public function store(Request $request){

        $request->validate([
            'nome'=>'required',
            'capacidade' => 'required|integer'
        ]); 

        $sala = new Sala([
            'nome' => $request->get('nome'),
            'capacidade' => $request->get('capacidade')
        ]);

        $sala->save();

        return redirect('/sala')->with('success', 'Sala cadastrada!'); 

    }

    public function edit($id)
    {
        $sala = Sala::find($id);
        return view('form.sala', compact('sala'));
    }

    public function update(Request $request){

        $request->validate([
            'sala_id' => 'required|integer',
            'capacidade' => 'integer'
        ]);

        $sala = Sala::find($request->get('sala_id'));

        $sala->nome = $request->get('nome');
        $sala->capacidade = $request->get('capacidade');

        $sala->save();

        return redirect('/sala')->with('success', 'Sala alterada!'); 

    }

    public function destroy(Request $request) {

        $sala = Sala::find($request->input('sala_id'));

        $sala->delete();
 
        return redirect('/sala')->with('success', 'Sala removida!');
    }
}
