<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EPORMIS</title>

    <link rel="shortcut icon" href="../../dist/img/pdea_logo.jpg" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <!-- Other styles -->
    <link rel="stylesheet" href="{{ asset('css/c_gl.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/fontawesome.min.css') }}">

    <style>
        .hide {
            display: none;
        }
    </style>

</head>

<body style="background-image: url('../../dist/img/bgwelcome.jpg'); background-repeat:no-repeat; background-size:cover">
    <!-- Site wrapper -->
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

            <div class="container" style="padding-top: 100px;z-index: 9999; width:100%;">
                <div class="row justify-content-center">

                    <div class="col-md-5">
                        <div class="card" style="height: 450px;">
                            <div class="card-header bg-success" style="text-align: left; padding:2px 20px; font-family:'Times New Roman', Times, serif">
                                <h3 style="color: white; font-size: 50px; margin:0px">PORMIS</h3>
                            </div>
                            <div class="card-body">
                                <form id="LGF" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group">
                                        <div class="form-group"><label>Email</label>
                                            <input type="email" id="email" name="email" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror fillin" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group"><label>Password</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror fillin" name="password" required autocomplete="current-password">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group"><label>Log In As</label><span id="on_duty" hidden style="float: right; color:red" for="">Someone's already on Duty</span>
                                            <select id="user_log_type" name="user_log_type" class="form-control user_log_type" required>
                                                <option value="" disabled selected>Select Option</option>
                                                <option value='1'>Duty</option>
                                                <option value='2'>Encoder</option>

                                            </select>
                                        </div>

                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs LoginBTN" type="button"><strong>Log in</strong></button>

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
                        <div class="card" style="height: 450px;">
                            <div class="card-header bg-success" style="text-align: center; padding:2px; font-family:'Times New Roman', Times, serif">
                                <h3 style="color: white; font-size: 50px; margin:0px">PDEA</h3>
                            </div>
                            <div class="card-body" style="text-align: center; padding-top:50px">
                                <img style="height: 250px; width:250px;" src="../../dist/img/pdea_logo.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </main>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>


    <script>
        $('.LoginBTN').click(function() {

            var user_log_type = $('#user_log_type').val();

            $.ajax({
                type: "GET",
                url: "/get_user_log/",
                fail: function() {
                    alert("request failed");
                },
                success: function(data) {
                    var data = JSON.parse(data);

                    if (user_log_type == 1) {
                        if (data == 1) {
                            $("#on_duty").attr('hidden', false);
                        } else {
                            $('#LGF').submit();
                        }
                    } else {
                        $('#LGF').submit();
                    }


                }
            });
        });
    </script>

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