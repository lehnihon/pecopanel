@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'log.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item active" aria-current="page">Logs</li>
            </ol>
        </nav>        
        <div class="row">   
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h5 class="card-title">Logs</h5>
                        <p class="card-category">Lista de logs.</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Log
                                    </th>
                                    <th>
                                        Data
                                    </th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)   
                                    <tr>
                                        <td>
                                            
                                            @if($log['kind'] == 'Info') 
                                                <div class="alert alert-success d-inline"  role="alert">
                                                    <i class="fas fa-info-circle mr-1"></i>
                                            @elseif($log['kind'] == 'Warning')
                                                <div class="alert alert-warning d-inline"  role="alert">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                            @else
                                            <div class="alert alert-info d-inline"  role="alert">
                                                <i class="fas fa-star mr-1"></i>
                                            @endif
                                                {{$log['kind']}}
                                            </div>  
                                        </td>
                                        <td>
                                            {{$log['content']}}
                                        </td>
                                        <td>
                                            {{ date("d/m/Y H:i:s", strtotime($log['created_at']))}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
            <nav>
                <ul class="pagination">
                    @php
                        $count = 0;
                    @endphp
                    @for($i = $initpage; $i < $pagination['total_pages']; $i++)
                        @if($count == 10)
                            @break
                        @endif       
                        <li class="page-item {{($pagination['current_page'] == ($i+1))? 'active' : ''}}"><a class="page-link" href="{{route('log.index',['id' => request()->id, 'pag' => ($i+1)])}}">{{$i+1}}</a></li>
                        @php
                            $count++
                        @endphp
                    @endfor
                </ul>
            </nav>
            </div>
        </div>
    </div>
@endsection
