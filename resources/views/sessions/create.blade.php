@extends('layout.default')
@section('title', '登录')

@section('content')
    <div>
        <h1>这是登陆！！！</h1>
        @include('share._error')
        <form action="{{ route('login') }}"  method="POST" style="margin: 200px 600px">
            {{ csrf_field() }}
            <input type="text" name="username" id="username"  value="{{ old('username') }}">用户名
            <br>
            <input type="password"  name="password" id="password" >密码
            <br>
            <button type="submit">登陆</button>
            <button type="reset">reset</button>

        </form>
    </div>
@stop