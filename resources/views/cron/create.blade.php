@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'cron.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cron.index',request()->id) }}">Cron</a></li>
                <li class="breadcrumb-item active" aria-current="page">Criar</li>
            </ol>
        </nav>         
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Cron</h5>
                        <p class="card-category">Insira os campos para criar um cron</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cron.store',request()->id) }}" method="POST">
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
                                <div class="col-sm-6 form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                                    <label for="username">Usuário</label>
                                    <select name="username" id="username" class="form-control">
                                        <option selected disabled value="">Selecione</option>
                                        @foreach($users as $user)
                                            <option {{ old('username') == $user['id'] ? 'selected' : '' }} value="{{$user['id']}}">{{$user['username']}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('username'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('username') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-12 form-group{{ $errors->has('command') ? ' has-danger' : '' }}">
                                    <label for="command">Comando</label>
                                    <textarea name="command" id="command" class="form-control px-3" placeholder="Digite seu comando"></textarea>
                                    @if ($errors->has('command'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('command') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('minute') ? ' has-danger' : '' }}">
                                    <label for="minute">Minuto</label>
                                    <input name="minute" id="minute" type="text" class="form-control" placeholder="Digite o minuto" value="{{ (empty(old('minute')))?'*':old('minute') }}">
                                    @if ($errors->has('minute'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('minute') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('hour') ? ' has-danger' : '' }}">
                                    <label for="hour">Hora</label>
                                    <input name="hour" id="hour" type="text" class="form-control" placeholder="Digite a hora" value="{{ (empty(old('hour')))?'*':old('minute') }}">
                                    @if ($errors->has('hour'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('hour') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('dayOfMonth') ? ' has-danger' : '' }}">
                                    <label for="dayOfMonth">Dia do mês</label>
                                    <input name="dayOfMonth" id="dayOfMonth" type="text" class="form-control" placeholder="Digite dia do mês" value="{{ (empty(old('dayOfMonth')))?'*':old('dayOfMonth') }}">
                                    @if ($errors->has('dayOfMonth'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('dayOfMonth') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('month') ? ' has-danger' : '' }}">
                                    <label for="month">Mês</label>
                                    <input name="month" id="month" type="text" class="form-control" placeholder="Digite o mês" value="{{ (empty(old('month')))?'*':old('month') }}">
                                    @if ($errors->has('month'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('month') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('dayOfWeek') ? ' has-danger' : '' }}">
                                    <label for="dayOfWeek">Dia da semana</label>
                                    <input name="dayOfWeek" id="dayOfWeek" type="text" class="form-control" placeholder="Digite o dia da semana" value="{{ (empty(old('dayOfWeek')))?'*':old('dayOfWeek') }}">
                                    @if ($errors->has('dayOfWeek'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('dayOfWeek') }}
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