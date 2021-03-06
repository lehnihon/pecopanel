@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'connect.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Usuários</a></li>
                <li class="breadcrumb-item active">Criar</li>
            </ol>
        </nav>          
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Usuários</h5>
                        <p class="card-category">Criar um usuário</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="name">Nome</label>
                                    <input name="name" id="name" type="text" class="form-control" placeholder="Digite o nome" value="{{ old('name') }}" autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            O campo nome é obrigatório
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label for="email">E-mail</label>
                                    <input name="email" id="email" type="text" class="form-control" placeholder="Digite o e-mail" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            O campo e-mail é obrigatório
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label for="password">Senha</label>
                                    <input name="password" id="password" type="text" class="form-control" placeholder="Digite a senha" value="{{ old('password') }}">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            O campo senha é obrigatório
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                    <label for="role">Função</label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="">Selecione</option>
                                        @foreach($roles as $role)
                                            <option {{ old('role') == $role['id'] ? 'selected' : '' }} value="{{$role['id']}}">{{$role['name']}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('role'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            O campo função é obrigatório
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
