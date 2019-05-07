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
                            <a href="/moviemanager/movieedit/{{$data['Id']}}" title="修改" tabindex="0">
                                    <button type="button" class="btn btn-primary">修改</button>
                                </a>
                                <a href="/moviemanager/delete/{{$data['Id']}}" data-movieid="196" title="刪除" class="order_now" tabindex="0">
                                    <button type="button" class="btn btn-primary" onclick="return confirm('是否確認刪除這筆資料');">刪除</button>
                                </a>
                            </div>
                        </div> 
                         
                        
                    </li>
                    </ul>
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
                <!-- </div> -->
                @endforeach
            <!-- </div>
        </div> -->
    </div>
</div>
@endsection
