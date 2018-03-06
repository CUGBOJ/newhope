@extends('layout.default')
@section('title', $contest->title)

@section('content')
        @include('share._error')

        @cannot('cant_go',$contest)
            <form action="{{ route('contests.add_user',$contest->id) }}" method="post">
                {{ csrf_field() }}
                密码：<input type="password" name="password" id="password">
                <button type="submit">提交</button>
            </form>
        @endcan
@stop


