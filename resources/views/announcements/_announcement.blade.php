<li>
    <a href="{{ route('announcements.show', $announcement->id )}}" >{{ $announcement->title }}
        {{$announcement->body}}
        ||
        {{$announcement->updated_at}}
    </a>
</li>