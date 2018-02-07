@extends('layout.default')
@section('title', '登录')

@section('content')
    <div>
        <h1>这是登陆！！！</h1>
        @include('share._error')
        <form action="{{ route('login') }}"  method="POST" style="margin: 200px 600px">
            {{ csrf_field() }}
            <input type="text" name="name" id="name"  value="{{ old('name') }}">用户名
            <br>
            <input type="password"  name="password" id="password" >密码
            <br>
            <input type="email" name="email" id="email"  value="{{ old('email') }}">邮箱
            <br>
            <button type="submit">登陆</button>
            <button type="reset">reset</button>

        </form>
    </div>
@stop