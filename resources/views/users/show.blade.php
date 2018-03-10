<?php
/**
 * Created by PhpStorm.
 * User: Wrzz
 * Date: 2018/2/7
 * Time: 2:26
 */
?>
@extends('layout.default')
@section('title', '个人中心')

@section('content')
    <div>
        @include('share._error')
    <h2>this is imformation of  {{$user->username}}</h2>
        <img  src="{{ $user->avatar }}" width="300px" height="300px">
    <p>
        his email is  {{$user->email}}
    </p>
        <p>
            his nickname is {{$user->nickname}}
        </p>
        <p>
            his school is  {{$user->school}}
        </p>
        <p>
            his last_login_ip is  {{$user->last_login_ip}}
        </p>
        <p>
            his last_login_time is  {{$user->last_login_time}}
        </p>
        <p>
            his created_at is  {{$user->register_time}}
        </p>
        <p>
            his solved is  {{$user->solved}}
        </p>
        <p>
            his submit is  {{$user->submit}}
        </p>
        <p>
            his role is  {{$user->role->id}}
        </p>

    </div>
@stop


