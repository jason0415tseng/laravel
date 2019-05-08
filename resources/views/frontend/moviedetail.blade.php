@extends('layouts.app')


@section('content')


<div class="container">
    {{-- <h1>{{ ('Movie Editor') }}</h1> --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">{{ ('修改電影') }}</div> --}}
                @foreach ($Data as $data)
                {{-- <div class="card-body"> --}}
                    <form method="POST" action="{{ route('moive.movieupdate' , ['Mid'=> $data['Mid']]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-4" style="position: absolute;">
                            <img id="preview_poster_img" src="{{ asset('/img/'.$data['Poster'])}}" width="200" height="250"/>
                        </div>
                        {{-- <div class="form-group row"> --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ ('片名') }}</label>
                            <div class="col-md-4">
                                <div class="col-md-4"><span>{{$data['Name']}}</span>
                                </div>                        
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="name_en" class="col-md-4 col-form-label text-md-right">{{ ('英文片名') }}</label>
                            <div class="col-md-4">
                                <div class="col-md-4"><span>{{$data['Name_en']}}</span>
                                </div>                        
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="ondate" class="col-md-4 col-form-label text-md-right">{{ ('上映時間') }}</label>
                            <div class="col-md-4">
                                <div class="col-md-4"><span>{{$data['Ondate']}}</span>
                                </div>                         
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ ('類型') }}</label>
                            <div class="col-md-4">
                                <div class="col-md-4"><span>{{$data['Type']}}</span>
                                </div>                       
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="length" class="col-md-4 col-form-label text-md-right">{{ ('片長') }}</label>
                            <div class="col-md-4">
                                <div class="col-md-4"><span>{{$data['Length']}}</span>
                                </div>                        
                            </div>    
                        </div>
                        <div class="form-group row">
                                <label for="grade" class="col-md-4 col-form-label text-md-right">{{ ('分級') }}</label>
                                <div class="col-md-4">
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
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="director" class="col-md-4 col-form-label text-md-right">{{ ('導演') }}</label>
                            <div class="col-md-4">
                                <div class="col-md-4"><span>{{$data['Director']}}</span>
                                </div>                         
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="actor" class="col-md-4 col-form-label text-md-right">{{ ('演員') }}</label>
                            <div class="col-md-4"><span>{{$data['Actor']}}</span>
                                {{-- <input id="actor" type="text" class="form-control{{ $errors->has('actor') ? ' is-invalid' : '' }}" name="actor" value="{{ $data['Actor'] ? $data['Actor'] : old('actor') }}"  placeholder="演員" required>
                                    @if ($errors->has('actor'))
                                    
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('actor') }}</strong>
                                        </span>
                                    @endif --}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="introduction" class="col-md-4 col-form-label text-md-right">{{ ('劇情簡介') }}</label>
                            <div class="col-md-4">
                                <div class="col-md-4"><span>{{$data['Introduction']}}</span> 
                                </div>                        
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="introduction" class="col-md-4 col-form-label text-md-right">{{ ('廳別') }}</label>
                            <div class="col-md-4">
                                <div class="col-md-4"><span>{{$data['Hall'] . ('廳')}}</span> 
                                </div>                        
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="introduction" class="col-md-4 col-form-label text-md-right">{{ ('時刻') }}</label>
                            <div class="col-md-4">
                                @foreach ($data['Date'] as $dd => $value)
                                    
                                
                                {{-- @php
                                 dd($value)   
                                @endphp --}}
                                {{-- @if($data['Date'])
                                    $data['Date'] = explode(",",$data['Date']);
                                @endif --}}
                                {{-- <div class="col-md-4"><span>{{$data['Date']}}</span>  --}}
                                {{-- </div>    --}}
                                @switch($value)
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
                                        @case(5)
                                        @php
                                 dd($value)   
                                @endphp
                                            <div class="movie_badge level_r">限制級</div>
                                            @break
                                        @default      
                                @endswitch
                                @endforeach
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="introduction" class="col-md-4 col-form-label text-md-right">{{ ('席位') }}</label>
                            <div class="col-md-4">
                                <div class="col-md-4"><span>{{$data['Seat']}}</span>
                                </div>                        
                            </div>    
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ ('確定') }}
                                    </button>
                                    <a href="/movielist"  style="text-decoration:none;color:seashell">
                                        <button type="button" class="btn btn-primary">{{ ('上一頁') }}</button>
                                    </a>
                            </div>
                        </div>
                    </form>
                {{-- </div> --}}
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- JavaScript part -->

<script>

function readURL(input){

  if(input.files && input.files[0]){

    var imageTagID = input.getAttribute("targetID");

    var reader = new FileReader();

    reader.onload = function (e) {

       var img = document.getElementById(imageTagID);

        img.style.display="block";

       img.setAttribute("src", e.target.result)

    }

    reader.readAsDataURL(input.files[0]);

  }

}
$(function (){
    var date = new Date();
    var nowYear = date.getFullYear();
    var nowMonth = (date.getMonth() + 1) >= 10 ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1));
    var nowDay = date.getDate() < 10 ? ('0'+date.getDate()) : date.getDate();
    document.getElementById('ondate').min = nowYear + '-' + nowMonth + '-' + nowDay;
});
</script>
@endsection
