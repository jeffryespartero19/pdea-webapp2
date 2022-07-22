<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EPORMIS</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body style="background-image: url('../../dist/img/bgwelcome.jpg'); background-repeat:no-repeat; background-size:cover">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-success shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h3 style="font-family: 'Times New Roman', Times, serif; font-weight:bolder; color:white">EPORMIS</h3>
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
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" style="font-family: 'Times New Roman', Times, serif; font-weight:bolder; color:white; font-size:larger" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" style="font-family: 'Times New Roman', Times, serif; font-weight:bolder; color:white; font-size:larger" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py">
            <div class="">

            </div>

            <div class="container" style="padding-top: 200px;z-index: 9999; width:100%;">
                <div class="row justify-content-center">

                    <div class="col-md-5">
                        <div class="card" style="height: 350px;">
                            <div class="card-header bg-success" style="text-align: left; padding:2px 20px; font-family:'Times New Roman', Times, serif">
                                <h3 style="color: white; font-size: 50px; margin:0px">PORMIS</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group">
                                        <div class="form-group"><label>Email</label>
                                            <input type="email" id="email" name="email" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group"><label>Password</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Log in</strong></button>

                                        <label> <input type="checkbox" class="i-checks" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me </label>
                                    </div>
                                    <div style="text-align: center;"> 
                                        @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        @endif
                                    </div>



                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card" style="height: 350px;">
                            <div class="card-header bg-success" style="text-align: center; padding:2px; font-family:'Times New Roman', Times, serif">
                                <h3 style="color: white; font-size: 50px; margin:0px">PDEA</h3>
                            </div>
                            <div class="card-body" style="text-align: center;">
                                <img style="height: 200px; width:200px;" src="../../dist/img/pdea_logo.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </main>
    </div>

    <style>
        .loginBG {
            background-image: url('../../dist/img/bgwelcome.jpg');
            background-repeat: no-repeat;
            height: 100%;
            width: 100%;
            background-position: center;
            background-color: white;
            position: fixed;
            z-index: -9999;
            padding-top: 1000px;
        }
    </style>
</body>

</html>