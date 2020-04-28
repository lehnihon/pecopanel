@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'subscription.create'
])

@section('content')
    <div class="content">       
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header ">
                        <h5 class="card-title">Assinaturas</h5>
                        <p class="card-category">Escolha uma assinatura</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($plans as $plan)
                                <div class="col-sm-4 plan-option" data-id="{{$plan['id']}}">
                                    <div class="name">
                                        {{$plan['name']}}
                                    </div>
                                    <div class="description">
                                        {{$plan['description']}}
                                    </div>
                                    <div class="value">
                                        R${{$plan['total']}}
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-sm-12">
                                <button class="btn btn-info choose-plan">Escolher</button>
                            </div>
                        </div>
                    </div>
                    <form id="form-plan" action="{{ route('subscription.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" class="plan">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.plan-option').on('click',function(e){
            let id = $(this).data('id');
            $('.plan-option').css({backgroundColor:'#FFF',color: '#000'});
            $(this).css({backgroundColor:'grey',color: '#FFF'});
            $('.plan').val(id);
        })
        $('.choose-plan').on('click',function(e){
            $('#form-plan').submit();
        });
    </script>
@endpush