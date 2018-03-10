@extends('layout.default')

@section('title')
    我的通知
@stop

@section('content')
    <div class="container">
        <h3>
            我的通知
        </h3>
        <hr>
        @if ($notifications->count())
            <div class="notification-list">
                @foreach ($notifications as $notification)
                    <?php
                    $arr = $notification->data;
                    $data = json_decode($arr, true);
                    ?>
                    @include('notifications.types._' . snake_case(class_basename($notification->type)))
                @endforeach
            </div>
        @else
            <div class="empty-block">没有消息通知！</div>
        @endif
    </div>
@stop