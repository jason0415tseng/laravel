{{-- @section('content')
<div class="container">
    <h1>login</h1>
</div> --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ ('修改資訊') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin') }})">
                        @csrf
{{$User['uid']}}
                        <div class="form-group row">

                            <div class="col-md-12">
                                <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border='1'> 
                                    {{-- @if ($User) --}}
                                    <tr colspan="2">
                                        <td>帳號</td>
                                        <td colspan="2">{{$User['account']}}</td>
                                    </tr>
                                    <tr> 
                                        <td>Levl</td>
                                        <td colspan="2">
                                            <input id="name" style="text-align:center" value = "{{$User['level']}}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>啟用/凍結</td>
                                        <td colspan="2">
                                            <input id="freeze" style="text-align:center" value = "{{$User['freeze']}}">
                                        </td> 
                                    </tr>

                                    <tr>
                                        {{-- <td>操作</td> --}}
                                        <td  colspan="2">
                                            {{-- <a href="/admin/{{$User['uid']}}" style="text-decoration: none; color: seashell;"> --}}
                                                <button type="button" class="btn btn-primary">{{ ('確認') }}</button>
                                            {{-- </a> --}}
                                        
                                            <a href="/admin"  style="text-decoration:none;color:seashell">
                                                <button type="button" class="btn btn-primary">{{ ('返回') }}</button>
                                            </a>
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
                                <button type="button" class="btn btn-primary">
                                    <a href="/"  style="text-decoration:none;color:seashell">{{ ('返回') }}</a>
                                </button>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
   
@endsection