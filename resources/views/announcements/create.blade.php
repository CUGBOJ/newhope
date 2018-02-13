
@extends('layout.default')
@section('title', '创建讨论')

@section('content')
    <div>
        <h1>创建公告</h1>
        @include('share._error')
        <form action="{{ route('announcements.store') }}"  method="POST"  id="create_announcement" >
            {{ csrf_field() }}
            Title:<input type="text" name="title" id="title">
            <br>
            <button type="submit">提交</button>
        </form>
        <textarea name="body" id="body" cols="30" rows="10" form="create_announcement">

        </textarea>

    </div>
    </div>
@stop


