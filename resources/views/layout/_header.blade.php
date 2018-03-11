<i-header :style="{position: 'fixed', width: '100%', top: '0'}">
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
            @guest
                <button-group>


                    <i-button @click="this.window.location.href = '{{ route('signup') }}'">
                        注册
                    </i-button>
                    <i-button @click="this.window.location.href = '{{ route('login') }}'">
                        登录
                    </i-button>
                </button-group>
            @endguest

            @auth
                <dropdown trigger="click">
                    <a href="javascript:void(0)">
                        <badge count="{{ Auth::user()->notification_count  }}" style="margin: 0 15px">
                            <Avatar shape="square" src="{{Auth::user()->avatar}}" size="large"/>
                        </badge>
                    </a>
                    <dropdown-menu slot="list">
                        <dropdown-item @click.native="this.window.location.href = '{{ route('notifications.index') }}'">
                            消息中心
                        </dropdown-item>
                        <dropdown-item
                                @click.native="this.window.location.href = '{{ route('users.show', Auth::user()->username) }}'">
                            个人中心
                        </dropdown-item>
                        <dropdown-item
                                @click.native="this.window.location.href = '{{ route('users.edit', Auth::user()->username) }}'">
                            编辑资料
                        </dropdown-item>
                        <dropdown-item @click.native="this.document.getElementById('logout').submit()">
                            <form action="{{ route('logout') }}" method="POST" id="logout" hidden>
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <i-button class="btn btn-block btn-danger" html-type="submit" name="button"></i-button>
                            </form>
                            退出
                        </dropdown-item>
                    </dropdown-menu>
                </dropdown>
            @endauth
        </div>
    </i-menu>
</i-header>

