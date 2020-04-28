@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'subscription.index'
])

@section('content')
    <div class="content">       
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Assinaturas</h5>
                        <p class="card-category">Suas assinaturas</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Plano
                                    </th>
                                    <th>
                                        Data
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Detalhes
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $subs)
                                    <tr>
                                        <td>
                                            {{$subs['id']}}
                                        </td>
                                        <td>
                                            {{$subs['plan']['name']}}
                                        </td>
                                        <td>
                                            {{$subs['created_at']}}
                                        </td>
                                        <td>
                                            {{$subs['status']}}
                                        </td>
                                        <td>
                                            <a href="{{ route('subscription.show',$subs['id']) }}">
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