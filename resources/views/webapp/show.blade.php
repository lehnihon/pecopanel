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
                <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
            </ol>
        </nav>    
        <div class="row">
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card mb-0 h-100 p-4">
                    <a href="#" class="btn btn-primary webapp-default"><i class="fas fa-globe"></i> Padrão</a>   
                    <p class="mb-0 text-center">Acessar por endereço IP do servidor</p>
                </div>  
            </div>
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card mb-0 h-100 p-4">
                    <a href="#" class="btn btn-primary webapp-rebuild"><i class="fas fa-sync-alt mr-1"></i> Reconstruir</a>   
                    <p class="mb-0 text-center">Reconstrua a configuração do App</p>
                </div>  
            </div>
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card mb-0 h-100 p-4">
                    <a href="#" class="btn btn-primary webapp-destroy"><i class="fas fa-trash mr-1"></i> Deletar</a>   
                    <p class="mb-0 text-center">Exclusão dos arquivos deste servidor</p>
                </div>  
            </div>
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card mb-0 h-100 p-4">
                    @if(isset($wascript['message']))
                    <form action="{{ route('webapp.script',['id'=> request()->id, 'idwa' => request()->idwa]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="script">Instalar Script</label>
                            <select name="script" id="script" class="form-control">
                                <option value="" disabled="disabled" selected="selected">Selecione</option>
                                <option value="concrete5">Concrete5</option>
                                <option value="drupal">Drupal</option>
                                <option value="grav">Grav Core</option>
                                <option value="gravadmin">Grav Core + Admin Plugin</option>
                                <option value="joomla">Joomla</option>
                                <option value="myBB">MyBB</option>
                                <option value="octobercms">OctoberCMS</option>
                                <option value="phpBB">phpBB</option>
                                <option value="phpMyAdmin">phpMyAdmin</option>
                                <option value="piwik">Matomo (Piwik)</option>
                                <option value="prestaShop">PrestaShop</option>
                                <option value="wordpress">WordPress</option>
                            </select>
                            @if ($errors->has('script'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    {{ $errors->first('script') }}
                                </span>
                            @endif
                        </div>

                        <div class="text-center">
                            <input type="submit" value="Instalar" class="btn btn-success">
                        </div>
                    </form>
                    @else
                        <a href="#" class="script-remove btn btn-danger"><i class="fas fa-minus-circle mr-1"></i> Remover</a>
                        <p class="mb-0 text-center">Remover script deste servidor</p>
                    @endif
                </div>  
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h3 class="card-title">SSL/TLS</h3>
                                <p class="card-category">Você pode escolher entre o ssl grátis ou usar o próprio</p>
                            </div>
                            @if(!isset($ssl['message']))
                                <div class="ml-auto">
                                    <a class="d-inline-block p-3" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Certificado válido até:  {{ date("d/m/Y H:i:s", strtotime($ssl['validUntil']))}}, Certificado renovação: {{ date("d/m/Y H:i:s", strtotime($ssl['renewalDate']))}}, Método de autorização: {{$ssl['authorizationMethod']}}"  href="#">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('webapp.ssl.destroy',['id'=> request()->id, 'idwa' => request()->idwa, 'idssl' => $ssl['id']]) }}" class="remove-ssl btn btn-success"><i class="fas fa-trash mr-1"></i> Remover Ssl</a>
                                </div>                         
                            @endif
                        </div> 
                    </div>
                    @if(isset($ssl['message']))

                    <div class="card-body">
                        <form action="{{ route('webapp.ssl.store',['id'=> request()->id, 'idwa' => request()->idwa]) }}" method="POST" class="row">
                            @csrf
                            <div class="form-check col-lg-4 mb-2">
                                <label class="form-check-label">
                                    <input name="enableHttp" class="form-check-input" type="checkbox" value="1">
                                    Ativar acesso HTTP
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check col-lg-4 mb-2">
                                <label class="form-check-label">
                                    <input name="enableHsts" class="form-check-input" type="checkbox" value="1">
                                    Ativar HSTS
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <div class="form-check form-check-radio form-check-inline">
                                    <label class="form-check-label">
                                        <input checked class="form-check-input provider" type="radio" name="provider" id="inlineRadio1" value="letsencrypt"> Let's Encrypt
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                <div class="form-check form-check-radio form-check-inline">
                                    <label class="form-check-label">
                                        <input class="form-check-input provider" type="radio" name="provider" id="inlineRadio2" value="custom"> Customizado
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-2">
                                <label for="ssl_protocol_id">Protocolo SSL</label>
                                <select name="ssl_protocol_id" id="ssl_protocol_id" class="form-control">
                                    <option selected disabled value="">Selecione</option>
                                    <option value="1">TLSv1.1 TLSv1.2 TLSv1.3</option>
                                    <option value="2">TLSv1.2 TLSv1.3</option>
                                    <option value="3">TLSv1.3</option>
                                </select>
                                @if($errors->has('ssl_protocol_id'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('ssl_protocol_id') }}
                                    </span>
                                @endif                         
                            </div>
                            <div class="col-lg-4 mb-2 letsencrypt">
                                <label for="authorizationMethod">Método de autorização</label>
                                <select name="authorizationMethod" id="authorizationMethod" class="form-control">
                                    <option selected disabled value="">Selecione</option>
                                    <option value="http-01">http-01 (Let's Encrypt tentará validar arquivos dentro do seu servidor)</option>
                                    <option value="dns-01">dns-01 (Let's Encrypt validará o registro DNS. Portanto, precisa da sua chave de API)</option>
                                </select>
                                @if($errors->has('authorizationMethod'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('authorizationMethod') }}
                                    </span>
                                @endif
                         
                            </div>

                            <div class="col-lg-4 mb-2 letsencrypt">
                                <label for="environment">Ambiente Let's Encrypt</label>
                                <select name="environment" id="environment" class="form-control">
                                    <option selected disabled value="">Selecione</option>
                                    <option value="live">Live - Certificado SSL real para o site ativo (Assine por Let's Encrypt Authority)</option>
                                    <option value="staging">Staging - Falso certificado SSL Let's Encrypt para fins de teste (Assine por Fake LE CA)</option>
                                </select>
                                @if($errors->has('environment'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('environment') }}
                                    </span>
                                @endif                         
                            </div>

                            <div class="col-lg-4 mb-2 custom" style="display:none">
                                <label for="privateKey">Chave Privada</label>
                                <textarea name="privateKey" id="privateKey" rows="2" placeholder="" class="px-3 form-control"></textarea>
                                @if($errors->has('privateKey'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('privateKey') }}
                                    </span>
                                @endif 
                            </div>

                            <div class="col-lg-4 mb-2 custom" style="display:none">
                                <label for="certificate">Certificado</label>
                                <textarea name="certificate" id="certificate" rows="2" placeholder="" class="px-3 form-control"></textarea>
                                @if($errors->has('certificate'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        {{ $errors->first('certificate') }}
                                    </span>
                                @endif 
                            </div>
                            <div class="col-lg-12 mb-2 form-group">
                                <input type="submit" value="Instalar" class="btn btn-primary">
                            </div>
                        </form>
                    </div>

                    @else
                        @if($ssl['method'] == 'letsencrypt')
                            <div class="card-body">
                                <form action="{{ route('webapp.ssl.update',['id'=> request()->id, 'idwa' => request()->idwa, 'idssl' => $ssl['id']]) }}" method="POST" class="row">
                                    @csrf

                                    <input type="hidden" name="method" value="{{$ssl['method']}}">

                                    <div class="form-check col-lg-4 mb-2">
                                        <label class="form-check-label">
                                            <input {{($ssl['enableHttp'])? 'checked': ''}} name="enableHttp" class="form-check-input" type="checkbox" value="1">
                                            Ativar acesso HTTP 
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-check col-lg-4 mb-2">
                                        <label class="form-check-label">
                                            <input {{($ssl['enableHsts'])? 'checked': ''}} name="enableHsts" class="form-check-input" type="checkbox" value="1">
                                            Ativar HSTS
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="ssl_protocol_id">Protocolo SSL</label>
                                        <select name="ssl_protocol_id" id="ssl_protocol_id" class="form-control">
                                            <option selected disabled value="">Selecione</option>
                                            <option {{($ssl['ssl_protocol_id'] == '1')? 'selected': ''}} value="1">TLSv1.1 TLSv1.2 TLSv1.3</option>
                                            <option {{($ssl['ssl_protocol_id'] == '2')? 'selected': ''}} value="2">TLSv1.2 TLSv1.3</option>
                                            <option {{($ssl['ssl_protocol_id'] == '3')? 'selected': ''}} value="3">TLSv1.3</option>
                                        </select>
                                        @if($errors->has('ssl_protocol_id'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                {{ $errors->first('ssl_protocol_id') }}
                                            </span>
                                        @endif                         
                                    </div>
                                    <div class="col-lg-12 mb-2 form-group">
                                        <input type="submit" value="Atualizar" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="card-body">
                                <form action="{{ route('webapp.ssl.update',['id'=> request()->id, 'idwa' => request()->idwa, 'idssl' => $ssl['id']]) }}" method="POST" class="row">
                                    @csrf

                                    <input type="hidden" name="method" value="{{$ssl['method']}}">

                                    <div class="form-check col-lg-4 mb-2">
                                        <label class="form-check-label">
                                            <input {{($ssl['enableHttp'])? 'checked': ''}} name="enableHttp" class="form-check-input" type="checkbox" value="1">
                                            Ativar acesso HTTP 
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-check col-lg-4 mb-2">
                                        <label class="form-check-label">
                                            <input {{($ssl['enableHsts'])? 'checked': ''}} name="enableHsts" class="form-check-input" type="checkbox" value="1">
                                            Ativar HSTS
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-4 mb-2">
                                        <label for="ssl_protocol_id">Protocolo SSL</label>
                                        <select name="ssl_protocol_id" id="ssl_protocol_id" class="form-control">
                                            <option selected disabled value="">Selecione</option>
                                            <option {{($ssl['ssl_protocol_id'] == '1')? 'selected': ''}} value="1">TLSv1.1 TLSv1.2 TLSv1.3</option>
                                            <option {{($ssl['ssl_protocol_id'] == '2')? 'selected': ''}} value="2">TLSv1.2 TLSv1.3</option>
                                            <option {{($ssl['ssl_protocol_id'] == '3')? 'selected': ''}} value="3">TLSv1.3</option>
                                        </select>
                                        @if($errors->has('ssl_protocol_id'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                {{ $errors->first('ssl_protocol_id') }}
                                            </span>
                                        @endif                         
                                    </div>
                                    <div class="col-lg-4 mb-2 custom">
                                        <label for="privateKey">Chave Privada</label>
                                        <textarea name="privateKey" id="privateKey" rows="2" placeholder="" class="px-3 form-control">{{$ssl['privateKey']}}</textarea>
                                        @if($errors->has('privateKey'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                {{ $errors->first('privateKey') }}
                                            </span>
                                        @endif 
                                    </div>

                                    <div class="col-lg-4 mb-2 custom">
                                        <label for="certificate">Certificado</label>
                                        <textarea name="certificate" id="certificate" rows="2" placeholder="" class="px-3 form-control">{{$ssl['certificate']}}</textarea>
                                        @if($errors->has('certificate'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                {{ $errors->first('certificate') }}
                                            </span>
                                        @endif 
                                    </div>
                                    <div class="col-lg-12 mb-2 form-group">
                                        <input type="submit" value="Atualizar" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

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

$('.script-remove').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer remover o script?')){
        window.location.href= '{{
            (isset($wascript['id'])) ? route('webapp.script.destroy',['id'=> request()->id, 'idwa' => request()->idwa, 'script' => $wascript['id']]) : ""}}'
    }
});
$('.webapp-rebuild').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer reconstruir?')){
        window.location.href= '{{route('webapp.rebuild',['id'=> request()->id,'idwa' => request()->idwa])}}';
    }
});
$('.webapp-destroy').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer remover a aplicação web?')){
        window.location.href= '{{route('webapp.destroy',['id'=> request()->id,'idwa' => request()->idwa])}}';
    }
});
$('.webapp-default').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer definir essa aplicação para padrão?')){
        window.location.href= '{{route('webapp.default',['id'=> request()->id,'idwa' => request()->idwa])}}';
    }
});

$('.remove-ssl').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer remover o ssl?')){
        window.location.href= $(this).attr('href');;
    }
});

$('[data-toggle="popover"]').popover();

$('.provider').on('click', function(){
    if($(this).val() == 'custom'){
        $('.letsencrypt').hide();
        $('.custom').show();
    }else{
        $('.custom').hide();
        $('.letsencrypt').show();
    }
})
</script>
@endpush