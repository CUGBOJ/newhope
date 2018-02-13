<div>
    <div>
        <div>

        <a href="{{ route('users.show', $data['username']) }}">{{ $data['username'] }}</a>
        在
        <a href="{{ route('topics.show',$data['topic_id'] )}}">{{$data['topic_title'] }}</a>
        评论了
        <div class="reply-content">
            {!! $data['reply_content'] !!}
        </div>
        <span title="{{ $notification->created_at }}">
    </div>
</div>

