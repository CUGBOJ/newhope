<template>
  <Header :style="{position: 'fixed', width: '100%', top: '0'}">
    <Menu mode="horizontal" theme="dark" active-name="1">
      <div class="layout-logo" @click="$router.push({name: 'home'})"></div>
      <div class="layout-nav">
        <ButtonGroup>
          <Button @click="$router.push({name: 'problems'})">
            题目
          </Button>
          <Button @click="$router.push({name: 'users'})">
            用户
          </Button>
          <Button @click="$router.push({name: 'statuses'})">
            提交记录
          </Button>
          <Button @click="$router.push({name: 'discusses'})">
            讨论区
          </Button>
          <Button @click="$router.push({name: 'announcements'})">
            公告
          </Button>
          <Button @click="$router.push('help')">
            帮助
          </Button>
          <Button @click="$router.push('about')">
            关于
          </Button>
        </ButtonGroup>
        <ButtonGroup v-if="!loggedIn">
          <Button @click="$router.push({name: 'signin'})">
            注册
          </Button>
          <Button @click="$router.push({name: 'login'})">
            登录
          </Button>
        </ButtonGroup>
        <Dropdown trigger="click" v-else>
          <badge :count="user.notification_count" style="margin: 0 15px; cursor: pointer">
            <Avatar shape="square" :src="user.avatar" size="large" />
          </badge>
          <DropdownMenu slot="list">
            <DropdownItem @click.native="$router.push({name: 'notifications'})">
              消息中心
            </DropdownItem>
            <DropdownItem @click.native="$router.push({name: 'user', params: { username: user.username }})">
              个人中心
            </DropdownItem>
            <DropdownItem @click.native="$router.push({name: 'userEdit', params: { username: user.username }})">
              编辑资料
            </DropdownItem>
            <DropdownItem @click.native="logOut">
              退出
            </DropdownItem>
          </DropdownMenu>
        </Dropdown>
      </div>
    </Menu>
  </Header>
</template>
<script>
import { mapGetters, mapActions, mapState } from 'vuex'

export default {
    computed: {
        ...mapGetters(['user']),
        ...mapState(['loggedIn'])
    },
    methods: {
        ...mapActions(['logOut', 'getProfile'])
    },
    created() {
        this.getProfile()
    }
}
</script>
