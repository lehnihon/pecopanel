<div class="sidebar" data-color="black" data-active-color="danger">
    <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('paper') }}/img/logo-small.png">
            </div>
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
            {{ __('Creative Tim') }}
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ $elementActive == 'server.index' ? 'active' : '' }}">
                <a href="{{ route('server.show',request()->id) }}">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>{{ __('RESUMO') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'webapp.index' ? 'active' : '' }}">
                <a href="{{ route('webapp.index',request()->id) }}">
                <i class="nc-icon nc-laptop"></i>
                    <p>{{ __('APLICAÇÕES WEB') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'database.index' ? 'active' : '' }}">
                <a href="{{ route('database.index',request()->id) }}">
                <i class="fas fa-database"></i>
                    <p>{{ __('BANCO DE DADOS') }}</p>
                </a>
            </li>

            <li class="{{ $elementActive == 'icons' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'icons') }}">
                    <i class="nc-icon nc-diamond"></i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li>
           
        </ul>
    </div>
</div>