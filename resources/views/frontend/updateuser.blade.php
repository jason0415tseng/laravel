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
                                    {{-- @if ($User) --}}
                                    <tr colspan="2">
                                        <td>帳號</td>
                                        <td colspan="2">{{$User['account']}}</td>
                                    </tr>
                                    <tr>
                                        <td>名稱</td>
                                        <td colspan="2">
                                            {{-- <input id="name" name="name" value="{{$user['name']}}" maxlength="6"> --}}
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
                                        {{-- <td>操作</td> --}}
                                        <td  colspan="2">
                                            {{-- <a href="/admin/{{$User['uid']}}" style="text-decoration: none; color: seashell;"> --}}
                                                <button type="submit" class="btn btn-primary" onclick="Update({{$User['uid']}})">{{ ('確認') }}</button>
                                            {{-- </a> --}}
                                        
                                            
                                                <button type="button" class="btn btn-primary" onclick="CloseWindow()">{{ ('取消') }}</button>
                                            
                                            </td> 
                                            
                                    </tr>
                                    


                                    {{-- @endif --}}
                                </table>
                            </div>    
                            {{-- @endforeach --}}
                            {{-- <div class="col-md-4">
                                <input id="account" type="text" class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account" value="{{ old('account') }}" maxlength="6" pattern="^[A-Za-z\d\.]{6,}$" placeholder="請輸入帳號" required autofocus>
                                @if ($errors->has('account'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account') }}</strong>
                                        </span>
                                @endif
                            </div> --}}
                        </div>

                        {{-- <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ ('密碼') }}</label>

                            <div class="col-md-4">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" maxlength="8" placeholder="請輸入密碼" required>
                                @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div> --}}


                        {{-- <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ ('登入') }}
                                </button>
                                <button type="button" class="btn btn-primary"  onclick="CloseWindow()">
                                    {{ ('取消') }}
                                </button>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>