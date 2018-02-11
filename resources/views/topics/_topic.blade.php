<li>
    <a href="{{ route('topics.show', $topic->id )}}" >{{ $topic->title }}
        ||
        {{ $topic->username }}
        ||
        {{ $topic->reply_count }}
        ||
        {{ $topic->last_reply_username }}
        ||
        {{ $topic->updated_at }}
    </a>
</li>