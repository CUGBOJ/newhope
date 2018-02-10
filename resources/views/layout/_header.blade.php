<header class="navbar navbar-fixed-top navbar-inverse">
    <nav>
        <ul class="nav navbar-nav navbar-right">
            <li><a href= "{{ route('home') }}" >主页</a></li>
            <li><a href= "{{ route('problems.index') }}" >问题</a></li>
            <li><a href="{{ route('help') }}">帮助</a></li>
            <li><a href="{{ route('about') }}">关于</a></li>
            <li><a href="{{ route('users.index') }}">用户列表</a></li>
            @if (Auth::check())
                <li>
                    <a href="#">{{ Auth::user()->username }}</a>
                    <ul>
                        <li>
                            <a href="{{ route('users.show', Auth::user()->username) }}">个人中心</a>
                        </li>
                        <li>
                            <a href="{{ route('users.edit', Auth::user()->username) }}">编辑资料</a>
                        </li>
                        <li>
                            <a id="logout" href="#">
                                <form action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                                </form>
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                <li><a href="{{ route('signup') }}">注册</a></li>
                <li><a href="{{ route('login') }}">登陆</a></li>
            @endif
        </ul>
    </nav>
</header>


