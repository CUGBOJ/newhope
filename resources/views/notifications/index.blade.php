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
        <form action="{{route('notifications.read_all')}}" method="post">
            {{ csrf_field() }}
            <button type="submit">阅读所有</button>
        </form>
        @if ($notifications->count())
            <div class="notification-list">
                @foreach ($notifications as $notification)
                    @if( $notification->read_at===null)
                    <?php
                    $arr = $notification->data;
                    $data = json_decode($arr, true);
                    ?>
                    @include('notifications.types._' . snake_case(class_basename($notification->type)))
                    @endif
                @endforeach
            </div>
        @else
            <div class="empty-block">没有消息通知！</div>
        @endif
    </div>
@stop