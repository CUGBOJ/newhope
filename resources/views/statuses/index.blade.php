<?php
use Illuminate\Support\Facades\DB;
$op=['=','=','=','='];
if(empty($pro_id)){
    $op[0]='like';
    $pro_id='%%';
}
if(empty($username)){
    $op[1]='like';
    $username='%%';
}if(empty($res)){
    $op[2]='like';
    $res='%%';
}if(empty($lang)){
    $op[3]='like';
    $lang='%%';
}
$statuses = DB::table('statuses')->where([
    ['Problem_id',$op[0], $pro_id],
    ['Username', $op[0], $username],
    ['Result',$op[0],$res],
    ['Lang',$op[0],$lang],
])->get();
if($pro_id){

}
?>
@extends('layout.default')
@section('title', 'Statuses')

@section('content')
    {{--{{$pro_id}}--}}
    <div class="col-md-offset-2 col-md-8">
        <h1>过题记录</h1>
        <ul class="statuses">
            @foreach ($statuses as $status)
                @include('statuses._status')
            @endforeach
        </ul>
        {{--{!! $statuses->render() !!}--}}
    </div>
@stop