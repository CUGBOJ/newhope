@extends('layout.default')
@section('title', 'Problems')

@section('content')
    <div class="col-md-offset-2 col-md-8">
        <h1>所有用户</h1>
        <ul class="problems">
            @foreach ($problems as $problem)
                @include('problems._problem')
            @endforeach
        </ul>
        {!! $problems->render() !!}
    </div>
@stop