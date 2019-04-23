{{-- @extends 命令來為子視圖指定應該「繼承」的佈局 --}}
{{-- @extends('layouts.app') --}}

{{-- @section 定義一個內容區塊 --}}
{{-- @section('content')
<div class="container">
    <h1>register</h1>
</div> --}}
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

                            <div class="col-md-4">
                                <input id="account" type="text" class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account" pattern="^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$" value="{{ old('account') }}" maxlength="6" placeholder="*帳號(六碼，包含英數)" required autofocus>
                                {{-- @if ($errors->has('account'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account') }}</strong>
                                    </span>
                                @endif --}}
                                
                                @if ($errors->has('account'))
                                {{-- @php
                                 dd(session)   
                                @endphp --}}
                                    {{-- <div class="alert alert-success">
                                        {{ session('account') }}
                                    </div> --}}
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account') }}</strong>
                                    </span>
                            @endif                          
                                
                            </div>
                            
                        </div>

                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ ('名稱') }}</label>
                                <div class="col-md-4">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" maxlength="6" required autofocus placeholder="*請輸入帳號">                                
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                
                            </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ ('密碼') }}</label>

                            <div class="col-md-4">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" pattern="^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$" maxlength="8" required placeholder="*密碼(八碼，包含英數)">
                                    @if ($errors->has('password'))
                                    
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ ('再次確認密碼') }}</label>

                            <div class="col-md-4">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" pattern="^(?=.*\d)(?=.*[a-zA-Z])(?!.*\s).*$" maxlength="8" required placeholder="*再次輸入密碼">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ ('註冊') }}
                                    </button>
                                    <button type="button" class="btn btn-primary">
                                        <a href="/"  style="text-decoration:none;color:seashell">{{ ('返回') }}</a>
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
