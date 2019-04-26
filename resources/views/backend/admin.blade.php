{{-- @section('content')
<div class="container">
    <h1>login</h1>
</div> --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ ('帳號管理') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin') }}">
                        @csrf

                        <div class="form-group row">
                            {{-- <label for="account" class="col-md-4 col-form-label text-md-right">{{ ('帳號') }}</label> --}}
                            {{-- @php --}}
                                {{-- dd({{$User}});    --}}
                            {{-- @endphp --}}
                            
                           
                            <div class="col-md-12">
                                <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border='1'> 
                                    <tr>
                                        <td>帳號</td>
                                        <td>等級</td>
                                        <td>啟用/凍結</td>
                                        <td>創建時間</td>
                                        <td>修改時間</td>
                                        <td colspan="2">操作</td>
                                    </tr>
                                    @foreach ($User as $user)
                                        <tr>
                                            <td>{{$user['account']}}</td>
                                            <td>{{$user['level']}}</td>
                                            <td>{{$user['freeze']}}</td>
                                            <td>{{$user['created_at']}}</td>
                                            <td>{{$user['updated_at']}}</td>     
                                            <td>
                                                <button type="button" class="btn btn-primary" onclick="openwin()">
                                                    {{ ('修改') }}
                                                    {{-- <a href="/admin/{{$user['uid']}}" style="text-decoration: none; color: seashell;">{{ ('修改') }}</a> --}}
                                                </button>
                                            </td>     
                                            <td>
                                                <button type="submit" class="btn btn-primary">{{ ('刪除') }}</button>
                                            </td>                                        
                                        </tr>
                                    @endforeach
                                </table>
                            </div>    
                        </div>
                    </form>
                </div>
                <div id ="updateform" class="col-md-12" style="display:none;">
                    <table class="" style="border:3px #cccccc solid;margin:auto;text-align:center;" cellpadding="10" border='1'> 
                        <tr colspan="2">
                            <td>帳號</td>
                            <td colspan="2">{{$user['account']}}</td>
                        </tr>
                        <tr> 
                            <td>Levl</td>
                            <td colspan="2">
                                <input id="name" style="text-align:center" value = "{{$user['level']}}">
                            </td>
                        </tr>
                        <tr>
                            <td>啟用/凍結</td>
                            <td colspan="2">
                                <input id="freeze" style="text-align:center" value = "{{$user['freeze']}}">
                            </td> 
                        </tr>
                        <tr>
                            
                            <td  colspan="2">
                                {{-- <a href="/admin/{{$User['uid']}}" style="text-decoration: none; color: seashell;"> --}}
                                    <button type="button" class="btn btn-primary" onclick="update({{$user['level']}})">{{ ('確認') }}</button>        
                                <a href="/admin"  style="text-decoration:none;color:seashell">
                                    <button type="button" class="btn btn-primary">{{ ('取消') }}</button>
                                </a>
                            </td>                                            
                        </tr>
                    </table>
                </div>   
            </div>
        </div>
    </div>
</div>

<script>
    // function updateform(id){
    //     $('#updatafrom').click(updateform ,function()){
    //         window.open("updateform", "newwindow", "height=100, width=400, toolbar =no, menubar=no, scrollbars=no, resizable=no, location=no, status=no");
    //     });
    // };
    　　    function openwin() {

            var screenWidth = $(window).width();
            var screenHeight = $(window).height(); 
            var scrolltop = $(document).scrollTop();//獲取當前視窗距離頁面頂部高度
            var Left = (screenWidth )/2 ;
            var Top = (screenHeight)/2;
            
　　        OpenWindow = window.open("", "newwin", "height=500, width=500, left=500px, top=250px, toolbar=no ,scrollbars=" + scroll + ",menubar=no");
　　        //写成一行 
　　        OpenWindow.document.write("<TITLE>修改</TITLE>")
　　        OpenWindow.document.write("<BODY BGCOLOR=#ffffff>")
　　        OpenWindow.document.write("<h1>Hello!</h1>")
　　        OpenWindow.document.write("New window opened!")
　　        OpenWindow.document.write("</BODY>")
　　        OpenWindow.document.write("</HTML>")
　　        OpenWindow.document.close()
    }

</script>
@endsection