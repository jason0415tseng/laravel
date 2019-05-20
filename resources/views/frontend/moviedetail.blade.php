@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <img id="preview_poster_img" src="{{ asset('/img/'.$MovieData['Poster'])}}" height="500"/>
        </div>
        <div class="col-md-8">
            <div class="movie-info">
                <div class="title" style="font-size:30px;line-height:30px;">{{$MovieData['Name']}}</div>
                <div class="title_en" style="font-size:22px;line-height:22px;color:#888;padding-top:10px;">{{$MovieData['Name_en']}}</div>
                <p style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">{{('片長:') . $MovieData['Length']}}</p>
                @switch($MovieData['Grade'])
                    @case(0)
                        <div class="movie_badge level_g" style="margin:0px 0 15px;font-size: 18px;">普通級</div>
                        @break
                    @case(1)
                        <div class="movie_badge level_p" style="margin:0px 0 15px;font-size: 18px;">保護級</div>
                        @break
                    @case(2)
                        <div class="movie_badge level_pg12" style="margin:0px 0 15px;font-size: 18px;">輔12級</div>
                        @break
                    @case(3)
                        <div class="movie_badge level_pg15" style="margin:0px 0 15px;font-size: 18px;">輔15級</div>
                        @break
                    @case(4)
                        <div class="movie_badge level_r" style="margin:0px 0 15px;font-size: 18px;">限制級</div>
                        @break
                    @default
                @endswitch
                <ul class="movie_info_item" style="clear: both;padding-left: 0px;">
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('上映時間') }}</b>{{$MovieData['Ondate']}}
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('類型') }}</b>{{$MovieData['Type']}}
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('導演') }}</b>{{$MovieData['Director']}}
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('演員') }}</b>{{$MovieData['Actor']}}
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('劇情簡介') }}</b>{{$MovieData['Introduction']}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-12" style="margin-top:15px;">
            <form method="POST" action="{{ route('moive.movieupdate' , ['Mid'=> $MovieData['Mid']]) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="introduction" class="col-md-4 col-form-label text-md-right" style="font-size:18px;">{{ ('廳別') }}</label>
                    <div class="col-md-4 col-form-label text-md-left" style="font-size:18px;">
                        <span>{{$MovieData['Hall'] . ('廳')}}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="introduction" class="col-md-4 col-form-label text-md-right" style="font-size:18px;">{{ ('時刻') }}</label>
                    <div class="col-md-6 col-form-label text-md-left" style="font-size:18px;">
                        @foreach ($MovieTime as $movietime)
                            <span>{{$movietime['Time']}}</span>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a href="/movie/order/{{$MovieData['Mid']}}">
                            <button type="button" class="btn btn-primary">
                                {{ ('訂票') }}
                            </button>
                        </a>
                        <a href="/movie"  style="text-decoration:none;color:seashell">
                            <button type="button" class="btn btn-primary">{{ ('上一頁') }}</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
