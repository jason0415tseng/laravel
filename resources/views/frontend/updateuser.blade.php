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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ ('修改資訊') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border='1'>
                                    <tr colspan="2">
                                        <td>帳號</td>
                                        <td colspan="2">{{$User['account']}}</td>
                                    </tr>
                                    <tr>
                                        <td>名稱</td>
                                        <td colspan="2">
                                            <input id="uid" name="uid" value="{{$User['uid']}}" style="display:none">
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{  $user['account'] ? $user['account'] : old('name') }}" maxlength="6" required autofocus>
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="submit" class="btn btn-primary" onclick="Update({{$User['uid']}})">{{ ('確認') }}</button>
                                            <button type="button" class="btn btn-primary" onclick="CloseWindow()">{{ ('取消') }}</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>