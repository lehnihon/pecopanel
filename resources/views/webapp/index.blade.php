@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'webapp.index'
])

@section('content')
    <div class="content">       
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Servidores</h5>
                        <p class="card-category">Escolha o Servidor</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        IP
                                    </th>
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        SO
                                    </th>
                                    <th>
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($servers as $server)
                                    <tr>
                                        <td>
                                            {{$server->server_id}}
                                        </td>
                                        <td>
                                            {{$server->server_ip}}
                                        </td>
                                        <td>
                                            {{$server->server_name}}
                                        </td>
                                        <td>
                                            {{$server->server_os}}
                                        </td>
                                        <td>
                                            <a class="mr-2" href="{{ route('webapp.list',$server->server_id) }}">
                                                <i class="nc-icon nc-zoom-split"></i>
                                            </a>
                                            <a href="{{ route('webapp.create',$server->server_id) }}">
                                                <i class="nc-icon nc-simple-add"></i>
                                            </a>
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