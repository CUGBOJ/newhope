<div>
    <div>
        <div>
            管理员发布了公告！
            <a href="{{ route('announcements.show',$data['announcement_id'] )}}">{{ $data['announcement_title'] }}</a>


        </div>
        <span title="{{ $notification->created_at }}">
                <span aria-hidden="true"></span>
            {{ $notification->created_at }}
        </span>
    </div>
</div>
