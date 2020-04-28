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
            <li class="{{ $elementActive == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('page.index', 'dashboard') }}">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>{{ __('Painel') }}</p>
                </a>
            </li>
            <li class="{{ $elementActive == 'user.index' || $elementActive == 'user.create' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#menu-user">
                    <i class="nc-icon nc-single-02"></i>
                    <p>
                        {{ __('USUÁRIOS') }}
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'user.index' || $elementActive == 'user.create' ? 'show' : '' }}" id="menu-user">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'user.index' ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}">
                                <span class="sidebar-mini-icon">{{ __('-') }}</span>
                                <span class="sidebar-normal">{{ __('Ver') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'user.create' ? 'active' : '' }}">
                            <a href="{{ route('user.create') }}">
                                <span class="sidebar-mini-icon">{{ __('-') }}</span>
                                <span class="sidebar-normal">{{ __('Criar') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'subscription.index' || $elementActive == 'subscription.create' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#menu-subscription">
                    <i class="nc-icon nc-spaceship"></i>
                    <p>
                        {{ __('ASSINATURAS') }}
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'subscription.index' || $elementActive == 'subscription.create' ? 'show' : '' }}" id="menu-subscription">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'subscription.index' ? 'active' : '' }}">
                            <a href="{{ route('subscription.index') }}">
                                <span class="sidebar-mini-icon">{{ __('-') }}</span>
                                <span class="sidebar-normal">{{ __('Ver') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'subscription.create' ? 'active' : '' }}">
                            <a href="{{ route('subscription.create') }}">
                                <span class="sidebar-mini-icon">{{ __('-') }}</span>
                                <span class="sidebar-normal">{{ __('Assinar') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'server.index' || $elementActive == 'server.list' || $elementActive == 'server.create' ? 'active' : '' }}">
                <a data-toggle="collapse" aria-expanded="true" href="#menu-server">
                    <i class="nc-icon nc-world-2"></i>
                    <p>
                        {{ __('SERVIDORES') }}
                    </p>
                </a>
                <div class="collapse {{ $elementActive == 'server.index' || $elementActive == 'server.list' || $elementActive == 'server.create' ? 'show' : '' }}" id="menu-server">
                    <ul class="nav">
                        <li class="{{ $elementActive == 'server.index' ? 'active' : '' }}">
                            <a href="{{ route('server.index') }}">
                                <span class="sidebar-mini-icon">{{ __('-') }}</span>
                                <span class="sidebar-normal">{{ __('Ver') }}</span>
                            </a>
                        </li>
                        <li class="{{ $elementActive == 'server.list' || $elementActive == 'server.create' ? 'active' : '' }}">
                            <a href="{{ route('server.list') }}">
                                <span class="sidebar-mini-icon">{{ __('-') }}</span>
                                <span class="sidebar-normal">{{ __('Associar') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="{{ $elementActive == 'webapp.index' ? 'active' : '' }}">
                <a href="{{ route('webapp.index') }}">
                <i class="nc-icon nc-laptop"></i>
                    <p>{{ __('APLICAÇÕES WEB') }}</p>
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