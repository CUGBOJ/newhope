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
        <h1>注册</h1>
        @include('share._error')
        <i-col span="6" offset="6">
            <i-form :label-width="80" action="{{ route('users.store') }}" method="POST">
                {{ csrf_field() }}
                <form-item label="用户名">
                    <i-input name="username" value="{{ old('username') }}" clearable> </i-input>
                </form-item>
                <form-item label="昵称">
                    <i-input name="nickname" value="{{ old('nickname') }}" clearable> </i-input>
                </form-item>
                <form-item label="邮箱">
                    <i-input name="email" type="email" value="{{ old('email') }}" clearable> </i-input>
                </form-item>
                <form-item label="密码">
                    <i-input name="password" type="password" clearable> </i-input>
                </form-item>
                <form-item label="确认密码">
                    <i-input name="password_confirmation" type="password" clearable></i-input>
                </form-item>
                <form-item label="学校">
                    <i-input name="school" value="{{ old('school') }}" clearable></i-input>
                </form-item>
                <button-group style="float: right">
                    <i-button type="primary" html-type="submit">注册</i-button>
                    <i-button type="warning" html-type="reset">重置</i-button>
                </button-group>
            </i-form>
        </i-col>
    </div>
@stop


