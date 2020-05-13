<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                @server
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                @endserver
            </div>
            <a class="navbar-brand" href="{{ route('home') }}">{{ __('Painel VindixRuncloud') }}</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav w-100">
                <li class="nav-item {{ $elementActive == 'home.index' ? 'active' : '' }}">
                    <a class="nav-link btn-magnify" href="{{ route('home') }}">
                        <i class="nc-icon nc-globe"></i>
                        <p>
                        <span>Servidores</span>
                        </p>
                    </a>
                </li>
                <li class="ml-auto nav-item btn-rotate dropdown {{ $elementActive == 'profile' ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="nc-icon nc-single-02"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Sua Conta') }}</span>
                        </p>
                    </a>
                    <form class="dropdown-item" action="{{ route('logout') }}" id="formLogOut" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Meu perfil') }}</a>
                        <a class="dropdown-item" onclick="document.getElementById('formLogOut').submit();">{{ __('Log out') }}</a>  
                    </div>
                </li>
                @if(auth()->user()->role->id == '1')
                <li class="nav-item btn-rotate dropdown {{ $elementActive == 'connect.index' ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink3"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Administração') }}</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink3">
                        <a class="dropdown-item" href="{{ route('user.index') }}">{{ __('Administrar Usuários') }}</a>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
