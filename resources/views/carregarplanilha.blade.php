@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Carregar planilha') }}</div>

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

                    <form method="POST" action="{{ route('planilha') }}"  enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <label for="prova_id" class="col-md-4 col-form-label text-md-end">{{ __('Prova') }}</label>
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6 offset-md-3" >

                                <select id="prova_id" class="form-control @error('prova_id') is-invalid @enderror" name="prova_id" required autocomplete="prova_id">
                                    <option disabled selected value> -- Selecione uma opção -- </option>
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

                            <div class="col-md-3">
                                <a class="btn btn-primary" href="{{ route('prova') }}">
                                    {{ __('+') }}
                                </a>
                            </div>
                            
                        </div>
                        

                    <div class="row mb-3">
                        
                        <div class="col-md-6 offset-md-3">
                            <input id="arquivo" type="file" class="form-control" name="arquivo" required>
                        </div>
                        
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-5">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Processar') }}
                            </button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection
