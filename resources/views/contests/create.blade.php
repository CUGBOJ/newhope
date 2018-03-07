@extends('layout.default')
@section('title', '创建Contests')

@section('content')
    <div>
        <h1>创建Contests</h1>
        @include('share._error')
        <form action={{route('contests.store')}}  method="POST">
            {{ csrf_field() }}
            Title: <input type="text" name="title">
            <br>
            Start_time
            <input type="text" name="start_time" placeholder="eg: 2016-12-31 23:59:59">
            <br>
            End_time
            <input type="text" name="end_time" placeholder="eg: 2016-12-31 23:59:59">
            <br>
            Lock_board_time
            <input type="text" name="lock_board_time" placeholder="eg: 2016-12-31 23:59:59">
            <br>
            公开？
            <input type="radio" name="is_private" value="1" checked>公开
            <input type="radio" name="is_private" value="2">加密
            <br>
            密码：<input type="password" name="password ">
            <br>
            hide_other:
            <input type="radio" name="hide_other" value="1" checked>公开
            <input type="radio" name="hide_other" value="2">加密
            <br>
            Description:
            <textarea name="description" id="description" cols="30" rows="10"></textarea>

            <br>
            <button type="submit">创建</button>
        </form>
    </div>
@stop


