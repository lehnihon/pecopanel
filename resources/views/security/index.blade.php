@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'security.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item active" aria-current="page">Segurança</li>
            </ol>
        </nav>        
        <div class="row">   
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h5 class="card-title">Segurança</h5>
                        <p class="card-category">Lista Fail2ban</p>
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <div class="input-group-text"><i class="nc-icon nc-zoom-split"></i></div>
                            </div>
                            <input type="text" name="search" id="search"  class="form-control" placeholder="Buscar...">
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        IP
                                    </th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($security as $sec)   
                                    <tr>
                                        <td>
                                            {{$sec}}
                                        </td>
                                        <td>
                                            <a class="security-remove" href="{{ route('security.destroy',['id'=> request()->id, 'ip' => $sec]) }}"><i class="fas fa-trash-alt"></i></a>
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

$('.security-remove').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer remover este ip?')){
        window.location.href = $(this).attr('href');
    }
});

$("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

</script>
@endpush