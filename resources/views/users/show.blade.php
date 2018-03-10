@extends('layout.default')
@section('title', '个人中心')

@section('content')
    <div>
        @include('share._error')
        <profile></profile>
        {{$user->topics}}
    </div>
@stop