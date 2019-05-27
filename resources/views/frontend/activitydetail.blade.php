@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Activity Vote') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ ('投票') }}</div>
                <form method="POST" action="{{ route('activity.vote' , ['aid'=> $activityTitle['aid']]) }}">
                    <div class="card-body">
                        @csrf
                        <div class="form-group row">
                            <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('活動名稱') }}</label>
                            <div class="col-md-4 col-form-label text-md-left">
                                {{$activityTitle['title']}}
                            </div>
                        </div>
                        @foreach ($activityContent as $data)
                            <div class="form-group row">
                                <label for="content" class="col-md-4 col-form-label text-md-right">{{ ('選項') }}</label>
                                <div class="col-md-8 col-form-label">
                                    <input type="radio" name='acid' value="{{$data['acid'].(',').$data['content']}}" required> {{ $data['content']}}
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group row">
                            <label for="content" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-8 col-form-label">
                                <input type="text" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" style="display:none;">
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
