<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
</head>
<body class="no-margin-where-the-hell-is-it-coming-from">
    <div id="app">
        <nav>
            <div class="container">
                
                <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
                
                <div class="nav-it-und" id="navbarSupportedContent">
                    <!-- <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a> -->
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <!-- <ul class="navbar-nav ml-auto"> -->
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </div>
                            @endif

                            @if (Route::has('register'))
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </div>
                            @endif
                        @else
                            <!-- <div class="nav-item">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                
                            </div> -->
                            <!-- <div class="nav-item">
                                <div class="nav-item" aria-labelledby="navbarDropdown">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div> -->
                        @endguest
                    <!-- </ul> -->
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if (Auth::check())
                <div style="display:none">
                    {{setcookie("UserObject", json_encode(Auth::user()), time()+3600, "/", "localhost:3000")}}
                </div> 
                
                <div class="nav-item1">
                    <div class="nav-item" aria-labelledby="navbarDropdown">
                        <a class="nav-link" id= "onLogout" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
                
                <!-- <h1>HELLO THERE CAPTAIN</h1> -->
                <div id="theApp">
                    <!-- <app @logout()="{{ route('logout') }}">
                
                    </app> -->
                </div>
                
            @else
                <!-- Log in please -->
                @yield('content')
            @endif 
        </main>
    </div>
    <!-- <script>
        function onLogout(){
          document.getElementById('logout-form').submit();
          console.log('saad');
                            

                       
                 
} -->
    </script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
<style>
.no-margin-where-the-hell-is-it-coming-from{
    margin: 0 !important;

}

    .nav-item1 {
        
    /* background-color:rgba(172, 169, 169, 0.925); */
    /* color: red; */
    /* border: none; */
    /* color: black; */
    /* padding: 10px 24px; */
    /* text-align: center; */
    /* text-decoration: none; */
    /* display: inline-block; */
    /* font-size: 20px; */
    /* margin: 4px 2px; */
    /* width: 7.2%; */
    /* cursor: pointer; */
    /* grid-template-columns: 10% 1fr; */
    /* border-radius:2em; */
}
.nav-item1:hover:not(.active) {
    background-color: rgb(25, 136, 30);
    color: white;
    }
</style>
</html>
