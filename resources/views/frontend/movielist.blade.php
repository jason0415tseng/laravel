@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Movie List') }}</h1>
    
    {{-- <form method="POST" action="{{ route('movie.moviedelete') }}"> --}}
    <div class="row content-center">
        <!-- <div class="col-md-8">
            <div class="card"> -->
                <!-- <div class="card-header">{{ ('Movie List') }}</div> -->
                @foreach ($Data as $data)
                @php
                // dd($User)
                @endphp
                <!-- <div class="card-body"> -->
                    <ul class="nav nav-tabs" role="tablist">
                    <li data-movieid="196" class="film-item slick-slide slick-active" data-slick-index="6" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide16" style="width: 284px;margin-top: 15px;">
                        <div class="movie-move">
                            <a href="" class="cover" tabindex="0">
                                <img src="{{ asset('/img/'.$data['Poster'])}}" alt="" width="253" height="361">
                                {{-- <img src="{{$user['Poster']}}" alt="" width="253" height="361"> --}}
                                {{-- /storage/app/img/20190506/ laravel\storage\app\img\20190506\20190506145249_276_big.jpg--}}
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
                            <a href="/movielist/detail/{{$data['Mid']}}" title="電影介紹" tabindex="0">
                                    <button type="button" class="btn btn-primary">電影介紹</button>
                                </a>
                                <a href="/movielist/time/{{$data['Mid']}}" data-movieid="196" title="時刻查詢" class="order_now" tabindex="0">
                                    <button type="button" class="btn btn-primary">時刻查詢</button>
                                </a>
                            </div>
                        </div> 
                         
                        
                    </li>
                    </ul>
                    
                @endforeach
            <!-- </div>
        </div> -->
    </div>
    {{-- </form> --}}
</div>
@endsection
