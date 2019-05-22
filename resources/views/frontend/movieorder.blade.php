@extends('layouts.app')


@section('content')


<div class="container">
    <h1>{{ ('Order Add') }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ ('訂購') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('movie.orderselectseat' , ['Mid'=> $MovieData['Mid']]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ ('票名') }}</label>
                            <div class="col-md-4 col-form-label text-md-left">
                                {{$MovieData['Name']}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hall" class="col-md-4 col-form-label text-md-right">{{ ('廳別') }}</label>
                            <div class="col-md-4 col-form-label text-md-left">
                                <input id="hall" type="text" name="hall" value="{{ $MovieData['Hall'] }}" required style="display:none">
                                    {{$MovieData['Hall'] . ('廳')}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ ('場次') }}</label>
                            <div class="col-md-4">
                                <select id="time" name="time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" style="text-align: center;">
                                    @foreach ($TimeSeat as $timeseat)
                                        <option value="{{$timeseat['Time']}}">{{$timeseat['Time'] . ('  剩餘座位：'). $timeseat['Seat'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('time'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                @endif
                            </div>
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
                                <a href="/movie"  style="text-decoration:none;color:seashell">
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
@endsection
