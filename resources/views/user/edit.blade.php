@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'connect.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Usuários</a></li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </nav>        
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Usuários</h5>
                        <p class="card-category">Editar um usuário</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update',$user->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="name">Nome</label>
                                    <input name="name" id="name" type="text" class="form-control" placeholder="Digite o nome" value="{{ old('name') ?? $user->name }}" autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label for="email">E-mail</label>
                                    <input name="email" id="email" type="text" class="form-control" placeholder="Digite o e-mail" value="{{ old('email') ?? $user->email }}">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <label for="password">Nova Senha</label>
                                    <input name="password" id="password" type="text" class="form-control" placeholder="Digite a nova senha" value="{{ old('password')}}">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                    <label for="role">Função</label>
                                    <select name="role" id="role" class="form-control">
                                        <option selected disabled value="">Selecione</option>
                                        @foreach($roles as $role)
                                            <option {{ old('role') ?? $user->role->id == $role['id'] ? 'selected' : '' }} value="{{$role['id']}}">{{$role['name']}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('role'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('role') }}
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
