<div class="wrapper">

    @server
        @include('layouts.navbars.auth')
    @endserver

    <div id="app" class="main-panel" @server @else style="width:100%" @endserver>
        @include('layouts.navbars.navs.auth')
        @yield('content')
        @include('layouts.footer')
    </div>
</div>