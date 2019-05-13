@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Order Add') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ ('選位') }}</div>
                {{-- @foreach ($Data as $data) --}}
                <div class="card-body">
                    <form method="POST" action="{{ route('movielist.orderadd' , ['Mid'=> $Data['mid']]) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                                <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('票名') }}</label>
                                <div class="col-md-4 col-form-label text-md-left">
                                    {{$Data['name']}}
                                </div>
                        </div>
                        <div class="form-group row">
                                <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('廳別') }}</label>
                                <div class="col-md-4 col-form-label text-md-left">
                                <input id="hall" type="text" name="hall" value="{{ $Data['hall'] }}" placeholder="時刻" required style="display:none"> 
                                    {{$Data['hall'] . ('廳')}}
                                    
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right"><i class="far fa-clock"></i></label>
                            <!-- <div class="col-md-4"> -->
                                <!-- <input id="date" type="text" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{ old('date') }}" placeholder="時刻" required>                            
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif                           -->
                                    {{-- @foreach ($data['Date'] as $key => $value) --}}

                                <div class="col-md-1 col-form-label">
                                    <div type="text" id='date' name='date' value="{{$Data['date']}}">{{$Data['date']}}</div> 
                                </div>   
                                {{-- @if($value == '1')
                                <input id="date" type="text" name="date" value="{{ $value }}" placeholder="時刻" required style="display:none"> 
                                    <div class="col-md-4 col-form-label text-md-left" style="font-size:18px;"><span>10:00</span></div>
                                @elseif($value == '2')
                                <input id="date" type="text" name="date" value="{{ $value }}" placeholder="時刻" required style="display:none"> 
                                    <div class="col-md-4 col-form-label text-md-left" style="font-size:18px;"><span>12:20</span></div>
                                @endif --}}
                                {{-- @endforeach --}}
                            <!-- </div>     -->
                        </div>
                        <!-- <div class="form-group row">
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
                        </div> -->
                        <div class="form-group row">
                            <label for="seat" class="col-md-4 col-form-label text-md-right">{{ ('數量') }}</label>
                            <div class="col-md-4">
                                
                                <div class="col-md-1 col-form-label">
                                    <div type="text" id='seat' name='seat' value="{{$Data['seat']}}">{{$Data['seat']}}</div> 
                                </div> 
                                                         
                            </div>    
                        </div>
                        
                    </form>
                </div>
                {{-- @endforeach --}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="col-md-4 col-form-label">
                    <table style="margin: 0 auto;border-collapse: separate !important;border-spacing: 5px !important;">
                        <tbody>
                @foreach ($Seat as $seat)
                {{-- @php
                 dd($Seat)   
                @endphp     --}}
                {{-- <div class="col-md-1 col-form-label">
                    <input type="radio" id='date' name='date' value="{{$value}}">{{$value}}</input> 
                </div>   --}}
                {{-- <div class="col-md-4 col-form-label"> --}}
                    @if($seat>5)
                    {{-- @php
                    dd($seat>5)
                    @endphp --}}
                    <tr>
                        {{-- <td style="background-color:#f7597b;"><input type="checkbox" name="seat[]" value={{$seat}}> --}}
                        <td style="text-align: center;min-width: 25px !important;height: 22px;color: #FFF;font-size: 0.8em;line-height: 22px !important;background: #ccc;border-radius: 3px;cursor: pointer;">
                            {{-- <input type="checkbox" name="seat[]" value={{$seat}}> --}}
                            <div class="ng-binding ng-scope">{{$seat}}</div>
                            {{-- {{('AA')}} --}}
                        </td>
                    </tr>
                    @else
                    {{-- <tr> --}}
                        <td style="text-align: center;min-width: 25px !important;height: 22px;color: #FFF;font-size: 0.8em;line-height: 22px !important;background: #ccc;border-radius: 3px;cursor: pointer;">
                            {{-- <input type="checkbox" name="seat[]" value={{$seat}}> --}}
                            <div class="ng-binding ng-scope">{{$seat}}</div>
                            {{-- {{('AA')}} --}}
                        </td>
                        {{-- <td style="background-color:#2799dd;"> <input type="checkbox" name="seat[]" value={{$seat}}>
                            {{('BB')}}
                        </td> --}}
                    {{-- </tr> --}}
                    @endif
                {{-- </div> --}}
                @endforeach
                </tbody>
                </table>
                </div>
             <div class="card-body">asdadsasd</div>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ ('確定') }}
                </button>
                {{-- <a href="/movielist"  style="text-decoration:none;color:seashell"> --}}
                    <button type="button" class="btn btn-primary" onclick="window.history.go(-1)">{{ ('回上一頁') }}</button>
                {{-- </a> --}}
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
