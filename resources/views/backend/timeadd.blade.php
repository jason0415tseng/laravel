@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Time Add') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('新增時刻') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('time.timeadd' , ['mid'=> $movieData['Mid']]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ ('片名') }}</label>
                            <div class="col-md-4">
                                <span class="form-control" style="border: 1px;">{{$movieData['Name']}}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('廳別') }}</label>
                            <div class="col-md-4">
                                <select id="hall" name="hall" class="form-control{{ $errors->has('hall') ? ' is-invalid' : '' }}" style="text-align:center;text-align-last:center;">
                                    @foreach ($hall as $hall)
                                        <option value={{$hall}} @if((count($movieData)>3)&&($movieData['Hall']==$hall)) selected @else  @endif >{{$hall . ('廳')}}</option>
                                    @endforeach
                                </select>
                                    @if ($errors->has('hall'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('hall') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time" class="col-md-4 col-form-label text-md-right">{{ ('時刻') }}</label>
                            <div style="width:180px;margin-left:15px">
                                @foreach ($time as $key => $time)
                                    <input type="checkbox" value={{$time}} id="{{('time') . $key}}" name="time[]" checked>
                                    <label for="time">{{$time}}</label>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="seat" class="col-md-4 col-form-label text-md-right">{{ ('席位') }}</label>
                            <div class="col-md-4">
                                @if(count($movieData)>3)
                                    <input id="seat" type="number" class="form-control{{ $errors->has('seat') ? ' is-invalid' : '' }}" name="seat" value="{{ $movieData['Seat'] ? $movieData['Seat'] : old('seat') }}" placeholder="席位" required>
                                @else
                                    <input id="seat" type="number" class="form-control{{ $errors->has('seat') ? ' is-invalid' : '' }}" name="seat" value="{{ old('seat') }}" placeholder="席位" required>
                                @endif
                                    @if ($errors->has('seat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('seat') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ ('確定') }}
                                </button>
                                <a href="/timemanager"  style="text-decoration:none;color:seashell">
                                    <button type="button" class="btn btn-primary">{{ ('取消') }}</button>
                                </a>
                            </div>
                        </div>
                    </form>
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
