<div>
    <div>
        <div>
            <a href="{{ route('users.show', $notification->data['username']) }}">{{ $notification->data['username'] }}</a>
            在
            <a href="{{ route('topics.show',$notification->data['topic_id'] )}}">{{ $notification->data['topic_title'] }}</a>
            评论了
            {{-- 回复删除按钮 --}}
        </div>
        <div class="reply-content">
            {!! $notification->data['reply_content'] !!}
        </div>
        <span title="{{ $notification->created_at }}">
                <span aria-hidden="true"></span>
            {{ $notification->created_at->diffForHumans() }}
        </span>
    </div>
</div>
