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
        @include('share._error')
        <form action="{{ route('users.store') }}"  method="POST" style="margin: 200px 600px">
            {{ csrf_field() }}
            <input type="text" name="name" id="name"  value="{{ old('name') }}">用户名
            <br>
            <input type="password"  name="password" id="password" >密码
            <br>
            <input type="password"  name="password_confirmation" id="password_confirmation">确认密码
            <br>
            <input type="email" name="email" id="email"  value="{{ old('email') }}">邮箱
            <br>
            <button type="submit">注册</button>
            <button type="reset">reset</button>

        </form>
    </div>
@stop


