@extends('layout.default')
@section('title', '更新公告')
@section('content')
    <h3>更新题目</h3>
    <div>
        @include('share._error')
        <form method="POST" action="{{ route('announcements.update', $announcement->id )}}" id="edit_announcement">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <input type="text" name="title" id="title" value="{{$announcement->title}}">
            <button type="submit" class="btn btn-primary">修改</button>
        </form>
        <textarea name="body" id="body" cols="30" rows="10" form="edit_announcement">
        {{$announcement->body}}
        </textarea>
    </div>
@stop
