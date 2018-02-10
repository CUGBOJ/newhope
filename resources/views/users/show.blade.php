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
            his created_at is  {{$user->created_at}}
        </p>
        <p>
            his updated_at is  {{$user->updated_at}}
        </p>
        <p>
            his solved is  {{$user->solved}}
        </p>
        <p>
            his submit is  {{$user->submit}}
        </p>
        <p>
            <?php
            if($user->is_admin==true)
                {
                    echo "he is a admin.";
                }
            else {
                echo "he is not admin";
            }
            ?>
        </p>
    </div>
@stop


