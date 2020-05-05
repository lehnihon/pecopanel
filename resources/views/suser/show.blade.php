@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'suser.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item"><a href="{{ route('suser.index',request()->id) }}">Usuários</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalhes</li>
            </ol>
        </nav>    
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header ">
                        <h3 class="card-title">{{$user['username']}}</h3>
                        <p class="card-category">#{{$user['id']}}</p>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Data</th>
                                    <td>{{$user['created_at']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
