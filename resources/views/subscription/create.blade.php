@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'subscription.create'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('subscription.index') }}">Assinaturas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Criar</li>
            </ol>
        </nav>
        <div class="row">
            @foreach($plans as $plan)
                <div class="col-md-4">
                    <div class="card plan-option" data-id="{{$plan['id']}}">
                        <div class="card-header text-center">
                            <h5 class="card-title">{{$plan['name']}}</h5>
                        </div>
                        <div class="card-body text-center">
                            <h3>R${{$plan['total']}}</h3>
                            
                        </div>
                        <div class="card-footer">
                            {!!$plan['description']!!}
                        </div>
                    </div>
                </div>
            @endforeach
            <form id="form-plan" action="{{ route('subscription.store') }}" method="POST">
                @csrf
                <input type="hidden" name="plan" class="plan">
            </form>
            <div class="col-sm-12">
                <button class="btn btn-info choose-plan">Assinar</button>
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
            if($('.plan').val() == ''){
                alert('Selecione um plano!');
            }else{
                $('#form-plan').submit();
            }   
        });
    </script>
@endpush