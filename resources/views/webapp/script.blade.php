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
                <li class="breadcrumb-item active" aria-current="page">Script</li>
            </ol>
        </nav>    
        <div class="row">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Instalador de script</h3>
                        <p class="card-category">Instale seus scripts favoritos em pouco tempo. A instalação de um script excluirá todos os arquivos e pastas dentro do seu aplicativo da web.</p>    
                    </div>
                    <div class="card-body">
                        @if(isset($wascript['message']))
                        <form action="{{ route('webapp.script.store',['id'=> request()->id, 'idwa' => request()->idwa]) }}" method="POST">
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
                            <div class="text-center">
                            <a href="#" class="script-remove btn btn-danger"><i class="fas fa-minus-circle mr-1"></i> Remover</a>
                            <p class="mb-0">Remover script deste servidor</p>
                            </div>
                        @endif 
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

</script>
@endpush