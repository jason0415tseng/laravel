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
    <h1>{{ ('Movie Add') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('新增時刻') }}</div>
                @foreach ($Data as $data)
                {{-- @php
                 dd($data);   
                @endphp --}}
                <div class="card-body">
                    <form method="POST" action="{{ route('time.timeadd' , ['Mid'=> $data['Mid']]) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ ('片名') }}</label>
                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $data['Name'] ? $data['Name'] : old('name') }}" placeholder="片名" required autofocus>                            
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                                <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('廳別') }}</label>
                                <div class="col-md-4">
                                    <select id="hall" name="hall"  class="form-control" style="text-align:center;text-align-last:center;"> 
                                                    <option value="0" @if((count($data)>2)&&($data['Hall']=='0')) selected @else  @endif>1廳</option> 
                                                    <option value="1" @if((count($data)>2)&&($data['Hall']=='1')) selected @else  @endif>2廳</option> 
                                                    <option value="2" @if((count($data)>2)&&($data['Hall']=='2')) selected @else  @endif>3廳</option> 
                                                    <option value="3" @if((count($data)>2)&&($data['Hall']=='3')) selected @else  @endif>4廳</option> 
                                                    <option value="4" @if((count($data)>2)&&($data['Hall']=='4')) selected @else  @endif>5廳</option> 
                                                </select>
                                        @if ($errors->has('hall'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('hall') }}</strong>
                                            </span>
                                        @endif
                                </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ ('時刻') }}</label>
                            <div class="col-md-4">
                                <input id="date" type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{ old('date') }}" placeholder="時刻" required>                            
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div> --}}
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ ('時刻') }}</label>
                            <div style="width:180px;margin-left:15px">
                            <input type="checkbox" value="1" checked id="date_1" name="date_1">
                            <label for="date">10:00</label>
                            {{-- <input type="checkbox" value="2" checked id="date_2" name="date_2">
                            <label for="date">14:20</label>
                            <input type="checkbox" value="3" checked id="date_3" name="date_3">
                            <label for="date">16:40</label>
                            <input type="checkbox" value="4" checked id="date_4" name="date_4">
                            <label for="date">19:00</label>
                            <input type="checkbox" value="5" checked id="date_5" name="date_5">
                            <label for="date">21:20</label>
                            <input type="checkbox" value="6" checked id="date_6" name="date_6">
                            <label for="date">23:40</label> --}}
                            </div>  
                        </div>
                        <div class="form-group row">
                            <label for="seat" class="col-md-4 col-form-label text-md-right">{{ ('席位') }}</label>
                            <div class="col-md-4">
                                @if(count($data)>2)
                                    <input id="seat" type="text" class="form-control{{ $errors->has('seat') ? ' is-invalid' : '' }}" name="seat" value="{{ $data['Seat'] ? $data['Seat'] : old('seat') }}" maxlength="6" placeholder="席位" required>                            
                                @else
                                    <input id="seat" type="text" class="form-control{{ $errors->has('seat') ? ' is-invalid' : '' }}" name="seat" value="{{ old('seat') }}" maxlength="6" placeholder="席位" required>                            
                                @endif
                                    @if ($errors->has('seat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('seat') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        {{-- <div class="form-group row">
                            <label for="poster" class="col-md-4 col-form-label text-md-right">{{ ('海報') }}</label>
                            <div class="col-md-4" style="position: relative;">
                                <input id="poster" type="file" class="form-control{{ $errors->has('poster') ? ' is-invalid' : '' }}" name="poster" placeholder="海報"  onchange="readURL(this)" targetID="preview_poster_img" accept="image/gif,image/jpeg,image/png" required>
                                    @if ($errors->has('poster'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('poster') }}</strong>
                                        </span>
                                    @endif  
                            </div>
                            <div id="preview_poster" class="col-md-4" style="position: absolute;margin-left:480px;display: none;">
                                <img id="preview_poster_img" src="#" width="200" height="250" style="display: none;"/>
                            </div>
                        </div> --}}
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