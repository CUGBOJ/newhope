@extends('layout.default')
@section('title', 'Announcement')

@section('content')
<div class="col-md-offset-2 col-md-8">
    <h1>所有Announcement</h1>
    @can('is_admin', Auth::user())
    <a href="{{route('announcements.create')}}"><h3>创建Announcement：</h3></a>
    @endcan
    <ul class="announcements">
        @foreach ($announcements as $announcement)
            @include('announcements._announcement')
        @endforeach
    </ul>
</div>
@stop