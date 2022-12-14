@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Planilhas') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

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

               

            <table class="table table-striped">
                <thead>
                    <tr>
                      <td></td>
                      <td>ID</td>
                      <td>Nome</td>
                      <td>Qtd Linhas</td>
                      <td>Prova</td>
                      <td>Atualizado em</td>
                      {{-- <td colspan = 2>Ações</td> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($planilhas as $planilha)
                    <tr >
                        <td class="@if($planilha->success) bg-success @else bg-danger @endif"></td>
                        <td>{{$planilha->planilha_id}}</td>
                        <td>{{$planilha->nome_original}} </td>
                        <td>{{$planilha->qtd_linhas}} </td>
                        <td>{{$planilha->prova->nome}} </td>
                        <td>{{$planilha->updated_at->format('d/m/o')}}</td>
                        {{-- <td>
                            <a href="{{ route('planilha',['planilha_id' => $planilha->planilha_id])}}" class="btn btn-primary">Alterar</a>
                        </td>
                        <td>
                            <form action="{{ route('planilha', ['planilha_id' => $planilha->planilha_id])}}" method="post" onsubmit="return confirm('Deseja realmente excluir a planilha {{$planilha->nome}}?');">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-danger" type="submit">Excluir</button>
                            </form>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
