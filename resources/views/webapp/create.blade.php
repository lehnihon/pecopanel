@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'webapp.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item"><a href="{{ route('webapp.index',request()->id) }}">Aplicativos Web</a></li>
                <li class="breadcrumb-item active" aria-current="page">Criar</li>
            </ol>
        </nav>        
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Aplicações Web</h5>
                        <p class="card-category">Criar uma aplicação web</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('webapp.store',request()->id) }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label for="name">Nome</label>
                                    <input name="name" id="name" type="text" class="form-control mask-name" placeholder="Digite o nome" value="{{ old('name') }}" autofocus>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('domain') ? ' has-danger' : '' }}">
                                    <label for="domain">Domínio</label>
                                    <input name="domain" id="domain" type="text" class="form-control" placeholder="Digite o domínio" value="{{ old('domain') }}">
                                    @if ($errors->has('domain'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('domain') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-check col-sm-6 pt-4">
                                    <label class="form-check-label">
                                        <input name="user-check" class="form-check-input" {{old('user-check') ? 'checked' : ''}} type="checkbox">
                                        Usar usuário existente
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('user') ? ' has-danger' : '' }}">
                                    <label for="user">Usuário</label>
                                    <select name="user" id="user" class="form-control user-select">
                                        <option value="" selected disabled>Selecione</option>
                                        @foreach($users as $user)
                                            <option {{ old('user') == $user['id'] ? 'selected' : '' }} value="{{$user['id']}}">{{$user['username']}}</option>
                                        @endforeach
                                    </select>
                                    <input name="user" id="user" type="text" class="form-control user-input mask-name" placeholder="Digite o usuário" value="{{ old('user') }}">
                                    @if($errors->has('user'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('user') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('stack') ? ' has-danger' : '' }}">
                                    <label for="stack">Stack</label>
                                    <select name="stack" id="stack" class="form-control">
                                        <option value="" selected disabled>Selecione</option>
                                        <option {{ old('stack') == 'hybrid' ? 'selected' : '' }} value="hybrid">NGINX + Apache2 Híbrido (Você pode usar o .htaccess)</option>
                                        <option {{ old('stack') == 'nativenginx' ? 'selected' : '' }} value="nativenginx">NGINX Nativo (Você não pode usar o .htaccess, mas ele é mais rápido)</option>
                                        <option {{ old('stack') == 'customnginx' ? 'selected' : '' }} value="customnginx">NGINX Nativo + Configurações customizadas (Implementação manual do NGINX)</option>
                                    </select>
                                    @if($errors->has('stack'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('stack') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('stackmode') ? ' has-danger' : '' }}">
                                    <label for="stackmode">Modo Stack</label>
                                    <select name="stackmode" id="stackmode" class="form-control">
                                        <option value="" selected disabled>Selecione</option>
                                        <option {{ old('stackmode') == 'production' ? 'selected' : '' }} value="production">Produção</option>
                                        <option {{ old('stackmode') == 'development' ? 'selected' : '' }} value="development">Desenvolvimento</option>
                                    </select>
                                    @if($errors->has('stackmode'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('stackmode') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('php') ? ' has-danger' : '' }}">
                                    <label for="php">Versão PHP</label>
                                    <select name="php" id="php" class="form-control">
                                        <option value="" selected disabled>Selecione</option>
                                        @foreach($php_versions as $php)
                                            <option {{ old('php') == $php ? 'selected' : '' }} value="{{$php}}">{{$php}}</option>
                                        @endforeach
                                    </select>
            
                                    @if($errors->has('php'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('php') }}
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
if($('.form-check-input').is(":checked")){
    $('.user-select').show('slow').prop( "disabled", false );
    $('.user-input').hide().prop( "disabled", true );
}else{
    $('.user-select').hide().prop( "disabled", true);
    $('.user-input').show('slow').prop( "disabled", false);
}
$('.form-check-input').on('click',function(){
    if($(this).is(":checked")){
        $('.user-select').show('slow').prop( "disabled", false );
        $('.user-input').hide().prop( "disabled", true );
    }else{
        $('.user-select').hide().prop( "disabled", true);
        $('.user-input').show('slow').prop( "disabled", false);
    }
})
$('.mask-name').mask('ZZZZZZZZZZZZZZZZZZZZ', {
    translation: {
        'Z': {
        pattern: /[a-zA-Z0-9-_]/, optional: true
        }
    }
});
</script>
@endpush