@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'server.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
            </ol>
        </nav>    
        <div class="row">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Servidor</h5>
                        <p class="card-category">Detalhes</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>NOME</th>
                                    <td>{{$server['name']}}</td>
                                </tr>
                                <tr>
                                    <th>IP</th>
                                    <td>{{$server['ipAddress']}}</td>
                                </tr>
                                <tr>
                                    <th>SISTEMA OPERACIONAL</th>
                                    <td>{{$server['os']}}</td>
                                </tr>
                                <tr>
                                    <th>VERSÃO PHP</th>
                                    <td>{{$server['phpCLIVersion']}}</td>
                                </tr>
                                <tr>
                                    <th>STATUS</th>
                                    <td>@if($server['online'] == 'true') <span class='text-success'>ONLINE</span> @else <span class='text-danger'>OFFLINE</span> @endif</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Hardware</h5>
                        <p class="card-category">Informações</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>PROCESSADOR</th>
                                    <td>{{$hardware['processorName']}}</td>
                                </tr>
                                <tr>
                                    <th>NÚCLEOS</th>
                                    <td>{{$hardware['totalCPUCore']}}</td>
                                </tr>
                                <tr>
                                    <th>MEMÓRIA TOTAL</th>
                                    <td>{{round($hardware['totalMemory'],2)}}GB</td>
                                </tr>
                                <tr>
                                    <th>MEMÓRIA LIVRE</th>
                                    <td>{{round($hardware['freeMemory'],2)}}GB</td>
                                </tr>
                                <tr>
                                    <th>HD TOTAL</th>
                                    <td>{{round($hardware['diskTotal'],2)}}GB</td>
                                </tr>
                                <tr>
                                    <th>HD LIVRE</th>
                                    <td>{{round($hardware['diskFree'],2)}}GB</td>
                                </tr>
                                <tr>
                                    <th>CARGA MÉDIA</th>
                                    <td>{{$hardware['loadAvg']}}</td>
                                </tr>
                                <tr>
                                    <th>TEMPO DE ATIVIDADE</th>
                                    <td>{{$hardware['uptime']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
