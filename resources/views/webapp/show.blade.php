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

                <li class="ml-auto">
                    <div class="dropdown config-webapp">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ferramentas<i class="fas fa-tools ml-2"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item webapp-default" href="{{route('webapp.default',['id'=> request()->id,'idwa' => request()->idwa])}}">Definir como padrão</a>
                            <a class="dropdown-item webapp-rebuild" href="{{route('webapp.rebuild',['id'=> request()->id,'idwa' => request()->idwa])}}">Reconstruir</a>
                            <a class="dropdown-item webapp-destroy text-danger" href="#">Remover app</a>
                        </div>
                    </div>
                </li>
            </ol>
        </nav>    
        <div class="row">
            <div class="col-sm-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-server mr-2"></i> {{$webapp['id']}}</h4>
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
                                    <td>{{$webapp['publicPath']}}</td>
                                </tr>
                                <tr>
                                    <th>Versão PHP</th>
                                    <td>{{$webapp['phpVersion']}}</td>
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
                                    <th>Data</th>
                                    <td>{{ date("d/m/Y H:i:s", strtotime($webapp['created_at']))}}</td>
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


$('.webapp-destroy').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer remover a aplicação web?')){
        window.location.href= '{{route('webapp.destroy',['id'=> request()->id,'idwa' => request()->idwa])}}';
    }
});

$('[data-toggle="popover"]').popover();

</script>
@endpush