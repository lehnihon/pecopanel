@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'ssh.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chave SSH</li>
            </ol>
        </nav>        
        <div class="row">   
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title">Chave SSH</h5>
                                <p class="card-category">Lista dos chaves ssh.</p>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('ssh.create',request()->id) }}" class="btn btn-success"><i class="mr-1 fas fa-key"></i> Criar Chave</a>
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
                                        Rótulo
                                    </th>
                                    <th>
                                        Usuário
                                    </th>
                                    <th>
                                        Data
                                    </th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($sshs as $ssh)   
                                    <tr>
                                        <td>
                                            {{$ssh['id']}}
                                        </td>
                                        <td>
                                            {{$ssh['label']}}
                                        </td>
                                        <td>
                                            <a href="{{route('suser.show',['id' => request()->id, 'user' => $ssh['user_id']])}}">
                                                {{$ssh['user_id']}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$ssh['created_at']}}
                                        </td>
                                        <td>
                                            <a class="database-remove-user" href="{{ route('suser.destroy',['id'=> request()->id, 'idus' => $ssh['id']]) }}"><i class="fas fa-trash-alt"></i></a>
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

$('.database-remove').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer remover este banco de dados?')){
        window.location.href = $(this).attr('href');
    }
});

</script>
@endpush