@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Gerador de lugares') }}</div>

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

                    {{-- <form method="POST" action="{{ route('gerador') }}"  enctype="multipart/form-data">
                        @csrf --}}
                               
                        <gerador :provas="{{ $provas }}" :salas="{{ $salas }}"></gerador>

                    {{-- </form> --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
