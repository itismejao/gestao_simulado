<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prova;

class ProvaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $provas = Prova::orderBy('data_aplicacao', 'ASC')->get();

        $prova = Prova::find($request->input('prova_id'));

        return view('form.prova', compact('provas','prova'));
    }

    public function store(Request $request){

        $request->validate([
            'nome'=>'required',
            'data_aplicacao' => 'date'
        ]); 

        $prova = new Prova([
            'nome' => $request->get('nome'),
            'data_aplicacao' => $request->get('data_aplicacao')
        ]);

        $prova->save();

        return redirect('/prova')->with('success', 'Prova cadastrada!'); 

    }

    public function edit($id)
    {
        $prova = Prova::find($id);
        return view('form.prova', compact('prova'));
    }

    public function update(Request $request){

        $request->validate([
            'prova_id' => 'required|integer',
            'data_aplicacao' => 'date'
        ]);

        $prova = Prova::find($request->get('prova_id'));

        $prova->nome = $request->get('nome');
        $prova->data_aplicacao = $request->get('data_aplicacao');

        $prova->save();

        return redirect('/prova')->with('success', 'Prova alterada!'); 

    }

    public function destroy(Request $request) {

        $prova = Prova::find($request->input('prova_id'));
        $prova->delete();
 
        return redirect('/prova')->with('success', 'Prova removida!');
    }
}
