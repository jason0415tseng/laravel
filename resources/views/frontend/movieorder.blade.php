@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Order Add') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ ('訂購') }}</div>
                @foreach ($Data as $data)
                <div class="card-body">
                    <form method="POST" action="{{ route('movielist.orderseat' , ['Mid'=> $data['Mid']]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('票名') }}</label>
                            <div class="col-md-4 col-form-label text-md-left">
                                {{$data['Name']}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('廳別') }}</label>
                            <div class="col-md-4 col-form-label text-md-left">
                                <input id="hall" type="text" name="hall" value="{{ $data['Hall'] }}" placeholder="時刻" required style="display:none">
                                    {{$data['Hall'] . ('廳')}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ ('時刻') }}</label>
                                @foreach ($data['Date'] as $key => $value)
                                    <div class="col-md-1 col-form-label">
                                        <input type="radio" id='date' name='date' value="{{$value}}" required>{{$value}}
                                    </div>
                                @endforeach
                        </div>

                        <div class="form-group row">
                            <label for="ticket" class="col-md-4 col-form-label text-md-right">{{ ('數量') }}</label>
                            <div class="col-md-4">
                                <input id="ticket" type="number" class="form-control{{ $errors->has('ticket') ? ' is-invalid' : '' }}" name="ticket" value="{{ old('ticket') }}" maxlength="3" min="0" max="4" placeholder="數量" required>
                                    @if ($errors->has('ticket'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ticket') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ ('確定') }}
                                </button>
                                <a href="/movielist"  style="text-decoration:none;color:seashell">
                                    <button type="button" class="btn btn-primary">{{ ('取消') }}</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
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
