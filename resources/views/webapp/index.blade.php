@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'webapp.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item active" aria-current="page">Aplicativos Web</li>
            </ol>
        </nav>        
        <div class="row">   
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title">Aplicações Web</h5>
                                <p class="card-category">Lista de aplicações web</p>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('webapp.create',request()->id) }}" class="btn btn-success"><i class="nc-icon nc-laptop mr-1"></i> Criar Aplicação</a>
                            </div>                         
                            
                        </div>       
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th></th>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Tipo
                                    </th>
                                    <th>
                                        Versão PHP
                                    </th>
                                    <th>
                                        Stack
                                    </th>
                                    <th>
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($webapps as $webapp)   
                                    <tr>
                                        <td class="px-0">{!!($webapp['defaultApp'])?'<i class="fas fa-star"></i>':''!!}</td>
                                        <td>
                                            <a href="{{ route('webapp.show',['id'=> request()->id, 'idwa' => $webapp['id']]) }}">
                                                {{$webapp['id']}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('webapp.show',['id'=> request()->id, 'idwa' => $webapp['id']]) }}">
                                                {{$webapp['name']}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$webapp['type']}}
                                        </td>
                                        <td>
                                            {{$webapp['phpVersion']}}
                                        </td>
                                        <td>
                                            {{$webapp['stackMode']}}
                                        </td>
                                        <td>
                                            <a href="{{ route('webapp.domain.index',['id'=> request()->id, 'idwa' => $webapp['id']]) }}"><i class="fas fa-link mr-3"></i></a>
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