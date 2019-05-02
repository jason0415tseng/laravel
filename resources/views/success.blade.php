@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ session('account') }}</div>
                <div class="card-body">
                    @if (session('account'))
                        <div class="alert alert-success" role="alert">
                                恭喜登入!
                        </div>
                        @if (session('Message'))
 
                        <div id="applyFor" style="text-align: center; width: 500px; margin: 100px auto;">
                                {{ session('Message') }},將在
                                <span id="LoginTime" style="color: red">{{ session('JumpTime') }}</span>
                                秒後跳轉至
                                <a href="{{ session('Url') }}" style="color: red">{{ session('UrlName') }}</a>
                                頁面
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function (){
        var Url = "{{session('Url')}}";
        var LoginTime = parseInt($('#LoginTime').text());
        var Time = setInterval(function(){
            LoginTime = LoginTime-1;
            $('#LoginTime').text(LoginTime);
            if(LoginTime == 0){
                clearInterval(Time);
                window.location.href = Url;
            }
        }, 1000);
    });
</script>
@endsection
