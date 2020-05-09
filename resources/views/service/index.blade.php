@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'service.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Serviços</li>
            </ol>
        </nav>        
        <div class="row">   
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h5 class="card-title">Serviços</h5>
                        <p class="card-category">Lista de serviços ativos</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Uso CPU
                                    </th>
                                    <th>
                                        Uso Memória
                                    </th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)   
                                    <tr>
                                        <td>
                                            {{$service['name']}}
                                        </td>
                                        <td>
                                            {{($service['running'])?$service['cpu']:'-'}}
                                        </td>
                                        <td>
                                            {{($service['running'])?$service['memory']:'-'}}
                                        </td>
                                        <td>
                                            <a data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Iniciar ou parar" data-name="{{$service['realName']}}" class="start-stop {{($service['running'])?'stop':''}} p-1" href="#">
                                                @if($service['running'])
                                                    <i class="fas fa-stop"></i>
                                                @else
                                                    <i class="fas fa-play"></i>                    
                                                @endif
                                            </a>
                                            <a data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Recarregar" data-name="{{$service['realName']}}" class="reload p-1" href="#"><i class="fas fa-redo-alt"></i></a>
                                            <a data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Reiniciar" data-name="{{$service['realName']}}" class="restart p-1" href="#"><i class="fas fa-sync-alt"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    <form action="{{route('service.update',['id' => request()->id])}}" id="form-service" method="POST">
                                        @csrf
                                        <input type="hidden" name="realName" class="real-name">
                                        <input type="hidden" name="action" class="action">
                                    </form>
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

$('[data-toggle="popover"]').popover();

$('.start-stop').on('click',function(e){
    e.preventDefault();

    if(confirm('Tem certeza que quer mudar o estado do serviço?')){
        $('.real-name').val($(this).data('name'));
        if($(this).hasClass('stop')){
            $(this).html('<i class="fas fa-play"></i>');
            $(this).removeClass('stop');
            $('.action').val('stop');
        }else{
            $(this).html('<i class="fas fa-stop"></i>');
            $(this).addClass('stop');
            $('.action').val('start');
        }
        $('#form-service').submit();
    }
})


$('.restart').on('click',function(e){
    e.preventDefault();

    if(confirm('Tem certeza que quer reiniciar o serviço?')){
        $('.real-name').val($(this).data('name'));
        $('.action').val('restart');
        $('#form-service').submit();
    }
})

$('.reload').on('click',function(e){
    e.preventDefault();

    if(confirm('Tem certeza que quer recarregar o serviço?')){
        $('.real-name').val($(this).data('name'));
        $('.action').val('reload');
        $('#form-service').submit();
    }
})
</script>
@endpush