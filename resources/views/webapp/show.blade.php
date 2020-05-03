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
                    <div class="card-header ">
                        <h3 class="card-title">{{$webapp['name']}}</h3>
                        <p class="card-category">#{{$webapp['id']}}</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Caminho Raiz</th>
                                    <td>{{$webapp['rootPath']}}</td>
                                </tr>
                                <tr>
                                    <th>Caminho Público</th>
                                    <td>{{$webapp['rootPath']}}</td>
                                </tr>
                                <tr>
                                    <th>Tipo</th>
                                    <td>{{$webapp['type']}}</td>
                                </tr>
                                <tr>
                                    <th>Stack</th>
                                    <td>{{$webapp['stack']}}</td>
                                </tr>
                                <tr>
                                    <th>Modo Stack</th>
                                    <td>{{$webapp['stackMode']}}</td>
                                </tr>
                                <tr>
                                    <th>Data de Criação</th>
                                    <td>{{$webapp['created_at']}}</td>
                                </tr>
                            </tbody>
                        </table>
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
</script>
@endpush