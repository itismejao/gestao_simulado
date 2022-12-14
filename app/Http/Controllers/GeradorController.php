<?php

namespace App\Http\Controllers;

use App\Models\ParticipanteProva;
use Illuminate\Http\Request;
use App\Models\Prova;
use App\Models\Sala;
use Exception;

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

        $salas = Sala::all();

        return view('gerador',  ['provas' => $provas, 'salas' => $salas]);
    }

    public function processarLugares(Request $request){
        try{
            $prova = $request->input('prova');
            $salas = $request->input('salas');
            $prova = Prova::find($prova['prova_id']);

            $vetorPosicoesPorAno = [];

            $qtdPorAno = [];

            $tamanhoFila = 0;

            foreach ($prova->participanteProva as $key => $value) {
                isset($qtdPorAno[$value->participante->turma->ano]) ? $qtdPorAno[$value->participante->turma->ano]++ :  $qtdPorAno[$value->participante->turma->ano] = 1;
            }

            $participantes = $prova->participanteProva->shuffle();

            foreach ($salas as $key => $value) {

                $fileiras = $value['fileiras'];

                $tamanhoFila =  ceil($value['capacidade'] /  $value['fileiras']);

                $pulos = 0;

                for($i = 0; $i <  $tamanhoFila; $i++){
                    for($j = 0; $j < $fileiras ;$j++){
                        if($participantes->isEmpty()){
                            $j = $fileiras;
                            $i = $tamanhoFila;
                        } else {
                            $restante = count($participantes);
                            $participante = $participantes->shift(); 
                            $podeGravar = true;
                            if(isset($vetorPosicoesPorAno[$i-1][$j])){
                                if($vetorPosicoesPorAno[$i-1][$j]->participante->turma->ano == $participante->participante->turma->ano){
                                    $pulos++;
                                    $podeGravar = false;
                                    if($pulos != $restante) {
                                        $j--;
                                    } else {
                                        $pulos = 0;
                                    }   
                                    $participantes->push($participante);
                                }
                            } 
                            if($podeGravar){
                                if (isset($vetorPosicoesPorAno[$i][$j-1])) {
                                    if($vetorPosicoesPorAno[$i][$j-1]->participante->turma->ano == $participante->participante->turma->ano){
                                        $podeGravar = false;
                                        if($pulos != $restante){
                                            $j--;
                                        } else {
                                            $pulos = 0;
                                        }     
                                        $participantes->push($participante);
                                    }
                                }
                            }
                            if($podeGravar){
                                $pulos = 0;
                                $participante->sala_id = $value['sala_id'];
                                $participante->posicao = "$i - $j";
                                $vetorPosicoesPorAno[$i][$j] = $participante;
                            }                          
                        }                     
                    }
                }

            }

             foreach ($vetorPosicoesPorAno as $keyLine => $valueLine) {
                foreach ($valueLine as $key => $value) {
                    $value->save();
                } 
             }

            session()->flash('success', 'Locais gerados com sucesso!');

            return true;

        } catch(Exception $e){
            session()->flash('error', 'Erro! Tente Novamente!');
            return false;
        }
       

    }


    public function visualizarLugares(Request $request){
        try {
            $provas = Prova::with('participanteProva')->get();

            //$salas = Sala::all();
    
            return view('visualizador',  ['provas' => $provas]);
        } catch (\Throwable $th) {
            
        }
    }

    public function buscarSalas(Request $request){
        try {
            
            $prova = $request->input('prova');

            $participanteProva = ParticipanteProva::where('prova_id',$prova['prova_id'])->with('participante.turma')->get();

            $salas = [];

            foreach ($participanteProva as $key => $value) {
                if (!in_array($value->sala, $salas))
                    {
                        $salas[] = $value->sala; 
                    }
            }
            
            return [
                "salas" => $salas,
                "participantes" => $participanteProva
            ];
        } catch (\Throwable $th) {
            return $th;
        }
    }

}
