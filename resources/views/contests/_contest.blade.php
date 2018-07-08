<li>
    <a href="{{ route('contests.add_user_by_password', $contest->id )}}" >

        {{$contest->id}}_{{ $contest->title }}_{{$contest->start_time}}_{{$contest->endtime}}_{{$contest->isprivate}}


    </a>
</li>