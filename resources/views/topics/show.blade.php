@extends('layout.default')
@section('title', 'discuss')

@section('content')
    <div>
        @include('share._error')
        <h1>{{$topic->title}}</h1>
        <div>
            <div>
                内容：{{$topic->body}}
                <br>
                创建者：{{$topic->username}}
                <br>
                时间：{{$topic->created_at}}
            </div>
    </div>

@stop


