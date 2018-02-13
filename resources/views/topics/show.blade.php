@extends('layout.default')
@section('title', 'discuss')

@section('content')
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
    @can('update', $topic)
        <div class="operate">
            <hr>
            <a href="{{ route('topics.edit', $topic->id) }}" role="button">
                <i></i> 编辑
            </a>

            <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" style="margin-left: 6px">
                    <i></i>
                    删除
                </button>
            </form>
        </div>
    @endcan
    <div class="replys">
        <div>
            {{--@include('topics._reply_box', ['topic' => $topic])--}}
            @include('topics._reply_list', ['replies' => $topic->replies])
        </div>
    </div>

@stop


