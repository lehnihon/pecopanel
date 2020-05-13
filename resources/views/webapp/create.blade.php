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
                                        <input name="user-check" class="user-check form-check-input" {{old('user-check') ? 'checked' : ''}} type="checkbox">
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
                                            @if($user['username'] != 'runcloud') 
                                            <option {{ old('user') == $user['id'] ? 'selected' : '' }} value="{{$user['id']}}">{{$user['username']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <input name="user" id="user" type="text" class="form-control user-input mask-name" placeholder="Digite o usuário" value="{{ old('user') }}">
                                    @if($errors->has('user'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('user') }}
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
                                <div class="w-100"></div>
                                <div class="form-check col-sm-6 pt-4 mb-5">
                                    <label class="form-check-label">
                                        <input {{old('advanced') ? 'checked' : ''}}  name="advanced" class="advanced-btn form-check-input" type="checkbox" value="1">
                                        Configurações avançadas
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="advanced-box row" style="display:none">
                                <div class="col-sm-12 my-3">
                                    <h5>Nginx Settings</h5>
                                </div>   
                                <div class="form-check col-sm-6 mb-3">
                                    <label class="form-check-label">
                                        <input {{ old('clickjackingProtection',1) ?'checked':''}}  name="clickjackingProtection" class="form-check-input" type="checkbox" value="1">
                                        Proteção Clickjacking
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check col-sm-6 mb-3">
                                    <label class="form-check-label">
                                        <input {{old('xssProtection',1)?'checked':''}}  name="xssProtection" class="form-check-input" type="checkbox" value="1">
                                        Proteção Cross-site scripting (XSS)
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-check col-sm-6 pt-4 mb-3">
                                    <label class="form-check-label">
                                        <input {{old('mimeSniffingProtection',1) ?'checked':''}}  name="mimeSniffingProtection" class="form-check-input" type="checkbox" value="1">
                                        Proteção Mime sniffing
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 my-3">
                                    <h5>Configurações FPM</h5>
                                </div>   
                                <div class="col-sm-6 form-group{{ $errors->has('processManager') ? ' has-danger' : '' }}">
                                    <label for="processManager">Gerente de Processo</label>
                                    <select name="processManager" id="stackmode" class="form-control">
                                        <option {{ old('processManager') == 'dynamic' ? 'selected' : '' }} value="dynamic">Dynamic</option>
                                        <option {{ old('processManager','ondemand') == 'ondemand' ? 'selected' : '' }} value="ondemand">Ondemand</option>
                                        <option {{ old('processManager') == 'static' ? 'selected' : '' }} value="static">Static</option>
                                    </select>
                                    @if($errors->has('processManager'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('processManager') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-sm-6 form-group{{ $errors->has('processManagerMaxChildren') ? ' has-danger' : '' }}">
                                    <label for="processManagerMaxChildren">pm.max_children</label>
                                    <input name="processManagerMaxChildren" id="processManagerMaxChildren" type="text" class="form-control" value="{{old('processManagerMaxChildren','50') }}" >
                                    @if ($errors->has('processManagerMaxChildren'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('processManagerMaxChildren') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-sm-6 form-group{{ $errors->has('processManagerMaxRequests') ? ' has-danger' : '' }}">
                                    <label for="processManagerMaxRequests">pm.max_requests</label>
                                    <input name="processManagerMaxRequests" id="processManagerMaxRequests" type="text" class="form-control" value="{{ old('processManagerMaxRequests','500')}}" >
                                    @if ($errors->has('processManagerMaxRequests'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('processManagerMaxRequests') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-sm-12 my-3">
                                    <h5>Configurações PHP</h5>
                                </div>
                                <div class="col-sm-12 form-group{{ $errors->has('disableFunctions') ? ' has-danger' : '' }}">
                                    <label for="disableFunctions">Desabilitar Funções</label>
                                    <textarea name="disableFunctions" class="form-control px-3" cols="30" rows="5">{{old('disableFunctions')}}</textarea>
                                    @if ($errors->has('disableFunctions'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('disableFunctions') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('maxExecutionTime') ? ' has-danger' : '' }}">
                                    <label for="maxExecutionTime">max_execution_time</label>
                                    <input name="maxExecutionTime" id="maxExecutionTime" type="text" class="form-control" value="{{ old('maxExecutionTime','30') }}" >
                                    @if ($errors->has('maxExecutionTime'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('maxExecutionTime') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('maxInputTime') ? ' has-danger' : '' }}">
                                    <label for="maxInputTime">max_input_time</label>
                                    <input name="maxInputTime" id="maxInputTime" type="text" class="form-control" value="{{ old('maxInputTime','60') }}" >
                                    @if ($errors->has('maxInputTime'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('maxInputTime') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('maxInputVars') ? ' has-danger' : '' }}">
                                    <label for="maxInputVars">max_input_vars</label>
                                    <input name="maxInputVars" id="maxInputVars" type="text" class="form-control" value="{{ old('maxInputVars','1000') }}" >
                                    @if ($errors->has('maxInputVars'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('maxInputVars') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('memoryLimit') ? ' has-danger' : '' }}">
                                    <label for="memoryLimit">memory_limit</label>
                                    <input name="memoryLimit" id="memoryLimit" type="text" class="form-control" value="{{ old('memoryLimit','256') }}" >
                                    @if ($errors->has('memoryLimit'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('memoryLimit') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('postMaxSize') ? ' has-danger' : '' }}">
                                    <label for="postMaxSize">post_max_size (Nginx e PHP)</label>
                                    <input name="postMaxSize" id="postMaxSize" type="text" class="form-control" value="{{ old('postMaxSize','256') }}" >
                                    @if ($errors->has('postMaxSize'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('postMaxSize') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('uploadMaxFilesize') ? ' has-danger' : '' }}">
                                    <label for="uploadMaxFilesize">upload_max_filesize</label>
                                    <input name="uploadMaxFilesize" id="uploadMaxFilesize" type="text" class="form-control" value="{{ old('uploadMaxFilesize','256') }}" >
                                    @if ($errors->has('uploadMaxFilesize'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('uploadMaxFilesize') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('sessionGcMaxlifetime') ? ' has-danger' : '' }}">
                                    <label for="sessionGcMaxlifetime">session.gc_maxlifetime</label>
                                    <input name="sessionGcMaxlifetime" id="sessionGcMaxlifetime" type="text" class="form-control" value="{{ old('sessionGcMaxlifetime','1440') }}" >
                                    @if ($errors->has('sessionGcMaxlifetime'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            {{ $errors->first('sessionGcMaxlifetime') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-check col-sm-6 mb-3 pt-4">
                                    <label class="form-check-label">
                                        <input {{old('allowUrlFopen',1)?'checked':''}} name="allowUrlFopen" class="form-check-input" type="checkbox" value="1">
                                        allow_url_fopen
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                    </label>
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
if($('.user-check').is(":checked")){
    $('.user-select').show('slow').prop( "disabled", false );
    $('.user-input').hide().prop( "disabled", true );
}else{
    $('.user-select').hide().prop( "disabled", true);
    $('.user-input').show('slow').prop( "disabled", false);
}
$('.user-check').on('click',function(){
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

$('.advanced-btn').on('click',function(e){
    if($(this).is(':checked')){
        $('.advanced-box').show();
    }else{
        $('.advanced-box').hide();
    }
})
</script>
@endpush