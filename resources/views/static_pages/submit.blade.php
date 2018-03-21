@extends('layout.default')
@section('title', 'submit')

@section('content')

    <form action="{{route('judge')}}"  enctype="multipart/form-data" method="POST">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        问题id
        <input type="text" name="pid" id="pid" value="{{ isset($pid)?$pid:null}}">
        <br>语言选择
        <select name="lang">
            <option value="1">c</option>
            <option value="2">c++</option>
            <option value="3">java</option>
            <option value="4">c#</option>
            <option value="5">python2</option>
            <option value="6">python3</option>
            <option value="7">ruby</option>
            <option value="8">pascal</option>
        </select>
        <div class="form-group">
            <label >上传代码</label>
            <input type="file" name="code" id="code">
        </div>
        <button type="submit" class="btn btn-primary">提交</button>
    </form>

@stop