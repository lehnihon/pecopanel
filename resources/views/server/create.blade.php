@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'server.list'
])

@section('content')
    <div class="content">       
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Servidores</h5>
                        <p class="card-category">Associe o servidor</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('server.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user" value="{{$user}}">
                            <div class="row">
                                <div class="col-sm-6 form-group{{ $errors->has('server') ? ' has-danger' : '' }}">
                                    <label for="server">Servidor</label>
                                    <select name="server" id="server" class="form-control">
                                        <option value="">Selecione</option>
                                        @foreach($servers as $server)
                                            <option {{ old('server') == $server['id'] ? 'selected' : '' }} value="{{$server['id']}}">{{$server['name']}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('server'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            O campo sevidor é obrigatório
                                        </span>
                                    @endif
                                </div>
                                <div class="col-sm-6 form-group{{ $errors->has('subscription') ? ' has-danger' : '' }}">
                                    <label for="subscription">Assinatura</label>
                                    <select name="subscription" id="subscription" class="form-control">
                                        <option value="">Selecione</option>
                                        @foreach($subscriptions as $subscription)
                                            <option {{ old('subscription') == $subscription['id'] ? 'selected' : '' }} value="{{$subscription['id']}}">{{$subscription['plan']['name']}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('subscription'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            O campo assinatura é obrigatório
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Salvar" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush