@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'suser.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item active" aria-current="page">Usuários</li>
            </ol>
        </nav>        
        <div class="row">   
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title">Usuários</h5>
                                <p class="card-category">Lista dos usuários do seu servidor.</p>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('suser.create',request()->id) }}" class="btn btn-success"><i class="fas fa-user mr-1"></i> Criar Usuário</a>
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
                                            <a class="mr-3 database-update-user" href="{{ route('suser.update',['id'=> request()->id, 'idus' => $user['id']]) }}" data-toggle="modal" data-target="#modalPass"><i class="fas fa-edit"></i></a>
                                            <a class="database-remove-user" href="{{ route('suser.destroy',['id'=> request()->id, 'idus' => $user['id']]) }}"><i class="fas fa-trash-alt"></i></a>
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
    <div class="modal fade" id="modalPass" tabindex="-1" role="dialog" >
        <form action="#" method="GET" class="modal-dialog action-update-user" role="document">
            @csrf

            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atualizar senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12 form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password">Senha</label>
                    <input name="password" id="password" type="password" class="form-control" placeholder="Digite a senha">
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
                <div class="col-sm-12 form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                    <label for="password_confirmation">Confirmar Senha</label>
                    <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" placeholder="Confirme a senha">
                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" style="display: block;" role="alert">
                            {{ $errors->first('password_confirmation') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Atualizar">
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

@if ($errors->has('username'))
    $.notify({
        // options
        title: '<strong>Mensagem do sistema</strong>',
        message: '{{ $errors->first('username') }}'
    },{
        // settings
        type: 'warning',
        placement: {
            from: "bottom",
            align: "center"
        }
    });
@endif

@if ($errors->has('password'))
    $.notify({
        // options
        title: '<strong>Mensagem do sistema</strong>',
        message: '{{ $errors->first('password') }}'
    },{
        // settings
        type: 'warning',
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

$('.database-remove-user').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer remover este usuário?')){
        window.location.href = $(this).attr('href');
    }
});

$('.database-attach').on('click',function(e){
    e.preventDefault();
    $('.action-attach-user').attr('action',$(this).attr('href'));
});

$('.database-update-user').on('click',function(e){
    e.preventDefault();
    $('.action-update-user').attr('action',$(this).attr('href'));
});

</script>
@endpush