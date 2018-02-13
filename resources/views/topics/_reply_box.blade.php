@include('share._error')
<div class="reply-box">
    <form action="{{ route('replies.store') }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
        <textarea  placeholder="分享你的想法" name="content" id="content"></textarea>
        <button type="submit"><i></i>回复</button>
    </form>
</div>
<hr>