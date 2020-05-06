@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'ssh.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ssh.index',request()->id) }}">Chave SSH</a></li>
                <li class="breadcrumb-item active" aria-current="page">Criar</li>
            </ol>
        </nav>         
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Chave SSH</h5>
                        <p class="card-category">Insira os campos para criar uma nova chave ssh</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ssh.store',request()->id) }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6 form-group{{ $errors->has('label') ? ' has-danger' : '' }}">
                                    <label for="label">Rótulo</label>
                                    <input name="label" id="label" type="text" class="form-control" placeholder="Digite o Rótulo" value="{{ old('label') }}" autofocus>
                                    @if ($errors->has('label'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('label') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('user') ? ' has-danger' : '' }}">
                                    <label for="user">Usuário</label>
                                    <select name="user" id="user" class="form-control">
                                        <option disabled value="">Selecione</option>
                                        @foreach($users as $user)
                                            <option {{ old('user') == $user['username'] ? 'selected' : '' }} value="{{$user['username']}}">{{$user['username']}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('user'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('user') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-12 form-group{{ $errors->has('publick') ? ' has-danger' : '' }}">
                                    <label for="publick">Chave Pública</label>
                                    <textarea name="publick" id="publick" class="form-control" placeholder="Digita sua chave pública">
                                    </textarea>
                                    @if ($errors->has('publick'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('publick') }}
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