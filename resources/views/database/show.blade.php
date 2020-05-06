@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'database.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item"><a href="{{ route('database.index',request()->id) }}">Bancos de dados</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
            </ol>
        </nav>    
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">{{$database['name']}}</h3>
                        <p class="card-category">#{{$database['id']}}</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Collation</th>
                                    <td>{{$database['collation']}}</td>
                                </tr>
                                <tr>
                                    <th>Data</th>
                                    <td>{{ date("d/m/Y H:i:s", strtotime($database['created_at']))}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header">
                        <h5 class="card-title">Usuários</h5>
                        <p class="card-category">Usuários vinculados</p>           
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
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)   
                                    <tr>
                                        <td>
                                            {{$user['id']}}
                                        </td>
                                        <td>
                                            {{$user['username']}}
                                        </td>
                                        <td>
                                            {{ date("d/m/Y H:i:s", strtotime($user['created_at']))}}
                                        </td>
                                        <td>
                                            <a class="database-remove-user" href="{{ route('database.revoke.user',['id'=> request()->id, 'iddb' => $database['id'] , 'user' => $user['id']]) }}"><i class="fas fa-unlink"></i></a>
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

$('.database-remove-user').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer revogar o acesso deste usuário?')){
        window.location.href = $(this).attr('href');
    }
});

</script>
@endpush