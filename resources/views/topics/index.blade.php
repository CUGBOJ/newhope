<?php
$op=['=','='];
if(empty($pro_id)){
    $op[0]='like';
    $pro_id='%%';
}
if(empty($username)){
    $op[1]='like';
    $username='%%';
}
$topics = DB::table('topics')->where([
    ['pro_id',$op[0], $pro_id],
    ['username', $op[1], $username],
])->get();
?>

@extends('layout.default')
@section('title', 'Discuss')

@section('content')
    <div class="col-md-offset-2 col-md-8">
        <h1>所有讨论</h1>
         <a href="{{route('topics.create')}}"><h3>创建讨论：</h3></a>
        <ul class="topics">
            @foreach ($topics as $topic)
                @include('topics._topic')
            @endforeach
        </ul>
    </div>
@stop