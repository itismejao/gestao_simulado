@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Próximas Provas') }}</div>

                <div class="card-body">

                    @if(session()->get('success'))
                        <div class="alert alert-success">
                        {{ session()->get('success') }}  
                        </div>
                    @elseif(session()->get('error'))
                        <div class="alert alert-danger">
                        {{ session()->get('error') }}  
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    
                    <div class="container">
                        @if(count($provas) > 0)
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                  <td>ID</td>
                                  <td>Nome</td>
                                  <td>Data de Aplicação</td>
                                  <td>Qtd. Participantes</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($provas as $prova)
                                <tr>
                                    <td>{{$prova->prova_id}}</td>
                                    <td>{{$prova->nome}} </td>
                                    <td>{{DateTime::createFromFormat('Y-m-d', $prova->data_aplicacao)->format('d/m/o')}}</td>
                                    <td>{{count($prova->participanteProva)}} </td>

                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                          @else
                            <h5>Sem próximas provas agendadas</h5>
                          @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection
