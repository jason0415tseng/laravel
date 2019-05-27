@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ ('訂購資訊') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border="1">
                                    @if(!isset($orderList))
                                        <h3>{{('無訂購資料')}}</h3>
                                    @else
                                        <tr>
                                            <td>訂票號碼</td>
                                            <td>電影名稱</td>
                                            <td>廳別</td>
                                            <td>時刻</td>
                                            <td>人數</td>
                                            <td>座位</td>
                                            <td>帳號</td>
                                            <td>名稱</td>
                                            <td>訂購時間</td>
                                        </tr>
                                        @foreach ($orderList as $order)
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
                                                    {{$order['ordertime']}}
                                                </td>
                                                <td>
                                                    {{$order['orderticket']}}
                                                </td>
                                                <td>
                                                    {!!$order['orderseat']!!}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection