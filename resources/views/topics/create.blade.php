
@extends('layout.default')
@section('title', '创建题目')

@section('content')
    <div>
        <h1>创建题目</h1>
        @include('share._error')
        <form action="{{ route('topics.store') }}"  method="POST"  id="create_topic" >
            {{ csrf_field() }}
            Title:<input type="text" name="title" id="title">
            <br>
            Problem id:<input type="text" name="pro_id" id="pro_id">
            <br>
            <button type="submit">提交</button>
        </form>
        <textarea name="body" id="body" cols="30" rows="10" form="create_topic">

        </textarea>

        </div>
    </div>
@stop


