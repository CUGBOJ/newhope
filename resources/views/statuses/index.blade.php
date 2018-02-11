<?php
$statuses=App\Models\Status::all();
?>
@extends('layout.default')
@section('title', 'Statuses')

@section('content')

    <div class="col-md-offset-2 col-md-8">
        <h1>过题记录</h1>
        <ul class="statuses">
            @foreach ($statuses as $status)
                @include('statuses._status')
            @endforeach
        </ul>

        {{--{!! $statuses->render() !!}--}}
    </div>
@stop