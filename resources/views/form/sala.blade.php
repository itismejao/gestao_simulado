@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sala') }}</div>

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


                    <form method="POST" action="{{ route('sala') }}">

                    @if (isset($sala))
                        @method('PUT')
                    @endif
                    
                        @csrf

                        <div class="row mb-3">
                            <label for="sala_id" class="col-md-4 col-form-label text-md-end">{{ __('ID') }}</label>

                            <div class="col-md-6">
                                <input id="sala_id" type="text" class="form-control" name="sala_id" value="{{ isset($sala) ? $sala->sala_id : null }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nome" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ isset($sala) ? $sala->nome : old('nome') }}" required autocomplete="nome" autofocus>

                                @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="setor" class="col-md-4 col-form-label text-md-end">{{ __('Setor') }}</label>

                            <div class="col-md-6">
                                <input id="setor" type="text" class="form-control @error('setor') is-invalid @enderror" name="setor" value="{{ isset($sala) ? $sala->setor : old('setor') }}" required autocomplete="setor" autofocus>

                                @error('setor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="capacidade" class="col-md-4 col-form-label text-md-end">{{ __('Capacidade') }}</label>

                            <div class="col-md-6">
                                <input id="capacidade" type="text" class="form-control @error('capacidade') is-invalid @enderror" name="capacidade" value="{{ isset($sala) ? $sala->capacidade : old('capacidade') }}" required autocomplete="capacidade" autofocus>

                                @error('capacidade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($sala) ? __('Salvar') : __('Cadastrar') }}
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
                      <td>Setor</td>
                      <td>Capacidade</td>
                      <td>Atualizado em</td>
                      <td colspan = 2>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salas as $sala)
                    <tr>
                        <td>{{$sala->sala_id}}</td>
                        <td>{{$sala->nome}} </td>
                        <td>{{$sala->setor}} </td>
                        <td>{{$sala->capacidade}} </td>
                        <td>{{$sala->updated_at->format('d/m/o')}}</td>
                        <td>
                            <a href="{{ route('sala',['sala_id' => $sala->sala_id])}}" class="btn btn-primary">Alterar</a>
                        </td>
                        <td>
                            <form action="{{ route('sala', ['sala_id' => $sala->sala_id])}}" method="post" onsubmit="return confirm('Deseja realmente excluir a sala {{$sala->nome}}?');">
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
