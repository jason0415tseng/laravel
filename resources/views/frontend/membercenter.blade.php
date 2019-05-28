@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('資訊') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('membercenter.user') }}">
                            @csrf
                            <div class="form-group row">                          
                                <div class="col-md-12">
                                    <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border="1"> 
                                        <tr>
                                            <td>帳號</td>
                                            <td>名稱</td>
                                            <td>創建時間</td>
                                            <td >操作</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {{$userData['account']}}
                                                <input id="uid" name="uid" style="display:none;" value="{{$userData['uid']}}">
                                            </td>
                                            <td>
                                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{  $userData['name'] ? $userData['name'] : old('name') }}" maxlength="6" required autofocus>                                
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif 
                                            </td>
                                            <td>{{$userData['created_at']}}</td>
                                            <td>
                                                <button type="submit" class="btn btn-primary">
                                                    {{ ('修改') }}
                                                </button>
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
</div>
<script>
    var msg = '{{ $errors->first('messages')}}';
    if(msg){
        alert(msg);
    }
</script>
@endsection