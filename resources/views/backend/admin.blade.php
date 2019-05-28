@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ ('帳號管理') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.delete') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                @if(count($userList)<1)
                                    <h3>{{('無任何帳號')}}</h3>
                                @else
                                    <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border="1">
                                        <tr>
                                            <td>帳號</td>
                                            <td>等級</td>
                                            <td>啟用/凍結</td>
                                            <td>創建時間</td>
                                            <td>修改時間</td>
                                            <td colspan="2">操作</td>
                                        </tr>
                                        @foreach ($userList as $user)
                                            <tr>
                                                <td>
                                                    {{$user['account']}}
                                                    <input id="uid" name="uid" style="display:none;" value="{{$user['uid']}}">
                                                </td>
                                                <td>{{$user['level']}}</td>
                                                <td>
                                                    @if ($user['freeze'] == 'N')
                                                        <span style="color:red;font-weight:bold;">{{$user['freeze']}}</span>
                                                    @else
                                                        <span style="font-weight:bold;">{{$user['freeze']}}</span>
                                                    @endif
                                                </td>
                                                <td>{{$user['created_at']}}</td>
                                                <td>{{$user['updated_at']}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" onclick="OpenWindow({{$user['uid']}})">
                                                        {{ ('修改') }}
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary" onclick="return confirm('是否確認刪除這筆資料');">{{ ('刪除') }}</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </form>
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