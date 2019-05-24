@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Activity Update') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('修改活動') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('activity.update', ['aid' => $activity['aid']]) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ ('標題') }}</label>
                            <div class="col-md-4">
                                <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ $activity['title'] ? $activity['title'] : old('title') }}" placeholder="標題" required autofocus>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div id="activityupdate" class="form-group row">
                            <label for="content" class="col-md-4 col-form-label text-md-right">{{ ('選項內容') }}</label>
                            <div style="width:320px;">
                                @foreach ($content as $key =>$content)
                                    <div class="col-md-9 col-form-label" id="number">
                                        <input type="text" name="acid[]" value="{{$content['acid']}}" style="display:none;">
                                        <input type="text" class="form-control" id="content" data-type='Sold' name="content[{{$content['acid']}}]" value="{{$content['content']}}" placeholder="選項內容" required>
                                            @if($key >= 2 )
                                                <a href="#" class="remove">移除</a>
                                            @endif
                                    </div>
                                @endforeach
                                <input type="text" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" style="display:none;">
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                            </div>
                                @if(count($content) == 5)
                                @else
                                    <button class="btn btn-primary" onclick="ActivityUpdateAdd()" style="height:55px;margin-left:-80px;">{{('增加選項')}}</button>
                                @endif
                        </div>
                        <div class="form-group row">
                            <label for="startdate" class="col-md-4 col-form-label text-md-right">{{ ('開始時間') }}</label>
                            <div class="col-md-4">
                                <input id="startdate" type="date" class="form-control{{ $errors->has('startdate') ? ' is-invalid' : '' }}" name="startdate" min="{{$activity['startdate']}}" value="{{ $activity['startdate'] ? $activity['startdate'] : old('startdate') }}" required>
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
                                <input id="enddate" type="date" class="form-control{{ $errors->has('enddate') ? ' is-invalid' : '' }}" min="{{$activity['startdate']}}" name="enddate" value="{{ $activity['enddate']? $activity['enddate'] : old('enddate') }}" required>
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
                                <a href="/activity"  style="text-decoration:none;color:seashell">
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
