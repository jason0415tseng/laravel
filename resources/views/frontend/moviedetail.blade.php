@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
    @foreach ($Data as $data)
        <div class="col-md-4">
            <img id="preview_poster_img" src="{{ asset('/img/'.$data['Poster'])}}" height="500"/>
        </div>
        <div class="col-md-8">
            <div class="movie-info">
                <div class="title" style="font-size:30px;line-height:30px;">{{$data['Name']}}</div>
                <div class="title_en" style="font-size:22px;line-height:22px;color:#888;padding-top:10px;">{{$data['Name_en']}}</div>
                <p style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">{{('片長:') . $data['Length']}}</p>
                @switch($data['Grade'])
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
                        <b style="display: block;color: #79b6ec;">{{ ('上映時間') }}</b>{{$data['Ondate']}}
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('類型') }}</b>{{$data['Type']}}
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('導演') }}</b>{{$data['Director']}}
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('演員') }}</b>{{$data['Actor']}}
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('劇情簡介') }}</b>{{$data['Introduction']}}
                    </li>
                </ul>
                <!-- @foreach ($Data as $data) -->
                
                <!-- @endforeach -->
            </div>
        </div>
        <div class="col-md-12" style="margin-top:15px;">
        {{-- <div class="card-body"> --}}
                    <form method="POST" action="{{ route('moive.movieupdate' , ['Mid'=> $data['Mid']]) }}" enctype="multipart/form-data">
                        @csrf
                        <!-- <div class="col-md-4" style="position: absolute;">
                            <img id="preview_poster_img" src="{{ asset('/img/'.$data['Poster'])}}" width="200" height="250"/>
                        </div> -->
                        {{-- <div class="form-group row"> --}}

                        <div class="form-group row">
                            <label for="introduction" class="col-md-4 col-form-label text-md-right" style="font-size:18px;">{{ ('廳別') }}</label>
                            <div class="col-md-4 col-form-label text-md-left" style="font-size:18px;">
                                <span>{{$data['Hall'] . ('廳')}}</span>                        
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="introduction" class="col-md-4 col-form-label text-md-right" style="font-size:18px;">{{ ('時刻') }}</label>
                                @foreach ($data['Date'] as $dd => $value)
{{-- @php
 dd($dd);   
@endphp --}}
                                <div class="col-md-1 col-form-label text-md-left" style="font-size:18px;"><span>{{$value}}</span> 
                                </div>   
                                {{-- @if($value == '1')
                                    <div class="col-md-4 col-form-label text-md-left" style="font-size:18px;"><span>10:00</span></div>
                                @elseif($value == '2')
                                    <div class="col-md-4 col-form-label text-md-left" style="font-size:18px;"><span>12:20</span></div>
                                @endif --}}
                                <!-- @switch($value)
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
                                //  dd($value)   
                                @endphp
                                            <div class="movie_badge level_r">限制級</div>
                                            @break
                                        @default      
                                @endswitch -->
                                @endforeach   
                        </div>
                        <div class="form-group row">
                            {{-- @php
                             dd($data);   
                            @endphp --}}
                            <label for="introduction" class="col-md-4 col-form-label text-md-right" style="font-size:18px;">{{ ('席位') }}</label>
                            <div class="col-md-4 col-form-label text-md-left" style="font-size:18px;">
                                @if(count($data)>18)
                                    <span>{{$data['Seat'] - $data['OrderSeat']}}</span>
                                @else
                                    <span>{{$data['Seat']}}</span>
                                @endif
                            </div>    
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="/movielist/order/{{$data['Mid']}}">
                                    <button type="button" class="btn btn-primary">
                                        {{ ('訂票') }}
                                    </button>
                                </a>    
                                    <a href="/movielist"  style="text-decoration:none;color:seashell">
                                        <button type="button" class="btn btn-primary">{{ ('上一頁') }}</button>
                                    </a>
                            </div>
                        </div>
                    </form>
                {{-- </div> --}}
        </div>
        @endforeach
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
