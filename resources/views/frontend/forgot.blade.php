@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('忘記密碼') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.account') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="account" class="col-md-4 col-form-label text-md-right">{{ ('帳號') }}</label>
                            <div class="col-md-4">
                                <input id="account" type="text" class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account" pattern="^[a-zA-Z\d\.]{6,}$" value="{{ old('account') }}" maxlength="6"required autofocus>                         
                            </div>    
                        </div>

                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ ('名稱') }}</label>
                                <div class="col-md-4">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" maxlength="6" required autofocus>                                
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
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
