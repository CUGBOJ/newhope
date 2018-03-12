<a href="{{ route('users.show', $data['username']) }}">{{ $data['username'] }}</a>
在
<a href="{{ route('topics.show',$data['topic_id'] )}}">{{$data['topic_title'] }}</a>
评论了
<div class="reply-content">
    {!! $data['reply_content'] !!}
</div>
<span title="{{ $notification->created_at }}"></span>
<form action="{{route('notifications.read_one',$notification->id)}}" method="post">
    {{ csrf_field() }}
    <button type="submit">阅读该条</button>
    </form>
