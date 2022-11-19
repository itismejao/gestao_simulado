@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Prova') }}</div>

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


                    <form method="POST" action="{{ route('prova') }}">

                    @if (isset($prova))
                        @method('PUT')
                    @endif
                    
                        @csrf

                        <div class="row mb-3">
                            <label for="prova_id" class="col-md-4 col-form-label text-md-end">{{ __('ID') }}</label>

                            <div class="col-md-6">
                                <input id="prova_id" type="text" class="form-control" name="prova_id" value="{{ isset($prova) ? $prova->prova_id : null }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nome" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ isset($prova) ? $prova->nome : old('nome') }}" required autocomplete="nome" autofocus>

                                @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="data_aplicacao" class="col-md-4 col-form-label text-md-end">{{ __('Data de Aplicação') }}</label>

                            <div class="col-md-6">
                                <input id="data_aplicacao" type="date" class="form-control @error('data_aplicacao') is-invalid @enderror" name="data_aplicacao" value="{{ isset($prova) ? $prova->data_aplicacao : old('data_aplicacao') }}" required autocomplete="capacidade" autofocus>

                                @error('data_aplicacao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($prova) ? __('Salvar') : __('Cadastrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                      <td>ID</td>
                      <td>Nome</td>
                      <td>Data Aplicacao</td>
                      <td>Atualizado em</td>
                      <td colspan = 2>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($provas as $prova)
                    <tr>
                        <td>{{$prova->prova_id}}</td>
                        <td>{{$prova->nome}} </td>
                        <td>{{DateTime::createFromFormat('Y-m-d', $prova->data_aplicacao)->format('d/m/o')}} </td>
                        <td>{{$prova->updated_at->format('d/m/o')}}</td>
                        <td>
                            <a href="{{ route('prova',['prova_id' => $prova->prova_id])}}" class="btn btn-primary">Alterar</a>
                        </td>
                        <td>
                            <form action="{{ route('prova', ['prova_id' => $prova->prova_id])}}" method="post" onsubmit="return confirm('Deseja realmente excluir a prova {{$prova->nome}}?');">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-danger" type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
@endsection
