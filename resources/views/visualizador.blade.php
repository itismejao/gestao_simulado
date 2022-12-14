@extends('layouts.app')

@section('content')
<div class="container">


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
                               
                        <visualizador :provas="{{ $provas }}" ></visualizador>


</div>
@endsection
