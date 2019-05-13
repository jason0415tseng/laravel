@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Movie Editor') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('修改時刻') }}</div>
                @foreach ($Data as $data)
                <div class="card-body">
                    <form method="POST" action="{{ route('moive.movieupdate' , ['Mid'=> $data['Mid']]) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="account" class="col-md-4 col-form-label text-md-right">{{ ('片名') }}</label>
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
                                <input id="hall" type="text" class="form-control{{ $errors->has('hall') ? ' is-invalid' : '' }}" name="hall" value="{{ $data['hall'] ? $data['hall'] : old('hall') }}" placeholder="英文片名" required>                            
                                    @if ($errors->has('hall'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('hall') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ ('時刻') }}</label>
                            <div class="col-md-4">
                                <input id="date" type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{ $data['date'] ? $data['date'] : old('date') }}" placeholder="上映時間" required>                            
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="seat" class="col-md-4 col-form-label text-md-right">{{ ('張數') }}</label>
                            <div class="col-md-4">
                                <input id="seat" type="text" class="form-control{{ $errors->has('seat') ? ' is-invalid' : '' }}" name="seat" value="{{ $data['seat'] ? $data['seat'] : old('seat') }}" maxlength="6" placeholder="類型" required>                            
                                    @if ($errors->has('seat'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('seat') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="length" class="col-md-4 col-form-label text-md-right">{{ ('片長') }}</label>
                            <div class="col-md-4">
                                <input id="length" type="text" class="form-control{{ $errors->has('length') ? ' is-invalid' : '' }}" name="length" value="{{ $data['Length'] ? $data['Length'] : old('length') }}" maxlength="6" placeholder="片長" required>                            
                                    @if ($errors->has('length'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('length') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="grade" class="col-md-4 col-form-label text-md-right">{{ ('分級') }}</label>
                                <div class="col-md-4">
                                    <select id="grade" name="grade"  class="form-control" style="text-align:center;text-align-last:center;"> 
                                                    <option value="0" @if($data['Grade']=='0') selected @endif>普通級</option> 
                                                    <option value="1" @if($data['Grade']=='1') selected @endif>保護級</option> 
                                                    <option value="2" @if($data['Grade']=='2') selected @endif>輔12級</option> 
                                                    <option value="3" @if($data['Grade']=='3') selected @endif>輔15級</option> 
                                                    <option value="4" @if($data['Grade']=='4') selected @endif>限制級</option> 
                                                </select>
                                        @if ($errors->has('grade'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('grade') }}</strong>
                                            </span>
                                        @endif
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="director" class="col-md-4 col-form-label text-md-right">{{ ('導演') }}</label>
                            <div class="col-md-4">
                                <input id="director" type="text" class="form-control{{ $errors->has('director') ? ' is-invalid' : '' }}" name="director" value="{{ $data['Director'] ? $data['Director'] : old('director') }}" placeholder="導演" required>                            
                                    @if ($errors->has('director'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('director') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="actor" class="col-md-4 col-form-label text-md-right">{{ ('演員') }}</label>
                            <div class="col-md-4">
                                <input id="actor" type="text" class="form-control{{ $errors->has('actor') ? ' is-invalid' : '' }}" name="actor" value="{{ $data['Actor'] ? $data['Actor'] : old('actor') }}"  placeholder="演員" required>
                                    @if ($errors->has('actor'))
                                    
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('actor') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="poster" class="col-md-4 col-form-label text-md-right">{{ ('海報') }}</label>
                            <div class="col-md-4" style="position: relative;">
                                <input id="poster" type="file" class="form-control{{ $errors->has('poster') ? ' is-invalid' : '' }}" name="poster" placeholder="海報"  onchange="readURL(this)" targetID="preview_poster_img" accept="image/gif,image/jpeg,image/png">                                
                                    @if ($errors->has('poster'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('poster') }}</strong>
                                        </span>
                                    @endif  
                            </div>
                            <div class="col-md-4" style="position: absolute;margin-left:480px">
                                <img id="preview_poster_img" src="{{ asset('/img/'.$data['Poster'])}}" width="200" height="250"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="introduction" class="col-md-4 col-form-label text-md-right">{{ ('劇情簡介') }}</label>
                            <div class="col-md-4">
                                <textarea id="introduction" cols="50" rows="5" class="form-control{{ $errors->has('introduction') ? ' is-invalid' : '' }}" name="introduction" value="{{ $data['Introduction'] ? $data['Introduction'] : old('introduction') }}" placeholder="劇情簡介" required>{{ $data['Introduction'] ? $data['Introduction'] : old('introduction') }}
                                    @if ($errors->has('introduction'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('introduction') }}</strong>
                                        </span>
                                    @endif  
                                </textarea>                        
                            </div>    
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ ('確定') }}
                                </button>
                                <a href="/moviemanager"  style="text-decoration:none;color:seashell">
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
