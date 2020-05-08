@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'cron.index'
])

@section('content')
    <div class="content">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Servidores</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cron</li>
            </ol>
        </nav>        
        <div class="row">   
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h5 class="card-title">Cron</h5>
                                <p class="card-category">Lista de cron</p>
                            </div>
                            <div class="ml-auto">
                                <a href="{{ route('cron.create',request()->id) }}" class="btn btn-success"><i class="fas fa-history"></i> Criar Cron</a>
                            </div>                            
                        </div> 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Nome
                                    </th>
                                    <th>
                                        Usuário
                                    </th>
                                    <th>
                                        Comando
                                    </th>
                                    <th>
                                        Hora execução
                                    </th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($cron as $cr)   
                                    <tr>
                                        <td>
                                            {{$cr['id']}}
                                        </td>
                                        <td>
                                            {{$cr['label']}}
                                        </td>
                                        <td>
                                            {{$cr['username']}}
                                        </td>
                                        <td>
                                            {{$cr['command']}}
                                        </td>
                                        <td>
                                            {{$cr['time']}}
                                        </td>
                                        <td><a class="remove-cron" href="{{ route('cron.destroy',['id'=> request()->id, 'idcr' => $cr['id']]) }}"><i class="fas fa-trash-alt"></i></a></td>
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

@push('scripts')
<script>

$('.remove-cron').on('click',function(e){
    e.preventDefault();
    if(confirm('Tem certeza que quer remover o cron?')){
        window.location.href = $(this).attr('href');
    }
});

</script>
@endpush
