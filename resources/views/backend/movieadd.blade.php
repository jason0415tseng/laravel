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
                <div class="card-header">{{ ('新增電影') }}</div>
    {{--<table>
         <thead>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Createdat</th>
                <th>Actions</th>
            </tr>
        </thead> 
        <tbody>
            <tr>
                <th>片名</th>
                <td>asdasdad</td>
            </tr>
            <tr>
                <th>英文片名</th>
                <td>asdasdad</td>
            </tr>
            <tr>
                <th>上映時間</th>
                <td>asdasdad</td>
            </tr>
            <tr>
                <th>類型</th>
                <td>asdasdad</td>
            </tr>
            <tr>
                <th>片長</th>
                <td>asdasdad</td>
            </tr>
            <tr>
                <th>分級</th>
                <td>asdasdad</td>
            </tr>
            <tr>
                <th>導演</th>
                <td>asdasdad</td>
            </tr>
            <tr>
                <th>演員</th>
                <td>asdasdad</td>
            </tr>
            <tr>
                <th>Actions</th>
                <td>asdasdad</td>
            </tr>
        </tbody>
    </table>--}}
                <div class="card-body">
                    <form method="POST" action="{{ route('moive.movieadd') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="account" class="col-md-4 col-form-label text-md-right">{{ ('片名') }}</label>
                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="片名" required autofocus>                            
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="name_en" class="col-md-4 col-form-label text-md-right">{{ ('英文片名') }}</label>
                            <div class="col-md-4">
                                <input id="name_en" type="text" class="form-control{{ $errors->has('name_en') ? ' is-invalid' : '' }}" name="name_en" value="{{ old('name_en') }}" placeholder="英文片名" required>                            
                                    @if ($errors->has('name_en'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name_en') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="ondate" class="col-md-4 col-form-label text-md-right">{{ ('上映時間') }}</label>
                            <div class="col-md-4">
                                <input id="ondate" type="date" class="form-control{{ $errors->has('ondate') ? ' is-invalid' : '' }}" name="ondate" value="{{ old('ondate') }}" placeholder="上映時間" required>                            
                                    @if ($errors->has('ondate'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ondate') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ ('類型') }}</label>
                            <div class="col-md-4">
                                <input id="type" type="text" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" value="{{ old('type') }}" maxlength="6" placeholder="類型" required>                            
                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif                          
                            </div>    
                        </div>
                        <div class="form-group row">
                            <label for="length" class="col-md-4 col-form-label text-md-right">{{ ('片長') }}</label>
                            <div class="col-md-4">
                                <input id="length" type="text" class="form-control{{ $errors->has('length') ? ' is-invalid' : '' }}" name="length" value="{{ old('length') }}" maxlength="6" placeholder="片長" required>                            
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
                                    {{-- <input id="grade" type="text" class="form-control{{ $errors->has('grade') ? ' is-invalid' : '' }}" name="grade" value="{{ old('grade') }}" placeholder="分級" required> --}}
                                    <select id="grade" name="grade"  class="form-control" style="text-align:center;text-align-last:center;"> 
                                                    <option value="grade_0">普通級</option> 
                                                    <option value="grade_6">保護級</option> 
                                                    <option value="grade_12">輔12級</option> 
                                                    <option value="grade_18">輔15級</option> 
                                                    <option value="grade_18">限制級</option> 
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
                                <input id="director" type="text" class="form-control{{ $errors->has('director') ? ' is-invalid' : '' }}" name="director" value="{{ old('director') }}" placeholder="導演" required>                            
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
                                <input id="actor" type="text" class="form-control{{ $errors->has('actor') ? ' is-invalid' : '' }}" name="actor" value="{{ old('actor') }}"  placeholder="演員" required>
                                    @if ($errors->has('actor'))
                                    
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('actor') }}</strong>
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="poster" class="col-md-4 col-form-label text-md-right">{{ ('海報') }}</label>
                            <div class="col-md-4">
                                <input id="poster" type="file" class="form-control{{ $errors->has('poster') ? ' is-invalid' : '' }}" name="poster" placeholder="海報"  onchange="readURL(this)" targetID="preview_poster_img" accept="image/gif,image/jpeg,image/png" required>
                                 <img id="preview_poster_img" src="#" width="80" height="80" style="display: none;"/>
                                 
                                    @if ($errors->has('poster'))
                                    {{-- @php
                                    dd($errors);
                                    @endphp --}}
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('poster') }}</strong>
                                        </span>
                                    @endif  
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="introduction" class="col-md-4 col-form-label text-md-right">{{ ('劇情簡介') }}</label>
                            <div class="col-md-4">
                                <textarea id="introduction" cols="50" rows="5" class="form-control{{ $errors->has('introduction') ? ' is-invalid' : '' }}" name="introduction" value="{{ old('introduction') }}" placeholder="劇情簡介" required>
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

</script>
@endsection
