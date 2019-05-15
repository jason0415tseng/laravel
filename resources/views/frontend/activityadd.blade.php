@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Activity Add') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('新增活動') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('activity.activityadd') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ ('標題') }}</label>
                            <div class="col-md-4">
                                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" placeholder="標題" required autofocus>                            
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div id="activitylist" class="form-group row">
                            <label for="name_en" class="col-md-4 col-form-label text-md-right">{{ ('選項內容') }}</label>
                            <div class="col-md-4 col-form-label">
                                <input type="text" class="form-control" name="content[]" value="" placeholder="選項內容" required>
                            </div>   
                            <button class="btn btn-primary" onclick="activityadd()">{{('增加選項')}}</button>
                            <div class="col-md-4 col-form-label" style="margin-left: 239px;">
                                <input type="text" class="form-control" name="content[]" value="" placeholder="選項內容" required>
                            </div>
                            <div class="col-md-4 col-form-label" style="margin-left: 239px;">
                                <input type="text" class="form-control" name="content[]" value="" placeholder="選項內容" required>
                            </div> 
                        </div>
                        <div class="form-group row">
                            <label for="startdate" class="col-md-4 col-form-label text-md-right">{{ ('開始時間') }}</label>
                            <div class="col-md-4">
                                <input id="startdate" type="date" class="form-control{{ $errors->has('startdate') ? ' is-invalid' : '' }}" name="startdate" value="{{ old('startdate') }}" required>                            
                                    @if ($errors->has('startdate'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('startdate') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="enddate" class="col-md-4 col-form-label text-md-right">{{ ('結束時間') }}</label>
                            <div class="col-md-4">
                                <input id="enddate" type="date" class="form-control{{ $errors->has('enddate') ? ' is-invalid' : '' }}" name="enddate" value="{{ old('enddate') }}" required>                            
                                    @if ($errors->has('enddate'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('enddate') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ ('確定') }}
                                </button>
                                <a href="/moviemanager"  style="text-decoration:none;color:seashell">
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
<!-- JavaScript part -->

<script>


$(function (){
    var date = new Date();
    var nowYear = date.getFullYear();
    var nowMonth = (date.getMonth() + 1) >= 10 ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1));
    var nowDay = date.getDate() < 10 ? ('0'+date.getDate()) : date.getDate();
    document.getElementById('startdate').min = nowYear + '-' + nowMonth + '-' + nowDay;
    document.getElementById('enddate').min = nowYear + '-' + nowMonth + '-' + nowDay;
});
</script>
@endsection
