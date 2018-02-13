<div class="reply-list">
    @foreach ($replies as  $reply)
       <div>
           {{$reply->username}}
           {{$reply->content}}
           {{$reply->updated_at}}
       </div>
    @endforeach
</div>