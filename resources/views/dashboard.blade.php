@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'home.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Servidores</li>
            </ol>
        </nav>  
        <div class="row">
            @foreach ($servers as $server)                   
                <div class="col-lg-4 col-sm-6">
                    <div class="card ">
                        <a href="{{ route('server.show',$server->server_id) }}" class="card-header ">
                            <h5 class="card-title">#{{$server->server_id}}</h5>
                            <p class="card-category">{{$server->server_name}}</p>
                        </a>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>
                                        IP
                                    </th>
                                    <td>
                                        {{$server->server_ip}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Server OS
                                    </th>
                                    <td>
                                        {{$server->server_os}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Assinatura
                                    </th>
                                    <td>
                                        <a href="{{ route('subscription.show',$server->subscription_id) }}">
                                            #{{$server->subscription_id}}
                                        </a>
                                    </td>
                                </tr>
                               
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
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