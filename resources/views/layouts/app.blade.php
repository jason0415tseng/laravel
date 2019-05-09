<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/ajax.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1>{{ config('app.name', 'Laravel') }}</h1>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <div class="menu">
                        <!-- Right Side Of Navbar -->
                        <ul class="nav nav-tabs" role="tablist">
							@if (session('account'))
                                @if (session('level') < 3)
                                    <li role="presentation">
                                        <a class="nav-link" href="{{ route('moviemanager') }}">{{ __('電影管理') }}</a>
                                	</li>
                                    <li role="presentation">
                                    	<a class="nav-link" href="{{ route('timemanager') }}">{{ __('時刻管理') }}</a>
                                	</li>
                                    <li role="presentation">
                                        <a class="nav-link" href="{{ route('admin') }}">{{ __('管理帳號') }}</a>
									</li>
									<li role="presentation">
                                        <a class="nav-link" href="">{{ session('account') }}</a>
                                    </li>
                                    <li role="presentation">
										<a class="nav-link" href="/logout">{{ ('登出') }}</a>
                                    </li>
                                @else
                                    <li role="presentation">
                                        <a class="nav-link" href="{{ route('movielist') }}">{{ __('電影介紹') }}</a>
                                	</li>
                                    <li role="presentation">
                                    	<a class="nav-link" href="{{ route('movietime') }}">{{ __('時刻查詢') }}</a>
                                	</li>
                                    <li role="presentation">
                                        <a class="nav-link" href="{{ route('orderinfo') }}">{{ __('訂購資訊') }}</a>
								    </li>
									<li role="presentation">
                                        <a class="nav-link" href="{{ route('memberCenter') }}">{{ session('account') }}</a>
                        			</li>
                                        <li role="presentation">
										    <a class="nav-link" href="/logout">{{ ('登出') }}</a>
                                        </li>
								@endif
                            @else
                                    <li role="presentation">
                                		<a class="nav-link" href="{{ route('movielist') }}">{{ __('電影介紹') }}</a>
                        			</li>
                                    <li role="presentation">
                                		<a class="nav-link" href="{{ route('movietime') }}">{{ __('時刻查詢') }}</a>
                        			</li>
									<li role="presentation">
                                		<a class="nav-link" href="{{ route('register') }}">{{ __('註冊') }}</a>
                        			</li>
                        			<li role="presentation">
                            	    	<a class="nav-link" href="{{ route('login') }}">{{ __('登入') }}</a>
                        			</li>
                            @endif 
                        </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
