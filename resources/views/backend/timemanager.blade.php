@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Movie List') }}</h1>
    <div class="row content-center">
        @foreach ($Data as $data)
            <ul class="nav nav-tabs" role="tablist">
                <li data-movieid="196" class="film-item slick-slide slick-active" data-slick-index="6" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide16" style="width: 284px;margin-top: 15px;">
                    <div class="movie-move">
                        <a href="/timemanager/timeadd/{{$data['Mid']}}" class="cover" tabindex="0">
                            <img src="{{ asset('/img/'.$data['Poster'])}}" alt="" width="253" height="361">
                        </a>
                    </div>
                    <div class="groupMask">
                        <div class="movie-name" style="font-size: 18px;clear: left;padding-top: 10px;font-weight: 400;"><h2>{{$data['Name']}}</h2></div> 
                        <div class="movie-name" style="color: #888;"><h3>{{$data['Name_en']}}</h3></div> 
                        <div class="movie-date"><time>{{$data['Ondate']}}</time></div> 
                        @switch($data['Grade'])
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
                            <a href="/timemanager/timeadd/{{$data['Mid']}}" title="修改" tabindex="0">
                                <button type="button" class="btn btn-primary">修改</button>
                            </a>
                        </div>
                    </div> 
                </li>
            </ul>
        @endforeach
    </div>
</div>
@endsection
