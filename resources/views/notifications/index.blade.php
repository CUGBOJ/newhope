@extends('layout.default')

@section('title')
    我的通知
@stop

@section('content')
    <div class="container">
        <div>
            <div>

                <div>

                    <h3>
                        <span aria-hidden="true"></span> 我的通知
                    </h3>
                    <hr>

                    @if ($notifications->count())

                        <div class="notification-list">
                            @foreach ($notifications as $notification)
                                @include('notifications.types._' . snake_case(class_basename($notification->type)))
                            @endforeach

                            {!! $notifications->render() !!}
                        </div>

                    @else
                        <div class="empty-block">没有消息通知！</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop