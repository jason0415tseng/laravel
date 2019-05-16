@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group row">
                <div class="col-md-12">
                    <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border="1">
                        @if(count($Data)<1)
                            <h3>{{('無任何活動')}}</h3>
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
                                <tr>
                                    <td>
                                        {{$data['title']}}
                                    </td>
                                    <td>
                                        {{$data['author']}}
                                    </td>
                                    <td>
                                        {{$data['startdate']}}
                                    </td>
                                    <td>
                                        {{$data['enddate']}}
                                    </td>
                                    <td>
                                        @if($NowTime > $data['enddate'])
                                            <div style="color:red;font-weight: bold;">{{ ('已截止') }}</div>
                                        @else
                                            @if(isset($Voted))                                                    
                                            @php
                                            // dd($NowTime)
                                            @endphp
                                            
                                                @if($Voted->contains('voteaid',$data['Aid']))
                                                    {{('已投票')}}
                                                @else
                                                    <a href="/activity/detail/{{$data['Aid']}}">
                                                        {{('參加投票')}}
                                                    </a>
                                                @endif
                                            @else
                                                @if(session('account'))
                                                    <a href="/activity/detail/{{$data['Aid']}}">
                                                        {{('參加投票')}}
                                                    </a>
                                                @else
                                                    {{('投票中')}}
                                                @endif
                                            @endif
                                        @endif
                                        
                                    </td>
                                    <td>
                                        <a href="/activity/voteresult/{{$data['Aid']}}">
                                            {{$data['votenumber']}}
                                        </a>
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
                        <button type="button" class="btn btn-primary">{{ ('新增活動') }}</button>
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
