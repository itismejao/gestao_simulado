@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Curso') }}</div>

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


                    <form method="POST" action="{{ route('curso') }}">

                    @if (isset($curso))
                        @method('PUT')
                    @endif
                    
                        @csrf

                        <div class="row mb-3">
                            <label for="curso_id" class="col-md-4 col-form-label text-md-end">{{ __('ID') }}</label>

                            <div class="col-md-6">
                                <input id="curso_id" type="text" class="form-control" name="curso_id" value="{{ isset($curso) ? $curso->curso_id : null }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nome" class="col-md-4 col-form-label text-md-end">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ isset($curso) ? $curso->nome : old('nome') }}" required autocomplete="nome" autofocus>

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
                                    {{ isset($curso) ? __('Salvar') : __('Cadastrar') }}
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
                      <td>Atualizado em</td>
                      <td colspan = 2>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cursos as $curso)
                    <tr>
                        <td>{{$curso->curso_id}}</td>
                        <td>{{$curso->nome}} </td>
                        <td>{{$curso->updated_at->format('d/m/o')}}</td>
                        <td>
                            <a href="{{ route('curso',['curso_id' => $curso->curso_id])}}" class="btn btn-primary">Alterar</a>
                        </td>
                        <td>
                            <form action="{{ route('curso', ['curso_id' => $curso->curso_id])}}" method="post" onsubmit="return confirm('Deseja realmente excluir o curso {{$curso->nome}}?');">
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
