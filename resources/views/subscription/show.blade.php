@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'subscription.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('subscription.index') }}">Assinaturas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
            </ol>
        </nav>       
        <div class="row">
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Assinaturas</h5>
                        <p class="card-category">Detalhes</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{$subscriptions[0]['id']}}</td>
                                </tr>
                                <tr>
                                    <th>PLANO</th>
                                    <td>{{$subscriptions[0]['plan']['name']}}</td>
                                </tr>
                                <tr>
                                    <th>MÉTODO DE PGTO.</th>
                                    <td>{{$subscriptions[0]['payment_method']['public_name']}}</td>
                                </tr>
                                <tr>
                                    <th>DATA</th>
                                    <td>{{ date("d/m/Y H:i:s", strtotime($subscriptions[0]['created_at']))}}</td>
                                </tr>
                                <tr>
                                    <th>VIGÊNCIA</th>
                                    <td>{{ date("d/m/Y H:i:s", strtotime($subscriptions[0]['next_billing_at']))}}</td>
                                </tr>
                                <tr>
                                    <th>SERVER</th>
                                    <td>
                                    @if(empty($server))
                                        <span>Confirmando pagamento</span>
                                    @else
                                        <a href="{{ route('server.show',$server->server_id) }}">{{$server->server_ip}}</a>
                                    @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Faturas</h5>
                        <p class="card-category">Lista de faturas</p>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Valor
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Data
                                    </th>
                                    <th>
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($bills as $bill)
                                    <tr>
                                        <td>
                                            {{$bill['id']}}
                                        </td>
                                        <td>
                                            R${{$bill['amount']}}
                                        </td>
                                        <td>
                                            {{$bill['status']}}
                                        </td>
                                        <td>
                                        {{ date("d/m/Y H:i:s", strtotime($bill['created_at']))}}
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{$bill['url']}}">
                                                <i class="nc-icon nc-zoom-split"></i>
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
