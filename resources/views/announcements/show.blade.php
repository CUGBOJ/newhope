@extends('layout.default')
@section('title', 'announcement')

@section('content')
    @include('share._error')
    <h1>{{$announcement->title}}</h1>
    <div>
        <div>
            内容：{{$announcement->body}}
            <br>
            时间：{{$announcement->created_at}}
        </div>
    </div>
    @can('is_admin', $announcement)
        <div class="operate">
            <hr>
            <a href="{{ route('announcements.edit', $announcement->id) }}" role="button">
                <i></i> 编辑
            </a>

            <form action="{{ route('announcements.destroy', $announcement->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" style="margin-left: 6px">
                    <i></i>
                    删除
                </button>
            </form>
        </div>
    @endcan
@stop


