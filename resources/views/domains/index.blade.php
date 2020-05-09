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
                <li class="breadcrumb-item active" aria-current="page">Domínios</li>
            </ol>
        </nav>        
        <div class="row">   
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title">Domínios</h5>
                                <p class="card-category">Lista de domínios vinculadas á essa aplicação web</p>
                            </div>
                            <div class="ml-auto">
                                <a href="#" data-toggle="modal" data-target="#modalDomain" class="btn btn-success"><i class="fas fa-network-wired"></i></i> Vincular Domínio</a>
                            </div>                         
                            
                        </div>       
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Data
                                    </th>
                                    <th>
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($domains as $domain)   
                                    <tr>
                                        <td>
                                            {{$domain['id']}}
                                        </td>
                                        <td>
                                            {{$domain['name']}}
                                        </td>
                                        <td>
                                            {{ date("d/m/Y H:i:s", strtotime($domain['created_at']))}}
                                        </td>
                                        <td>
                                        <a class="domain-remove" href="{{ route('webapp.domain.destroy',['id'=> request()->id, 'idwa' => request()->idwa, 'domain' => $domain['id']]) }}"><i class="fas fa-unlink"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDomain" tabindex="-1" role="dialog" >
        <form action="{{ route('webapp.domain.store',['id'=> request()->id, 'idwa' => request()->idwa]) }}" method="POST" class="modal-dialog" role="document">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vincular domínio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 form-group{{ $errors->has('domain') ? ' has-danger' : '' }}">
                        <label for="domain">Domínio</label>
                        <input name="domain" id="domain" type="domain" class="form-control" placeholder="Domínio">
                        @if ($errors->has('domain'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                {{ $errors->first('domain') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Vincular">
                </div>
            </div>
        </form>
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

@if ($errors->has('domain'))
    $.notify({
        // options
        title: '<strong>Mensagem do sistema</strong>',
        message: '{{ $errors->first('domain') }}'
    },{
        // settings
        type: 'warning',
        placement: {
            from: "bottom",
            align: "center"
        }
    });
@endif

$('.domain-remove').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer desvincular este domínio?')){
        window.location.href = $(this).attr('href');
    }
});
</script>
@endpush