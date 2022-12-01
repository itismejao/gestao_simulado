@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('PLanilha') }}</div>

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

                    <form method="POST" action="{{ route('planilha') }}">

                        @if (isset($planilha))
                            @method('PUT')
                        @endif

                        @csrf

                        <div class="row mb-3">
                            <label for="planilha_id" class="col-md-4 col-form-label text-md-end">{{ __('ID') }}</label>

                            <div class="col-md-6">
                                <input id="planilha_id" type="text" class="form-control" name="planilha_id" value="{{ isset($planilha) ? $planilha->planilha_id : null }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="prova_id" class="col-md-4 col-form-label text-md-end">{{ __('Prova') }}</label>

                            <div class="col-md-6">
                                {{-- <input id="curso_id" type="text" class="form-control @error('curso_id') is-invalid @enderror" name="curso_id" value="{{ old('curso_id') }}" required autocomplete="curso_id" autofocus> --}}

                                <select id="prova_id" class="form-control @error('prova_id') is-invalid @enderror" name="prova_id" required autocomplete="prova_id">
                                    @if (isset($planilha))
                                        <option value={{$planilha->prova->prova_id}} selected>{{$planilha->prova->nome}}</option>
                                    @endif

                                    @foreach($provas as $prova)
                                        <option value={{$prova->prova_id}}>{{$prova->nome}}</option>
                                    @endforeach
                                </select>

                                @error('prova_id')
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
                      <td>Qtd Linhas</td>
                      <td>Prova</td>
                      <td>Success</td>
                      <td colspan = 2>Ações</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($planilhas as $planilha)
                    <tr>
                        <td>{{$planilha->planilha_id}}</td>
                        <td>{{$planilha->nome}} </td>
                        <td>{{$planilha->qtd_linhas}} </td>
                        <td>{{$planilha->prova->nome}} </td>
                        <td>{{$planilha->success}} </td>
                        <td>{{$planilha->updated_at->format('d/m/o')}}</td>
                        <td>
                            <a href="{{ route('planilha',['planilha_id' => $planilha->planilha_id])}}" class="btn btn-primary">Alterar</a>
                        </td>
                        <td>
                            <form action="{{ route('planilha', ['planilha_id' => $planilha->planilha_id])}}" method="post" onsubmit="return confirm('Deseja realmente excluir a planilha {{$planilha->nome}}?');">
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
