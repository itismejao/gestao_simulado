@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Participante') }}</div>

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

                    <form method="POST" action="{{ route('participante') }}">

                        @if (isset($participante))
                            @method('PUT')
                        @endif

                        @csrf

                        <div class="row mb-3">
                            <label for="participante_id" class="col-md-4 col-form-label text-md-end">{{ __('ID') }}</label>

                            <div class="col-md-6">
                                <input id="participante_id" type="text" class="form-control" name="participante_id" value="{{ isset($participante) ? $participante->participante_id : null }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="turma_id" class="col-md-4 col-form-label text-md-end">{{ __('Turma') }}</label>

                            <div class="col-md-6">
                                <select id="turma_id" class="form-control @error('turma_id') is-invalid @enderror" name="turma_id" required autocomplete="turma_id">
                                    @if (isset($participante))
                                        <option value={{$participante->turma->turma_id}} selected>{{$participante->turma->nome_turma}}</option>
                                    @endif

                                    @foreach($turmas as $turma)
                                        <option value={{$turma->turma_id}}>{{$turma->ano.'° '.$turma->nome_turma}}</option>
                                    @endforeach
                                </select>

                                @error('turma_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="matricula" class="col-md-4 col-form-label text-md-end">{{ __('Matrícula') }}</label>

                            <div class="col-md-6">
                                <input id="matricula" type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ isset($participante) ? $participante->matricula : old('matricula') }}" autocomplete="matricula" autofocus>

                                @error('matricula')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nome" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ isset($participante) ? $participante->nome : old('nome') }}" required autocomplete="nome" autofocus>

                                @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($turma) ? __('Salvar') : __('Cadastrar') }}
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
                      <td>Matrícula</td>
                      <td>Nome</td>
                      <td>Turma</td>
                      <td>Atualizado em</td>
                      <td colspan = 2>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participantes as $participante)
                    <tr>
                        <td>{{$participante->participante_id}}</td>
                        <td>{{$participante->matricula}} </td>
                        <td>{{$participante->nome}} </td>
                        <td>{{$participante->turma->ano.'° '.$participante->turma->nome_turma}} </td>
                        <td>{{$participante->updated_at->format('d/m/o')}}</td>
                        <td>
                            <a href="{{ route('participante',['participante_id' => $participante->participante_id])}}" class="btn btn-primary">Alterar</a>
                        </td>
                        <td>
                            <form action="{{ route('participante', ['participante_id' => $participante->participante_id])}}" method="post" onsubmit="return confirm('Deseja realmente excluir o participante {{$participante->nome}}?');">
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
