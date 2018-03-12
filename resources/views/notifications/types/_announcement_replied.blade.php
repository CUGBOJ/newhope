<div>
    管理员发布了公告！
    <a href="{{ route('announcements.show',$data['announcement_id'] )}}">{{ $data['announcement_title'] }}</a>
</div>
<span title="{{ $notification->created_at }}">
    {{ $notification->created_at }}
</span>
<form action="{{route('notifications.read_one',$notification->id)}}" method="post">
{{ csrf_field() }}
<button type="submit">阅读该条</button>
</form>