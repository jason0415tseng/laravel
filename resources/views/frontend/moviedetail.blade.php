@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <img id="preview_poster_img" src="{{ asset('/img/'.$movieData['Poster'])}}" height="500"/>
        </div>
        <div class="col-md-8">
            <div class="movie_info">
                <div class="title">{{$movieData['Name']}}</div>
                <div class="title_en">{{$movieData['Name_en']}}</div>
                <p>{{('片長:') . $movieData['Length']}}</p>
                @switch($movieData['Grade'])
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
                <ul class="movie_info_item">
                    <li>
                        <b>{{ ('上映時間') }}</b>{{$movieData['Ondate']}}
                    </li>
                    <li>
                        <b>{{ ('類型') }}</b>{{$movieData['Type']}}
                    </li>
                    <li>
                        <b>{{ ('導演') }}</b>{{$movieData['Director']}}
                    </li>
                    <li>
                        <b>{{ ('演員') }}</b>{{$movieData['Actor']}}
                    </li>
                    <li>
                        <b>{{ ('劇情簡介') }}</b>{{$movieData['Introduction']}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-12" style="margin-top:15px;">
            <form method="POST" action="{{ route('moive.movieupdate' , ['Mid'=> $movieData['Mid']]) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="introduction" class="col-md-4 col-form-label text-md-right" style="font-size:18px;">{{ ('廳別') }}</label>
                    <div class="col-md-4 col-form-label text-md-left" style="font-size:18px;">
                        <span>{{$movieData['Hall'] . ('廳')}}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="introduction" class="col-md-4 col-form-label text-md-right" style="font-size:18px;">{{ ('時刻') }}</label>
                    <div class="col-md-6 col-form-label text-md-left" style="font-size:18px;">
                        @foreach ($movieTime as $movietime)
                            <span>{{$movietime['Time']}}</span>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a href="/movie/order/{{$movieData['Mid']}}">
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
