@extends('layout.default')
@section('title', 'Discuss')

@section('content')
    <discuss :problem="{{$pid ?? 0}}"></discuss>
@stop