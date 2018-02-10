<?php
/**
 * Created by PhpStorm.
 * User: Wrzz
 * Date: 2018/2/7
 * Time: 2:26
 */
?>
@extends('layout.default')
@section('title', '注册')

@section('content')
    <div>
        <h1>这是注册！！！</h1>
        @include('share._error')
        <form action="{{ route('users.store') }}"  method="POST" style="margin: 200px 600px">
            {{ csrf_field() }}
            <div>
                <label for="username">用户名：</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" >
            </div>
            <div>
                <label for="nickname">昵称：</label>
                <input type="text" name="nickname" class="form-control" value="{{ old('nickname') }}">
            </div>
            <div>
                <label for="email">邮箱：</label>
                <input type="text" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div>
                <label for="password">密码：</label>
                <input type="password" name="password" class="form-control" value="{{ old('password') }}">
            </div>
            <div>
                <label for="password_confirmation">确认密码：</label>
                <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
            </div>
            <div>
                <label for="school">学校：</label>
                <input type="text" name="school" class="form-control" value="{{ old('school') }}" >
            </div>
            <button type="submit">注册</button>
            <button type="reset">reset</button>

        </form>
    </div>
@stop


