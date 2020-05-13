@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'connect.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </nav>          
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title">Usuários</h5>
                                <p class="card-category">Lista de Usuários</p>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('user.create',request()->id) }}" class="btn btn-success"><i class="nc-icon nc-single-02"></i> Criar Usuário</a>
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
                                        Email
                                    </th>
                                    <th>
                                        Função
                                    </th>
                                    <th>
                                        Data
                                    </th>
                                    <th>
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            {{$user->id}}
                                        </td>
                                        <td>
                                            {{$user->name}}
                                        </td>
                                        <td>
                                            {{$user->email}}
                                        </td>
                                        <td>
                                            {{$user->role->name}}
                                        </td>
                                        <td>
                                            {{ date("d/m/Y H:i:s", strtotime($user['created_at']))}}
                                        </td>
                                        <td>
                                            <a data-toggle="modal" data-target="#modalConnect"  class="mr-2 btn-modal" href="{{ route('user.connect.store',['user' => $user->id]) }}">
                                                <i class="fas fa-link"></i>
                                            </a>
                                            <a href="{{ route('user.edit',$user->id) }}">
                                                <i class="fas fa-edit"></i>
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

    <!-- Modal -->
    <div class="modal fade" id="modalConnect" tabindex="-1" role="dialog" >
        <form action="#" method="POST" class="modal-dialog action-connect-user" role="document">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vincular Servidor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 form-group{{ $errors->has('server') ? ' has-danger' : '' }}">
                        <label for="server">Servidor</label>
                        <select name="server" id="server" class="form-control">
                            <option selected disabled value="">Selecione</option>
                            @foreach($servers as $server)
                                <option {{ old('server') == $server['id'] ? 'selected' : '' }} value="{{$server['id']}}">{{$server['name']}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('server'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                {{ $errors->first('server') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-sm-12 form-group{{ $errors->has('obs') ? ' has-danger' : '' }}">
                        <label for="obs">Observações</label>
                        <textarea name="obs" id="obs" class="form-control px-3" rows="3">{{ old('obs') }}</textarea>
                        @if ($errors->has('obs'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                {{ $errors->first('password') }}
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

@if ($errors->has('server'))
    $.notify({
        // options
        title: '<strong>Mensagem do sistema</strong>',
        message: '{{ $errors->first('server') }}'
    },{
        // settings
        type: 'warning',
        placement: {
            from: "bottom",
            align: "center"
        }
    });
@endif


$('.btn-modal').on('click',function(e){
    e.preventDefault();
    $('.action-connect-user').attr('action',$(this).attr('href'));
});
</script>
@endpush