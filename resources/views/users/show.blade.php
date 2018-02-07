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
    <h2>this is imformation of <?php echo $user->name; ?></h2>
    <p>
        his email id  <?php echo $user->email;?>
    </p>
    </div>
@stop


