{{-- @section('content')
<div class="container">
    <h1>login</h1>
</div> --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('登入') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="account" class="col-md-4 col-form-label text-md-right">{{ ('帳號') }}</label>

                            <div class="col-md-4">
                                <input id="account" type="text" class="form-control{{ $errors->has('account')|$errors->has('freeze') ? ' is-invalid' : '' }}" name="account" value="{{ old('account') }}" maxlength="6" pattern="^[A-Za-z\d\.]{6,}$" placeholder="請輸入帳號" required autofocus>
                                @if ($errors->has('account'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account') }}</strong>
                                    </span>
                                @elseif ($errors->first('freeze'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('freeze') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ ('密碼') }}</label>

                            <div class="col-md-4">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" maxlength="8" placeholder="請輸入密碼" required>
                                @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ ('登入') }}
                                </button>
                                <a href="/"  style="text-decoration:none;color:seashell">
                                        <button type="button" class="btn btn-primary">{{ ('返回') }}</button>
                                </a>
                                <a href="{{ route('password.forgot') }}">忘記密碼</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
   
<script>
    var msg = '{{ $errors->first('freeze')}}';
    if(msg){
        alert(msg);
    }
</script>
@endsection