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
                <li class="breadcrumb-item active" aria-current="page">Ssl</li>
            </ol>
        </nav>    
        <div class="row">
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

$('.remove-ssl').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer remover o ssl?')){
        window.location.href= $(this).attr('href');;
    }
});

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