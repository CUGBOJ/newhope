@extends('layout.default')
@section('title', 'Problems')

@section('content')
    <problem-table></problem-table>
    <i-button type="primary" @click="this.window.location.href = '{{route('problems.create')}}'">
    添加题目
    </i-button>
@stop