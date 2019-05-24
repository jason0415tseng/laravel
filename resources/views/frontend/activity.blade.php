@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group row">
                <div class="col-md-12">
                    <table style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border="1">
                        @if(count($activityData)<1)
                            <h3>{{('無任何活動')}}</h3>
                        @else
                            <tr>
                                <td>活動名稱</td>
                                <td>發起人</td>
                                <td>開始日</td>
                                <td>截止日</td>
                                <td>目前狀態</td>
                                <td>結果</td>
                            </tr>
                            @foreach ($activityData as $data)
                                <tr>
                                    <td>
                                        {{$data['title']}}
                                    </td>
                                    <td>
                                        {{$data['author']}}
                                    </td>
                                    <td>
                                        {{$data['startdate']}}
                                    </td>
                                    <td>
                                        {{$data['enddate']}}
                                    </td>
                                    <td>
                                        @if($nowTime > $data['enddate'])
                                            <div style="color:red;font-weight: bold;">{{ ('已截止') }}</div>
                                        @else
                                            @if(isset($voted))
                                                @if($voted->contains('voteaid',$data['aid']))
                                                    {{('已投票')}}
                                                @else
                                                    <a href="/activity/detail/{{$data['aid']}}">
                                                        {{('參加投票')}}
                                                    </a>
                                                @endif
                                            @else
                                                @if(session('account'))
                                                    <a href="/activity/detail/{{$data['aid']}}">
                                                        {{('參加投票')}}
                                                    </a>
                                                @else
                                                    {{('投票中')}}
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/activity/voteresult/{{$data['aid']}}">
                                            {{$data['votenumber']}}
                                        </a>
                                    </td>
                                    @if($data['author'] == session('account'))
                                        <td>
                                            <form method="POST" action="{{ route('activity.destroy', ['aid'=> $data['aid']]) }}">
                                                @csrf @method('delete')
                                                <a href="/activity/update/{{$data['aid']}}"  style="text-decoration:none;color:seashell">
                                                    <button type="button" class="btn btn-primary">{{ ('修改') }}</button>
                                                </a>
                                                <button type="submit" class="btn btn-primary" onclick="return confirm('是否確認刪除這筆資料');">{{ ('刪除') }}</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    @if(session('account'))
                        <a href="/activity/add" style="text-decoration:none;color:seashell">
                            <button type="button" class="btn btn-primary">{{ ('新增活動') }}</button>
                        </a>
                    @else
                    @endif
                    <a href="/" style="text-decoration:none;color:seashell">
                        <button type="button" class="btn btn-primary">{{ ('上一頁') }}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
