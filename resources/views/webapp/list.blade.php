@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'webapp.index'
])

@section('content')
    <div class="content">       
        <div class="row">
            @foreach ($webapps as $webapp)                   
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header ">
                            <h5 class="card-title">#{{$webapp['id']}}</h5>
                            <p class="card-category">{{$webapp['name']}}</p>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>
                                        Tipo
                                    </th>
                                    <td>
                                        {{$webapp['type']}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Versão PHP
                                    </th>
                                    <td>
                                        {{$webapp['phpVersion']}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Stack
                                    </th>
                                    <td>
                                        {{$webapp['stack']}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Modo Stack
                                    </th>
                                    <td>
                                        {{$webapp['stackMode']}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Diretório Raiz
                                    </th>
                                    <td>
                                        {{$webapp['rootPath']}}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Diretório Público
                                    </th>
                                    <td>
                                        {{$webapp['publicPath']}}
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