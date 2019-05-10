@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Time Add') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ ('新增時刻') }}</div>
                @foreach ($Data as $data)
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
                                    {{-- <select id="hall" name="hall"  class="form-control" style="text-align:center;text-align-last:center;"> 
                                                    <option value="0" @if($Hall == '0') hidden @else @if((count($data)>2)&&($data['Hall']=='0')) selected @else  @endif @endif>1廳</option> 
                                                    <option value="1" @if($Hall == '1') hidden @else @if((count($data)>2)&&($data['Hall']=='1')) selected @else  @endif @endif>2廳</option> 
                                                    <option value="2" @if($Hall == '2') hidden @else @if((count($data)>2)&&($data['Hall']=='2')) selected @else  @endif @endif>3廳</option> 
                                                    <option value="3" @if($Hall == '3') hidden @else @if((count($data)>2)&&($data['Hall']=='3')) selected @else  @endif @endif>4廳</option> 
                                                    <option value="4" @if($Hall == '4') hidden @else @if((count($data)>2)&&($data['Hall']=='4')) selected @else  @endif @endif>5廳</option>
                                                    <option value="5" @if($Hall == '5') hidden @else @if((count($data)>2)&&($data['Hall']=='5')) selected @else  @endif @endif>6廳</option>
                                                    <option value="6" @if($Hall == '6') hidden @else @if((count($data)>2)&&($data['Hall']=='6')) selected @else  @endif @endif>7廳</option> 
                                    </select> --}}
                                    <select id="hall" name="hall"  class="form-control{{ $errors->has('hall') ? ' is-invalid' : '' }}" style="text-align:center;text-align-last:center;"> 
                                        @foreach ($Hall as $hall)
                                            <option value={{$hall}} @if((count($data)>2)&&($data['Hall']==$hall)) selected @else  @endif >{{$hall . ('廳')}}</option> 
                                        @endforeach         
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
                            <input type="checkbox" value="1" checked id="date" name="date">
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
                                    <input id="seat" type="number" class="form-control{{ $errors->has('seat') ? ' is-invalid' : '' }}" name="seat" value="{{ $data['Seat'] ? $data['Seat'] : old('seat') }}" maxlength="6" placeholder="席位" required>                            
                                @else
                                    <input id="seat" type="number" class="form-control{{ $errors->has('seat') ? ' is-invalid' : '' }}" name="seat" value="{{ old('seat') }}" maxlength="6" placeholder="席位" required>                            
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
                @endforeach
                {{-- @endforeach --}}
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
