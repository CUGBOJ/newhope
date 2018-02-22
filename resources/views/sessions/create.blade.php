@extends('layout.default')
@section('title', '登录')

@section('content')
    <div style="width:50%;">
        @include('share._error')
        <login></login>
    </div>
@stop