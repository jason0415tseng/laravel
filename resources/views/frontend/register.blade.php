{{-- @extends 命令來為子視圖指定應該「繼承」的佈局 --}}
{{-- @extends('layouts.app') --}}

{{-- @section 定義一個內容區塊 --}}
{{-- @section('content')
<div class="container">
    <h1>register</h1>
</div> --}}
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="account" class="col-md-4 col-form-label text-md-right">{{ ('帳號') }}</label>

                            <div class="col-md-6">
                                <input id="account" type="text" name="account" value="{{ old('account') }}" maxlength="6" placeholder="請輸入帳號" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ ('名稱') }}</label>
    
                                {{-- <div class="col-md-6">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                </div> --}}
                                <div class="col-md-6">
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    
                                    
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ ('密碼') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" name="password" required>
                                {{-- <span class="invalid-feedback" role="alert">
                                    <strong>password</strong>
                                </span> --}}
                                {{-- @if ('password' != 'password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>請輸入相同密碼</strong>
                                    </span>
                                @endif --}}
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                                {{-- @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                                {{-- @php
                                                dd($errors->first('password'))   
                                               @endphp 
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif --}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ ('再次確認密碼') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ ('註冊') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
