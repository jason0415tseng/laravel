@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Activity Result') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ ('投票結果') }}</div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('活動名稱') }}</label>
                        <div class="col-md-4 col-form-label text-md-left">
                            {{$activityTitle['title']}}
                        </div>
                    </div>
                    @foreach ($activityContentData as $data)
                        <div class="form-group row">
                            <label for="content" class="col-md-4 col-form-label text-md-right">{{$data['content']}}</label>
                            <div class="col-md-8 col-form-label">
                                <div class='line' style="width:{{$data['rate']}}%;">
                                </div>
                                    <p>{{$data['votenumber']}}票({{$data['rate']}}%)</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="/activity" style="text-decoration:none;color:seashell">
                                <button type="button" class="btn btn-primary">{{ ('回上一頁') }}</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
