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
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card mb-0 h-100 p-4">
                    <div class="d-flex mb-2">
                        <div><i class="font-big fas fa-microchip"></i></div>
                        <div class="ml-auto text-primary">CPU</div>    
                    </div>
                    <h4 class="mb-1">
                        {{$hardware['totalCPUCore']}} Núcleos
                    </h4>
                    <p class="mb-0">
                        {{$hardware['processorName']}}
                    </p>
                </div>  
            </div>
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card mb-0 h-100 p-4">
                    <div class="d-flex mb-2">
                        <div><i class="font-big fas fa-tachometer-alt"></i></div>
                        <div class="ml-auto text-primary">MEMÓRIA</div>    
                    </div>
                    <div class="progress mt-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width:{{($hardware['percMemory'] < 15 )? '15' : $hardware['percMemory']}}%" aria-valuenow="{{$hardware['percMemory']}}" aria-valuemin="0" aria-valuemax="100">{{$hardware['percMemory']}}%</div>
                    </div>
                    <div class="d-flex">
                        <div class="font-small">0</div>
                        <div class="ml-auto font-small">{{round($hardware['totalMemory'],2)}}GB</div>
                    </div>

                </div>  
            </div>
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card mb-0 h-100 p-4">
                    <div class="d-flex mb-2">
                        <div><i class="font-big fas fa-hdd"></i></div>
                        <div class="ml-auto text-primary">DISCO</div>    
                    </div>
                    <div class="progress mt-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width:{{($hardware['diskPerc'] < 15 )? '15' : $hardware['diskPerc']}}%" aria-valuenow="{{$hardware['diskPerc']}}" aria-valuemin="0" aria-valuemax="100">{{$hardware['diskPerc']}}%</div>
                    </div>
                    <div class="d-flex">
                        <div class="font-small">0</div>
                        <div class="ml-auto font-small">{{round($hardware['diskTotal'],2)}}GB</div>
                    </div>
                </div>  
            </div>
            <div class="col-lg-3 col-sm-6 mb-3">
                <div class="card mb-0 h-100 p-4">
                    <div class="d-flex mb-2">
                        <div><i class="font-big fas fa-clock"></i></div>
                        <div class="ml-auto text-primary">UPTIME</div>    
                    </div>
                    <h4 class="mt-3 text-center">
                        {{$hardware['uptime']}}
                    </h4>
                </div>  
            </div>

            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fas fa-server mr-2"></i> {{$server['name']}}</h4>
                        <p class="card-category">{{$server['ipAddress']}}</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
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
                                <tr>
                                    <th>CARGA MÉDIA</th>
                                    <td>{{$hardware['loadAvg']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
