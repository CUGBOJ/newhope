@extends('layout.default')
@section('title', 'Discuss')

@section('content')
    <discuss :problem="{{$problem_id ?? 0}}"></discuss>
@stop