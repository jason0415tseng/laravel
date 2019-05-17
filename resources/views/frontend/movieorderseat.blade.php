@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Order Add') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ ('選位') }}</div>
                <div class="card-body">
                    @csrf
                        <div class="form-group row">
                            <label for="hall" class="col-md-5 col-form-label text-md-right">{{ ('票名') }}</label>
                            <div id="name" name="name" value="{{$Data['name']}}" class="col-md-4 col-form-label text-md-left">
                                {{$Data['name']}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hall" class="col-md-5 col-form-label text-md-right">{{ ('廳別') }}</label>
                            <div id="hall" name="hall" value="{{ $Data['hall'] }}" class="col-md-4 col-form-label text-md-left">
                                {{$Data['hall'] . ('廳')}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-5 col-form-label text-md-right"><i class="far fa-clock"></i></label>
                                <div  id="date" name="date" value="{{$Data['date']}}" class="col-md-1 col-form-label">
                                   {{$Data['date']}}
                                </div>
                        </div>

                        <div class="form-group row">
                            <label for="ticket" class="col-md-5 col-form-label text-md-right">{{ ('數量') }}</label>
                                <div id="ticket" name="ticket" value="{{ $Data['ticket'] }}" class="col-md-1 col-form-label">
                                    {{$Data['ticket']}}
                                </div>
                        </div>

                        <div class="form-group row">
                            <label for="selectseat" class="col-md-5 col-form-label text-md-right">{{ ('已選座位') }}</label>
                            <div class="col-md-4 col-form-label">
                                    <div class="selectseat">
                                        0
                                    </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="seat" class="col-md-5 col-form-label text-md-right">{{ ('已選票數') }}</label>
                            <div class="col-md-4 col-form-label">
                                    <div class="selectnumber">
                                        0
                                    </div>{{('張票')}}
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="col-md-12 col-form-label">
                    <table id="1" class="Seating-Area" data-area-number="1" cellspacing="0" cellpadding="0" style="left:0%;top:0%;width:100%;height:100%;">
                        <tbody>
                            <tr>
                                <td colspan="1" style="width:50px;"></td>
                                <td colspan="25" class="screen" style="font-size: 1em;border: 1px #CCC solid;color: #999;height: 27px;line-height: 27px !important;-webkit-border-radius: 20px;-moz-border-radius: 20px;border-radius: 20px;text-align: center;">
                                    {{('螢幕')}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="26" style="height: 30px;"></td>
                            </tr>
                            @for ($i=1;$i<=5;$i++)
                                <tr>
                                    <td style="text-align: left;font-size: 0.8em;cursor: pointer;">
                                            {{$i.('排')}}
                                    </td>
                                    @for ($j=1;$j<=4;$j++)
                                        <td class="" data-type="Empty" data-rol="{{$i}}" data-col="{{$j}}" data-seatnum="8" data-status="5" data-areanum="1" >
                                            @if(isset($OrderSeat))
                                                @if(in_array(($i.('_').$j), $OrderSeat))
                                                    <div id="{{$i.('_').$j}}" data-type='Sold' data-row="{{$i}}" data-col="{{$j}}" class="Select" name="selectseat[]" value="{{$i.('_').$j}}" onclick="seat(this)">
                                                        {{$j.('號')}}
                                                    </div>
                                                @else
                                                    <div id="{{$i.('_').$j}}" data-type='Empty' data-row="{{$i}}" data-col="{{$j}}" name="selectseat[]" value="{{$i.('_').$j}}" onclick="seat(this)">
                                                        {{$j.('號')}}
                                                    </div>
                                                @endif
                                            @else
                                                <div id="{{$i.('_').$j}}" data-type='Empty' data-row="{{$i}}" data-col="{{$j}}" name="selectseat[]" value="{{$i.('_').$j}}" onclick="seat(this)">
                                                    {{$j.('號')}}
                                                </div>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary" onclick="Order({{$Data['mid']}})">
                        {{ ('確定') }}
                    </button>
                    <button type="button" class="btn btn-primary" onclick="window.history.go(-1)">{{ ('回上一頁') }}</button>
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
