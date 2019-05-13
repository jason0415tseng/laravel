@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ ('訂購資訊') }}</div>

                    <div class="card-body">
                    <form method="POST" action="{{ route('memberCenter.user') }}">
                        @csrf

                        <div class="form-group row">                          
                            <div class="col-md-12">
                                <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border="1"> 
                                    @if(count($Order)<1)
                                        <h3>{{('無訂購資料')}}</h3>
                                    @else
                                        <tr>
                                            <td>訂票號碼</td>
                                            <td>電影名稱</td>
                                            <td>廳別</td>
                                            <td>時刻</td>
                                            <td>人數</td>
                                            <td>帳號</td>
                                            <td>名稱</td>
                                            <td>訂購時間</td>
                                        </tr>
                                        @foreach ($Order as $order)
                                            <tr>
                                                <td>
                                                    {{$order['ordernumber']}}
                                                </td>
                                                <td>
                                                    {{$order['name']}}
                                                </td>
                                                <td>
                                                    {{$order['orderhall'] . ('廳')}}
                                                </td>
                                                <td>
                                                {{-- @php
                                                dd($Order)    
                                                @endphp --}}
                                                {{$order['orderdate']}}
                                                    {{-- @if($order['orderdate'] == '1')
                                                        <div class="" ><span>10:00</span></div>
                                                    @elseif($value == '2')
                                                        <div class="col-md-4 col-form-label text-md-left" style="font-size:18px;"><span>12:20</span></div>
                                                    @endif --}}
                                                </td>
                                                <td>
                                                    {{$order['orderseat']}}
                                                </td>
                                                <td>
                                                    {{$order['orderaccount']}}
                                                </td>
                                                <td>
                                                    {{$order['ordername']}}
                                                </td>
                                                <td>
                                                    {{$order['created_at']}}
                                                </td>
                                            </tr>   
                                        @endforeach
                                    @endif
                                </table>
                            </div>    
                        </div>
                    </form>
                    </div> 
                </div> 
            </div>
        </div>
    </div>
</div>
<script>
    var msg = '{{ $errors->first('messages')}}';
    if(msg){
        alert(msg);
    }
</script>
@endsection