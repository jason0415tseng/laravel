@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
    {{-- @foreach ($Data as $data) --}}
        {{-- <div class="col-md-4">
            <img id="preview_poster_img" src="{{ asset('/img/'.$data['Poster'])}}" height="500"/>
        </div> --}}
        <div class="col-md-8">
            {{-- <div class="movie-info"> --}}
                {{-- <div class="title" style="font-size:30px;line-height:30px;">{{ ('AAAAA') }}</div> --}}
                {{-- @foreach ($Data as $data) --}}
                {{-- @php
                dd($Data)
                @endphp --}}
                {{-- <div class="title" style="font-size:22px;line-height:22px;color:#888;padding-top:10px;">{{ $data['Title'] }}</div>
                <p style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">{{ ('11:') }}</p>

                <ul class="movie_info_item" style="clear: both;padding-left: 0px;">
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('1') }}</b>
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('1') }}</b>
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('1') }}</b>
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('11') }}</b>
                    </li>
                    <li style="color: #777;font-size:18px;border-radius: 30px;margin-bottom: 10px;list-style-type: none;">
                        <b style="display: block;color: #79b6ec;">{{ ('11') }}</b>
                    </li>
                </ul> --}}
                {{-- @endforeach --}}
                <!-- @foreach ($Data as $data) -->
                
                <!-- @endforeach -->
            {{-- </div> --}}
            <div class="form-group row">
                            <div class="col-md-12">
                                <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border="1">
                                    @if(count($Data)<1)
                                        <h3>{{('無訂購資料')}}</h3>
                                    @else
                                        <tr>
                                            <td>活動名稱</td>
                                            <td>發起人</td>
                                            <td>開始日</td>
                                            <td>截止日</td>
                                            <td>目前狀態</td>
                                            <td>結果</td>
                                        </tr>
                                        @foreach ($Data as $data)
                                        {{-- @php
                                        dd($data)
                                        @endphp --}}
                                            <tr>
                                                <td>
                                                    {{$data['Title']}}
                                                </td>
                                                <td>
                                                    {{$data['Author']}}
                                                </td>
                                                <td>
                                                    {{$data['StartDate']}}
                                                </td>
                                                <td>
                                                    {{$data['EndDate']}}
                                                </td>
                                                <td>
                                                    {{('參加投票')}}
                                                </td>
                                                <td>
                                                    {{$data['created_at']}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    @if(session('account'))
                    <a href="/activity/activityadd"  style="text-decoration:none;color:seashell">
                        <button type="button" class="btn btn-primary">{{ ('新增') }}</button>
                    </a>
                    @else
                    @endif
                    <a href="/"  style="text-decoration:none;color:seashell">
                        <button type="button" class="btn btn-primary">{{ ('上一頁') }}</button>
                    </a>
                </div>
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
