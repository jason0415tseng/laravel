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
                <div class="card-header">{{ ('重設密碼') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        {{-- @if ($uid)
                        @php
                        // dd($uid);
                        // dd($account);
                        @endphp

                        @endif --}}

                        <div class="form-group row">
                                <label for="account" class="col-md-4 col-form-label text-md-right">{{ ('帳號') }}</label>
                                <div class="col-md-4">
                                    <input id="uid" name="uid" value="{{$errors->has('account') ? $errors->has('account') : $uid}}" style="display:none">
                                    <input id="account" name="account" value="{{$errors->has('account') ? $errors->has('account') : $account}}" style="display:none">
                                    {{-- <input id="account" type="text" class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account" value="{{ old('account') }}" maxlength="6" required autofocus placeholder="*請輸入帳號">                                
                                        @if ($errors->has('account'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('account') }}</strong>
                                            </span>
                                        @endif --}}
                                        {{-- @php
                                         dd($errors->has('account'));   
                                        @endphp --}}
                                        <span class="form-control">{{$errors->has('account') ? $errors->has('account') : $account}}</span>
                                        
                                </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ ('密碼') }}</label>
                            <div class="col-md-4">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" pattern="^[A-Za-z\d\.]{8,}$" maxlength="8" oninvalid="setCustomValidity('請輸入密碼');" oninput="setCustomValidity('');" required autofocus placeholder="*密碼(八碼，包含英數)">
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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" pattern="^[A-Za-z\d\.]{8,}$" maxlength="8" required  placeholder="*再次輸入密碼">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ ('確定') }}
                                    </button>
                                    <a href="/"  style="text-decoration:none;color:seashell">
                                        <button type="button" class="btn btn-primary">{{ ('取消') }}</button>
                                    </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
