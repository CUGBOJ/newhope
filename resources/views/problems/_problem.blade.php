<li>
    <a href="{{ route('problems.show', $problem->id )}}" >{{ $problem->Title }}
    ||
        {{ $problem->AC_number }}
    ||
        {{ $problem->Submit_number }}
    ||
        {{ $problem->AC_user_number }}
    ||
        {{ $problem->Submit_user_number }}

    </a>

    {{--@can('destroy', $user)--}}
        {{--<form action="{{ route('users.destroy', $user->id) }}" method="post">--}}
            {{--{{ csrf_field() }}--}}
            {{--{{ method_field('DELETE') }}--}}
            {{--<button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>--}}
        {{--</form>--}}
    {{--@endcan--}}
</li>