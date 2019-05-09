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
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    </head>
    <body>       
        <div class="content">
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
                </div>
            </nav>
			<div class="slider">		
				<div id="about-slider">
					<div id="carousel-slider" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<div class="carousel-inner">
                            @if (!session('account'))
							    <div class="item active">						
							    	<img src="{{ asset('img/1.jpg') }}" class="img-responsive" alt=""> 
							    	<div class="carousel-caption">
							    		<div>								
							    			<h2><p>Hello</span></p>
                                        </div>
							    	</div>
                                </div>
                            @else
                                @if (session('level') < 3)
                                    <div class="item active">						
							        	<img src="{{ asset('img/3.jpg') }}" class="img-responsive" alt=""> 
							        	<div class="carousel-caption">
							        		<div>								
							        			<h2><p>Manager system</span></p>
                                            </div>
							        	</div>
                                    </div>
                                @else
                                    <div class="item active">						
							        	<img src="{{ asset('img/2.jpg') }}" class="img-responsive" alt=""> 
							        	<div class="carousel-caption">
							        		<div>								
							        			<h2><p>Member system</span></p>
                                            </div>
							        	</div>
                                    </div>
                                @endif
                            @endif
                        </div>
					</div>   
                </div>
			</div>   
            </div>
			</div>   
        </div>
    </body>
</html>

