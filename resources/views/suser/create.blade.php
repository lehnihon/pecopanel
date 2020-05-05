@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'suser.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item"><a href="{{ route('suser.index',request()->id) }}">Usuários</a></li>
                <li class="breadcrumb-item active" aria-current="page">Criar</li>
            </ol>
        </nav>         
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Usuários</h5>
                        <p class="card-category">Insira os campos para criar um novo usuário</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('suser.store',request()->id) }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-sm-12 form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                                    <label for="username">Usuário</label>
                                    <input name="username" id="username" type="text" class="form-control" placeholder="Digite o usuário" value="{{ old('username') }}" autofocus>
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('username') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label for="password">Senha</label>
                                    <input name="password" id="password" type="password" class="form-control" placeholder="Digite a senha">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                    <label for="password_confirmation">Confirmar Senha</label>
                                    <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" placeholder="Confirme a senha">
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('password_confirmation') }}
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