<li>
    <a href="{{ route('problems.show', $problem->id )}}" >{{ $problem->title }}
    ||
        {{ $problem->aC_number }}
    ||
        {{ $problem->submit_number }}
    ||
        {{ $problem->aC_user_number }}
    ||
        {{ $problem->submit_user_number }}

    </a>

    {{--@can('destroy', $user)--}}
        {{--<form action="{{ route('users.destroy', $user->id) }}" method="post">--}}
            {{--{{ csrf_field() }}--}}
            {{--{{ method_field('DELETE') }}--}}
            {{--<button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>--}}
        {{--</form>--}}
    {{--@endcan--}}
</li>