<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .content {
                text-align: center;
            }
            .title {
                font-size: 84px;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                /* font-size: 13px; */
                font-size: 2em;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
        </style>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
            
        <div class="content">
                <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                        <div class="container">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>
            
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <!-- Left Side Of Navbar -->
                                <ul class="navbar-nav mr-auto">
            
                                </ul>
                                <ul class="navbar-nav ml-auto">
                                    @if (session('account'))
                                       <li class="nav-item">
                                           <a class="nav-link" href="{{ route('MemberCenter') }}">{{ __('資料') }}</a>
                                       </li>
                                   @endif
                               </ul>
                            </div>
                        </div>
                    </nav>
            <div class="row justify-content-center">
                <div class="col-md-8">
            <div class="card">
                    <div class="card-header" style="font-size:84px;">
                    Member system
                    </div>
            </div>
            @if (session('account'))
                <div>
                    <span>
                    <h1>你好! {{session('account')}}</h>
                    </span>
                    <button type="button" class="btn btn-primary">
                            <a href="/logout" style="text-decoration:none;color:seashell">{{ ('登出') }}</a>
                        </button>
                </div>
                
            @else
            <div class="card-body">
                <div class="links">
                    <a href="{{ url('/login') }}" style="text-decoration:none;">Login</a>
                    <a href="{{url('/register')}}" style="text-decoration:none;">Register</a>
                </div>
            </div>
            @endif
            </div>
            </div>
            </div>
        </div>
    </body>
</html>


{{-- <!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            
        </style>
    </head>
    <body>
        <div class="container">
          <!--變數必須用兩組大括號包起來，這樣才能抓到變數的值 -->
          <h1>news_id：{{$id}}</h1>
        </div>
    </body>
</html> --}}