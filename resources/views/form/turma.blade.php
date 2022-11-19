@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Turma') }}</div>

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

                    <form method="POST" action="{{ route('turma') }}">

                        @if (isset($turma))
                            @method('PUT')
                        @endif

                        @csrf

                        <div class="row mb-3">
                            <label for="turma_id" class="col-md-4 col-form-label text-md-end">{{ __('ID') }}</label>

                            <div class="col-md-6">
                                <input id="turma_id" type="text" class="form-control" name="turma_id" value="{{ isset($turma) ? $turma->turma_id : null }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="curso_id" class="col-md-4 col-form-label text-md-end">{{ __('Curso') }}</label>

                            <div class="col-md-6">
                                {{-- <input id="curso_id" type="text" class="form-control @error('curso_id') is-invalid @enderror" name="curso_id" value="{{ old('curso_id') }}" required autocomplete="curso_id" autofocus> --}}

                                <select id="curso_id" class="form-control @error('curso_id') is-invalid @enderror" name="curso_id" required autocomplete="curso_id">
                                    @if (isset($turma))
                                        <option value={{$turma->curso->curso_id}} selected>{{$turma->curso->nome}}</option>
                                    @endif

                                    @foreach($cursos as $curso)
                                        <option value={{$curso->curso_id}}>{{$curso->nome}}</option>
                                    @endforeach
                                </select>

                                @error('curso_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ano" class="col-md-4 col-form-label text-md-end">{{ __('Ano') }}</label>

                            <div class="col-md-6">
                                <input id="ano" type="text" class="form-control @error('ano') is-invalid @enderror" name="ano" value="{{ isset($turma) ? $turma->ano : old('ano') }}" autocomplete="ano" autofocus>

                                @error('ano')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nome_turma" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="nome_turma" type="text" class="form-control @error('nome_turma') is-invalid @enderror" name="nome_turma" value="{{ isset($turma) ? $turma->nome_turma : old('nome_turma') }}" required autocomplete="nome_turma" autofocus>

                                @error('nome_turma')
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
                      <td>Ano</td>
                      <td>Nome</td>
                      <td>Curso</td>
                      <td>Atualizado em</td>
                      <td colspan = 2>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turmas as $turma)
                    <tr>
                        <td>{{$turma->turma_id}}</td>
                        <td>{{$turma->ano}} </td>
                        <td>{{$turma->nome_turma}} </td>
                        <td>{{$turma->curso->nome}} </td>
                        <td>{{$turma->updated_at->format('d/m/o')}}</td>
                        <td>
                            <a href="{{ route('turma',['turma_id' => $turma->turma_id])}}" class="btn btn-primary">Alterar</a>
                        </td>
                        <td>
                            <form action="{{ route('turma', ['turma_id' => $turma->turma_id])}}" method="post" onsubmit="return confirm('Deseja realmente excluir a turma {{$turma->ano.'-'.$turma->nome}}?');">
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
