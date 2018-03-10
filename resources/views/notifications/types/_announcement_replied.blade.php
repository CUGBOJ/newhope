<div>
    管理员发布了公告！
    <a href="{{ route('announcements.show',$data['announcement_id'] )}}">{{ $data['announcement_title'] }}</a>
</div>
<span title="{{ $notification->created_at }}">
    {{ $notification->created_at }}
</span>
