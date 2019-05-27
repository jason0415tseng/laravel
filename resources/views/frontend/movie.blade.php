@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Movie List') }}</h1>
    <div class="row content-center">
        @foreach ($movieData as $moviedata)
            <ul class="nav nav-tabs" role="tablist">
                <li data-movieid="196" class="film-item slick-slide slick-active" data-slick-index="6" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide16" style="width: 284px;margin-top: 15px;">
                    <div class="movie-move">
                        <a href="/movie/detail/{{$moviedata['Mid']}}" class="cover" tabindex="0">
                            <img src="{{ asset('/img/'.$moviedata['Poster'])}}" alt="" width="253" height="361">
                        </a>
                    </div>
                    <div>
                        <div class="movie_name">
                            <h2>{{$moviedata['Name']}}</h2>
                        </div> 
                        <div class="movie_name_en">
                            <h3>{{$moviedata['Name_en']}}</h3>
                        </div>
                        <div class="movie-date">
                            <time>{{$moviedata['Ondate']}}</time>
                        </div>
                        @switch($moviedata['Grade'])
                            @case(0)
                                <div class="movie_badge level_g">普通級</div>
                                @break
                            @case(1)
                                <div class="movie_badge level_p">保護級</div>
                                @break
                            @case(2)
                                <div class="movie_badge level_pg12">輔12級</div>
                                @break
                            @case(3)
                                <div class="movie_badge level_pg15">輔15級</div>
                                @break
                            @case(4)
                                <div class="movie_badge level_r">限制級</div>
                                @break
                            @default
                        @endswitch
                        <div class="centerBtn" style="clear:both;">
                            <a href="/movie/detail/{{$moviedata['Mid']}}" title="電影介紹" tabindex="0">
                                <button type="button" class="btn btn-primary">電影介紹</button>
                            </a>
                            <a href="/movie/time/{{$moviedata['Mid']}}" data-movieid="196" title="時刻查詢" class="order_now" tabindex="0">
                                <button type="button" class="btn btn-primary">時刻查詢</button>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        @endforeach
    </div>
</div>
@endsection
