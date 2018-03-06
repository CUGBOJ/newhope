@extends('layout.default')
@section('title', 'Contests')

@section('content')

    <i-button type="primary" @click="this.window.location.href = '{{route('contests.create')}}'">
        添加比赛
    </i-button>

    <div>
        <ul>
            @foreach ($contests as $contest)
                @include('contests._contest')
            @endforeach
        </ul>

    </div>

@stop