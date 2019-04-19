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
                <div class="card-header">{{ ('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="account" class="col-md-4 col-form-label text-md-right">{{ ('帳號') }}</label>

                            <div class="col-md-6">
                                <input id="account" type="text" name="account" value="{{ old('account') }}" maxlength="6" placeholder="請輸入帳號" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ ('密碼') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" name="password" required>
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ ('登入') }}
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