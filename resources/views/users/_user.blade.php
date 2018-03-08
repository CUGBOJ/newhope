<li>
    <a href="{{ route('users.show', $user->username )}}" class="username">{{ $user->username }}</a>

    @can('user_destroy', $user)
        <form action="{{ route('users.destroy', $user->username) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
        </form>
    @endcan
</li>