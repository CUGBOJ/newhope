@extends('layout.default')
@section('title', 'Discuss')

@section('content')
    <div class="col-md-offset-2 col-md-8">
        <h1>所有讨论</h1>
        <ul class="topics">
            @foreach ($topics as $topic)
                @include('topics._topic')
            @endforeach
        </ul>
        {!! $topics->render() !!}
    </div>
@stop