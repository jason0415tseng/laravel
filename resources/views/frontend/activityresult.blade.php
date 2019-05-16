@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Activity Result') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ ('投票結果') }}</div>
                <form method="POST" action="{{ route('activity.vote' , ['Aid'=> $Title['aid']]) }}">
                    <div class="card-body">
                        @csrf
                        <div class="form-group row">
                            <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('活動名稱') }}</label>
                            <div class="col-md-4 col-form-label text-md-left">
                                {{$Title['title']}}
                            </div>
                        </div>

                        @foreach ($Data as $data)
                            <div class="form-group row">
                                <label for="content" class="col-md-4 col-form-label text-md-right">{{$data['content']}}</label>
                                <div class="col-md-8 col-form-label">
                                    @if(($Total == 0) ? $Total = 1: $Total) @endif
                                    <div class='line' style="width:{{round($data["votenumber"]/$Total, 2)*100}}%;display: inline-block;height: 25px;background: grey;">
                                    </div>
                                        {{$data['votenumber']}}票({{round(($data['votenumber']/$Total)*100)}}%)
                                </div>
                            </div>
                        @endforeach

                        <div class="form-group row">
                            <label for="content" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-8 col-form-label">
                                <input type="text" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" style="display:none;">
                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="/activity"  style="text-decoration:none;color:seashell">
                                    <button type="button" class="btn btn-primary">{{ ('回上一頁') }}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
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

       var div = document.getElementById('preview_poster');
       var img = document.getElementById('preview_poster_img');

        div.style.display="block";
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
