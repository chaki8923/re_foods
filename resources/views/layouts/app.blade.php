@include('layouts.header')

<body>
    <div id="app" class="">
        <!-- フラッシュメッセージ -->
        @if (session('flash_message'))
        <div class="text-center flash-message" role="alert">
            <span class="flash-inner text-center">{{ session('flash_message') }}</span>
        </div>
        @endif
       
        <nav class="navbar navbar-expand-lg navbar-light  shadow-sm " style="z-index: 100;">
            <div class="container">
                <a class="navbar-brand header-logo" href="{{ url('/') }}">
                <img src="/images/logo.png" alt="ロゴ" class="main-logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                            
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                        @if (Session::has('id'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('action',session('id'))}}">{{ __('HOME') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('mypage')}}">{{ __('Mypage') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('uniqe_show') }}">{{ __('UNIQE_EDIT') }}</a>
                        </li>
                        <li class="nav-item">
                            
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('foods_show') }}">{{ __('Food_List') }}</a>
                        </li>
                        
                        @endif
                        @if (!Session::has('email'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('signin') }}">{{ __('Login') }}</a>
                        </li>
                        @endif
                        @if (!Session::has('store_name'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('signup') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @if (Session::has('store_name'))
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                {{ session('store_name') }} <span class="caret"></span>
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('prof_show') }}">{{ __('PROF_EDIT') }}</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endif
                        @if (Session::has('id'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('all_list') }}">
                            <i class="far fa-envelope mail-icon mt-1"></i>
                            </a>
                        </li>
                       @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="main">
            @yield('content')
        </main>
    </div>
</body>

</html>