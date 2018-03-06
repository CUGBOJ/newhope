<li>
    <a href="{{ route('contests.show', $contest->id )}}" >

        {{$contest->id}}_{{ $contest->title }}_{{$contest->start_time}}_{{$contest->endtime}}_{{$contest->isprivate}}


    </a>
</li>