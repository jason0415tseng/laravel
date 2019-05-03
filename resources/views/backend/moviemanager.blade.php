@extends('layouts.app')


@section('content')
{{-- <div class="col-md-6 offset-md-4">
    <button type="submit" class="btn btn-primary">
        {{ ('新增') }}
    </button>
    <a href="/"  style="text-decoration:none;color:seashell">
        <button type="button" class="btn btn-primary">{{ ('返回') }}</button>
    </a>
</div> --}}

<div class="container">
    <h1>{{ ('Movie List') }}</h1>
    <a href="/moviemanager/movieadd"  style="text-decoration:none;color:seashell">
        <button type="button" class="btn btn-primary">{{ ('新增') }}</button>
    </a>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('Movie List') }}</div>

                <div class="card-body">
                    <div data-movieid="196" class="film-item slick-slide slick-active" data-slick-index="6" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide16" style="width: 284px;">
                        <div class="groupMask">
                            <div class="movie-date">上映日期:2019-04-24</div> 
                            <div class="movie-name">復仇者聯盟：終局之戰</div> 
                            <div class="movie-grading">
                                <div class="text">
                                    <span>3D數位 - 英語</span>
                                </div> 
                                <span>
                                    <img src="{{ asset('img/grade_6.jpg') }}"  width="80" height="80" alt="" class="img-item">
                                </span>
                            </div>
                        </div> 
                        <div class="centerBtn">
                            <a href=""film_detail.aspx?TheaterId=15&amp;TheaterName=in89taichung&amp;select_movie=復仇者聯盟：終局之戰-3D數位-英語&amp;movie_id=196"" title="電影介紹" tabindex="0">電影介紹</a> 
                            <a href="#" data-movieid="196" data-selectedmovie="復仇者聯盟：終局之戰-3D數位-英語" title="立即訂票" class="order_now" tabindex="0">立即訂票</a>
                        </div> 
                        <div class="movie-move">
                            <a href="film_detail.aspx?TheaterId=15&amp;TheaterName=in89taichung&amp;select_movie=復仇者聯盟：終局之戰-3D數位-英語&amp;movie_id=196" class="cover" tabindex="0">
                                <img src="{{ asset('img/256_big.jpg') }}" alt="" width="253" height="361">
                            </a>
                        </div>
                    </div>
                    {{-- <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="account" class="col-md-4 col-form-label text-md-right">{{ ('片名') }}</label>
                            <div class="col-md-4">
                                <input id="account" type="text" class="form-control{{ $errors->has('account') ? ' is-invalid' : '' }}" name="account" pattern="^[a-zA-Z\d\.]{6,}$" value="{{ old('account') }}" maxlength="6" placeholder="*帳號(六碼，包含英數)" required autofocus>                            
                                    @if ($errors->has('account'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('account') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>

                        <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ ('分級') }}</label>
                                <div class="col-md-4">
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" maxlength="6" required autofocus placeholder="*請輸入帳號">                                
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ ('片長') }}</label>
                            <div class="col-md-4">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" pattern="^[A-Za-z\d\.]{8,}$" maxlength="8" oninvalid="setCustomValidity('請輸入密碼');" oninput="setCustomValidity('');" required placeholder="*密碼(八碼，包含英數)">
                                    @if ($errors->has('password'))
                                    
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ ('上映日期') }}</label>
                            <div class="col-md-4">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" pattern="^[A-Za-z\d\.]{8,}$" maxlength="8" required  placeholder="*再次輸入密碼">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ ('註冊') }}
                                    </button>
                                    <a href="/"  style="text-decoration:none;color:seashell">
                                        <button type="button" class="btn btn-primary">{{ ('返回') }}</button>
                                    </a>
                            </div>
                        </div> 
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
