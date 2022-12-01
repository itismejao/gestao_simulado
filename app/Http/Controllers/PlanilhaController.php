<?php

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';

use App\Models\Curso;
use App\Models\Participante;
use App\Models\ParticipanteProva;
use App\Models\Planilha;
use App\Models\Prova;
use App\Models\Turma;
use Illuminate\Http\Request;

class PlanilhaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $planilhas = Planilha::all();

        $planilha = Planilha::find($request->input('planilha_id'));

        $provas = Prova::all();

        return view('form.planilha', compact('planilhas','planilha','provas'));
    }

    public function processarPlanilha(Request $request)
    {

        try {
            $request->validate([
                'arquivo' => 'required|mimes:ods,xls, xlsx, csv',
                'prova_id' => 'required'
            ]);

            $prova_id = $request->input('prova_id');

            $file = $request->file('arquivo');

            $tipo = $file->getMimeType();

            $nomeArquivo = $file->getClientOriginalName();

            $extensao = $file->getClientOriginalExtension();

            $caminho = uniqid(date('HisYmd')) . ".$extensao";

            // $upload = $file->storeAs('planilha', $caminho);

            // if ( !$upload ) {
            //     return redirect('/home')->with('error', 'Não foi possível salvar a planilha!');
            // }

            switch ($extensao) {
                case 'ods':
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Ods();
                    break;
                case 'xlsx':
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    break;
                case 'xls':
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    break;
                case 'csv':
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                    break;
            }

            $reader->setReadDataOnly(true);

            $spreadsheet = $reader->load($file);

            $worksheet = $spreadsheet->getActiveSheet();

            $lastCollum = $worksheet->getHighestColumn();

            $lastRow = $worksheet->getHighestDataRow();

            $planilha = new Planilha([
                'nome_original' => $nomeArquivo,
                'extensao' => $extensao,
                'caminho' => $caminho,
                'qtd_linhas' => $lastRow,
                'prova_id' => $prova_id,
                'success' => false
            ]);

            $planilha->save();
            $planilha = Planilha::where('caminho', $caminho)->first();

            $collums = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

            $collumCurso = '';

            $collumTurma = '';

            $collumMatricula = '';

            $collumAluno = '';

            for ($i = 0; $i <= array_search($lastCollum, $collums); $i++) {
                $value = $worksheet->getCell("$collums[$i]1");

                $posicaoAluno = stripos($value, 'aluno');
                $posicaoMatricula = stripos($value, 'matr');
                $posicaoCurso = stripos($value, 'curso');
                $posicaoTurma = stripos($value, 'turma');

                if ($posicaoAluno !== false) {
                    $collumAluno = $collums[$i];
                }
                if ($posicaoMatricula !== false) {
                    $collumMatricula = $collums[$i];
                }
                if ($posicaoTurma !== false) {
                    $collumTurma = $collums[$i];
                }
                if ($posicaoCurso !== false) {
                    $collumCurso = $collums[$i];
                }
            }

            if (!$collumCurso) {
                return redirect('/home')->with('error', 'É obrigatório uma coluna com o título curso!');
            }
            if (!$collumTurma) {
                return redirect('/home')->with('error', 'É obrigatório uma coluna com o título turma!');
            }
            if (!$collumMatricula) {
                return redirect('/home')->with('error', 'É obrigatório uma coluna com o título matricula!');
            }
            if (!$collumAluno) {
                return redirect('/home')->with('error', 'É obrigatório uma coluna com o título aluno!');
            }

            $nb = 2;

            foreach ($worksheet->getRowIterator(2) as $row) {

                $cursoNome = $worksheet->getCell("$collumCurso$nb")->getValue();

                $c = new Curso([
                    "nome" => $cursoNome
                ]);

                $curso = Curso::where('nome', $cursoNome)->first();

                if (!$curso) {
                    $c->save();
                    $curso = Curso::where('nome', $cursoNome)->first();
                }

                $turmaValue = $worksheet->getCell("$collumTurma$nb")->getValue();

                if (stripos($turmaValue, 'º') !== false) {
                    $array = explode("º", $turmaValue);
                } else if (stripos($turmaValue, '°') !== false) {
                    $array = explode("°", $turmaValue);
                } else {
                    return redirect('/home')->with('error', 'Ano/Turma deve estar no formato ano°nome: Ex. 1°B !');
                }

                $t = new Turma([
                    "ano" => trim($array[0]),
                    "nome_turma" => trim($array[1]),
                    "curso_id" => $curso->curso_id
                ]);

                $turma = Turma::where(['ano' => $t->ano, 'nome_turma' => $t->nome_turma, 'curso_id' => $t->curso_id])->first();

                if (!$turma) {
                    $t->save();
                    $turma = Turma::where(['ano' => $t->ano, 'nome_turma' => $t->nome_turma, 'curso_id' => $t->curso_id])->first();
                }

                $participanteNome = trim($worksheet->getCell("$collumAluno$nb")->getValue());

                $matricula = trim($worksheet->getCell("$collumMatricula$nb")->getValue());

                if (!isset($participanteNome) || empty($participanteNome) || !isset($matricula) || empty($matricula)) {
                    return redirect('/home')->with('error', "Nome ou matricula do aluno na linha $nb não informado!");
                }

                $participante = Participante::where(['nome' =>  $participanteNome, 'matricula' => $matricula])->first();

                //se existir participante, atualizo a turma
                if ($participante) {
                    $participante->turma_id = $turma->turma_id;
                    $participante->save();
                    //se não existir participante, persisto e recupero o ID
                } else {
                    $participante = new Participante([
                        'nome' =>  $participanteNome,
                        'matricula' => $matricula,
                        'turma_id' => $turma->turma_id
                    ]);
                    $participante->save();
                    $participante = Participante::where(['nome' =>  $participante->nome, 'matricula' => $participante->matricula])->first();
                }

                $participanteProva = ParticipanteProva::where(['participante_id' => $participante->participante_id, "prova_id" => $prova_id])->first();

                if (!$participanteProva) {
                    $participanteProva = new ParticipanteProva([
                        'participante_id' => $participante->participante_id,
                        "prova_id" => $prova_id
                    ]);
                    $participanteProva->save();
                }

                $nb++;
            }

            $planilha->success = true;
            $planilha->save();

            return redirect('/home')->with('success', 'Planilha importada com sucesso!');
        } catch (\Throwable $th) {
            return redirect('/home')->with('error', $th->getMessage());
        }
    }
}
