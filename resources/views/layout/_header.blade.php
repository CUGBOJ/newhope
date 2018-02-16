<i-header :style="{position: 'fixed', width: '100%'}">
    <i-menu mode="horizontal" theme="dark" active-name="1">
        <div class="layout-logo" @click="this.window.location.href = '{{ route('home') }}'"></div>
        <div class="layout-nav">
            <button-group>
                <i-button @click="this.window.location.href = '{{ route('problems.index') }}'">
                    题目
                </i-button>
                <i-button @click="this.window.location.href = '{{ route('users.index') }}'">
                    用户
                </i-button>
                <i-button @click="this.window.location.href = '{{ route('statuses') }}'">
                    提交记录
                </i-button>
                <i-button @click="this.window.location.href = '{{ route('topics.index') }}'">
                    讨论区
                </i-button>
                <i-button @click="this.window.location.href = '{{ route('announcements.index') }}'">
                    公告
                </i-button>
                <i-button @click="this.window.location.href = '{{ route('help') }}'">
                    帮助
                </i-button>
                <i-button @click="this.window.location.href = '{{ route('about') }}'">
                    关于
                </i-button>
            </button-group>
            <button-group>
                @auth
                    <i-button @click="this.window.location.href = '{{ route('users.show', Auth::user()->username) }}'">
                        个人中心
                    </i-button>

                    <i-button @click="this.window.location.href = '{{ route('users.edit', Auth::user()->username) }}'">
                        编辑资料
                    </i-button>
                    <form action="{{ route('logout') }}" method="POST" id="logout" hidden>
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <i-button class="btn btn-block btn-danger" html-type="submit" name="button">退出</i-button>
                    </form>
                    <i-button @click="this.document.getElementById('logout').submit()">
                        退出
                    </i-button>

                @else
                    <i-button @click="this.window.location.href = '{{ route('signup') }}'">
                        注册
                    </i-button>
                    <i-button @click="this.window.location.href = '{{ route('login') }}'">
                        登录
                    </i-button>
                @endif
            </button-group>
            @auth
                <badge count="{{ Auth::user()->notification_count + 1 }}">
                    <a href="{{ route('notifications.index') }}"
                       style="width: 30px; height: 30px; background: #eee; border-radius: 6px; display: inline-block;">
                        {{ Auth::user()->username }}
                    </a>
                </badge>
            @endauth
        </div>
    </i-menu>
</i-header>

