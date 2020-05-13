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
                <li class="breadcrumb-item active" aria-current="page">Editar</li>

            </ol>
        </nav>    
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">{{$webapp['name']}}</h3>
                        <p class="card-category">#{{$webapp['id']}}</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('webapp.update',['id'=> request()->id, 'idwa' => request()->idwa]) }}" class="row" method="POST">
                            @csrf
                            <div class="col-sm-6 form-group{{ $errors->has('stack') ? ' has-danger' : '' }}">
                                <label for="stack">Stack</label>
                                <select name="stack" id="stack" class="form-control">
                                    <option value="" selected disabled>Selecione</option>
                                    <option {{ old('stack',$webapp['stack']) == 'hybrid' ? 'selected' : '' }} value="hybrid">NGINX + Apache2 Híbrido (Você pode usar o .htaccess)</option>
                                    <option {{ (old('stack',$webapp['stack']) == 'nativenginx') ? 'selected' : '' }} value="nativenginx">NGINX Nativo (Você não pode usar o .htaccess, mas ele é mais rápido)</option>
                                    <option {{ old('stack',$webapp['stack']) == 'customnginx' ? 'selected' : '' }} value="customnginx">NGINX Nativo + Configurações customizadas (Implementação manual do NGINX)</option>
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
                                    <option {{ old('stackmode',$webapp['stackMode']) == 'production' ? 'selected' : '' }} value="production">Produção</option>
                                    <option {{ old('stackmode',$webapp['stackMode']) == 'development' ? 'selected' : '' }} value="development">Desenvolvimento</option>
                                </select>
                                @if($errors->has('stackmode'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('stackmode') }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-12 my-3">
                                <h5>Nginx Settings</h5>
                            </div>   
                            <div class="form-check col-sm-6 mb-3">
                                <label class="form-check-label">
                                    <input {{ old('clickjackingProtection',$setting['clickjackingProtection']) ?'checked':''}}  name="clickjackingProtection" class="form-check-input" type="checkbox" value="1">
                                    Proteção Clickjacking
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check col-sm-6 mb-3">
                                <label class="form-check-label">
                                    <input {{old('xssProtection',$setting['xssProtection'])?'checked':''}}  name="xssProtection" class="form-check-input" type="checkbox" value="1">
                                    Proteção Cross-site scripting (XSS)
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check col-sm-6 pt-4 mb-3">
                                <label class="form-check-label">
                                    <input {{old('mimeSniffingProtection',$setting['mimeSniffingProtection']) ?'checked':''}}  name="mimeSniffingProtection" class="form-check-input" type="checkbox" value="1">
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
                                    <option {{ old('processManager',$setting['processManager']) == 'dynamic' ? 'selected' : '' }} value="dynamic">Dynamic</option>
                                    <option {{ old('processManager',$setting['processManager']) == 'ondemand' ? 'selected' : '' }} value="ondemand">Ondemand</option>
                                    <option {{ old('processManager',$setting['processManager']) == 'static' ? 'selected' : '' }} value="static">Static</option>
                                </select>
                                @if($errors->has('processManager'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('processManager') }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6 form-group{{ $errors->has('processManagerMaxChildren') ? ' has-danger' : '' }}">
                                <label for="processManagerMaxChildren">pm.max_children</label>
                                <input name="processManagerMaxChildren" id="processManagerMaxChildren" type="text" class="form-control" value="{{old('processManagerMaxChildren',$setting['processManagerMaxChildren']) }}" >
                                @if ($errors->has('processManagerMaxChildren'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('processManagerMaxChildren') }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-sm-6 form-group{{ $errors->has('processManagerMaxRequests') ? ' has-danger' : '' }}">
                                <label for="processManagerMaxRequests">pm.max_requests</label>
                                <input name="processManagerMaxRequests" id="processManagerMaxRequests" type="text" class="form-control" value="{{ old('processManagerMaxRequests',$setting['processManagerMaxRequests'])}}" >
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
                                <textarea name="disableFunctions" class="form-control px-3" cols="30" rows="5">{{old('disableFunctions',$setting['disableFunctions'])}}</textarea>
                                @if ($errors->has('disableFunctions'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('disableFunctions') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6 form-group{{ $errors->has('maxExecutionTime') ? ' has-danger' : '' }}">
                                <label for="maxExecutionTime">max_execution_time</label>
                                <input name="maxExecutionTime" id="maxExecutionTime" type="text" class="form-control" value="{{ old('maxExecutionTime',$setting['maxExecutionTime']) }}" >
                                @if ($errors->has('maxExecutionTime'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('maxExecutionTime') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6 form-group{{ $errors->has('maxInputTime') ? ' has-danger' : '' }}">
                                <label for="maxInputTime">max_input_time</label>
                                <input name="maxInputTime" id="maxInputTime" type="text" class="form-control" value="{{ old('maxInputTime',$setting['maxInputTime']) }}" >
                                @if ($errors->has('maxInputTime'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('maxInputTime') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6 form-group{{ $errors->has('maxInputVars') ? ' has-danger' : '' }}">
                                <label for="maxInputVars">max_input_vars</label>
                                <input name="maxInputVars" id="maxInputVars" type="text" class="form-control" value="{{ old('maxInputVars',$setting['maxInputVars']) }}" >
                                @if ($errors->has('maxInputVars'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('maxInputVars') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6 form-group{{ $errors->has('memoryLimit') ? ' has-danger' : '' }}">
                                <label for="memoryLimit">memory_limit</label>
                                <input name="memoryLimit" id="memoryLimit" type="text" class="form-control" value="{{ old('memoryLimit',$setting['memoryLimit']) }}" >
                                @if ($errors->has('memoryLimit'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('memoryLimit') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6 form-group{{ $errors->has('postMaxSize') ? ' has-danger' : '' }}">
                                <label for="postMaxSize">post_max_size (Nginx e PHP)</label>
                                <input name="postMaxSize" id="postMaxSize" type="text" class="form-control" value="{{ old('postMaxSize',$setting['postMaxSize']) }}" >
                                @if ($errors->has('postMaxSize'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('postMaxSize') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6 form-group{{ $errors->has('uploadMaxFilesize') ? ' has-danger' : '' }}">
                                <label for="uploadMaxFilesize">upload_max_filesize</label>
                                <input name="uploadMaxFilesize" id="uploadMaxFilesize" type="text" class="form-control" value="{{ old('uploadMaxFilesize',$setting['uploadMaxFilesize']) }}" >
                                @if ($errors->has('uploadMaxFilesize'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('uploadMaxFilesize') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-sm-6 form-group{{ $errors->has('sessionGcMaxlifetime') ? ' has-danger' : '' }}">
                                <label for="sessionGcMaxlifetime">session.gc_maxlifetime</label>
                                <input name="sessionGcMaxlifetime" id="sessionGcMaxlifetime" type="text" class="form-control" value="{{ old('sessionGcMaxlifetime',$setting['sessionGcMaxlifetime']) }}" >
                                @if ($errors->has('sessionGcMaxlifetime'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('sessionGcMaxlifetime') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-check col-sm-6 mb-3 pt-4">
                                <label class="form-check-label">
                                    <input {{old('allowUrlFopen',$setting['allowUrlFopen'])?'checked':''}} name="allowUrlFopen" class="form-check-input" type="checkbox" value="1">
                                    allow_url_fopen
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-group col-sm-12">
                                <input type="submit" value="Atualizar" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">VERSÃO PHP</h3>
                        <p class="card-category">Altere a versão do php do seu webapp</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('webapp.php',['id'=> request()->id, 'idwa' => request()->idwa]) }}" method="POST">
                            @csrf
                            <div class="form-group{{ $errors->has('php') ? ' has-danger' : '' }}">
                                <label for="php">Alterar versão PHP</label>
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
                            <div class="form-group">
                                <input type="submit" value="Atualizar" class="btn btn-primary">
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
@if (session('status'))
    $.notify({
        // options
        title: '<strong>Mensagem do sistema</strong>',
        message: '{{ session('status') }}'
    },{
        // settings
        type: 'light',
        placement: {
            from: "bottom",
            align: "center"
        }
    });
@endif

</script>
@endpush