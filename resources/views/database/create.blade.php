@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'database.index'
])

@section('content')
    <div class="content"> 
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item"><a href="{{ route('database.index',request()->id) }}">Bancos de dados</a></li>
                <li class="breadcrumb-item active" aria-current="page">Criar</li>
            </ol>
        </nav>        
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Banco de dados</h5>
                        <p class="card-category">Insira os campos para criar um novo banco de dados</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('database.store',request()->id) }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="name">Nome</label>
                                    <input name="name" id="name" type="text" class="form-control" placeholder="Digite o nome" value="{{ old('name') }}" autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Salvar" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush