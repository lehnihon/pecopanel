@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'connect.index'
])

@section('content')
    <div class="content">       
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Usuários</h5>
                        <p class="card-category">Lista de Usuários</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Vindi
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
                                            {{$user->vindi_id}}
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
                                            <a data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Associar usuário" class="mr-2" href="{{ route('subscription.connect.create',$user->vindi_id) }}">
                                                <i class="nc-icon nc-simple-add"></i>
                                            </a>
                                            <a data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Editar usuário" href="{{ route('user.edit',$user->id) }}">
                                                <i class="nc-icon nc-single-copy-04"></i>
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
$('[data-toggle="popover"]').popover()
</script>
@endpush