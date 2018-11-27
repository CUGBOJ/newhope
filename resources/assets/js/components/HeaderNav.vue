<template>
  <Header :style="{position: 'fixed', width: '100%', top: '0'}">
    <Menu mode="horizontal" theme="dark" active-name="1">
      <div class="layout-logo" @click="$router.push({name: 'home'})">CUGBOJ</div>
      <div class="layout-nav">
        <ButtonGroup>
          <Button>
            <router-link :to="{name: 'problems'}">
              题目
            </router-link>
          </Button>
          <Button>
            <router-link :to="{name: 'users'}">
              用户
            </router-link>
          </Button>
          <Button>
            <router-link :to="{name: 'statuses'}">
              提交记录
            </router-link>
          </Button>
          <Button @click="$router.push({name: 'contests'})">
            比赛
          </Button>
          <!-- <Button @click="$router.push({name: 'discusses'})">
            讨论区
          </Button> -->
          <Button @click="$router.push({name: 'announcements'})">
            公告
          </Button>
          <!-- <Button @click="$router.push('/help')">
            帮助
          </Button> -->
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
          <Badge :count="user.notification_count" style="margin: 0 15px; cursor: pointer">
            <Avatar shape="square" :src="user.avatar" size="large" />
          </Badge>
          <DropdownMenu slot="list">
            <DropdownItem>
              <router-link :to="{name: 'notice'}">
                消息中心
              </router-link>
            </DropdownItem>
            <DropdownItem>
              <router-link :to="{name: 'user-show', params: { username: user.username }}">
                个人中心
              </router-link>
            </DropdownItem>
            <DropdownItem>
              <router-link :to="{name: 'edit-profile', params: { username: user.username }}">
                编辑资料
              </router-link>
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
import {mapGetters, mapActions, mapState} from 'vuex'

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
<style lang="stylus" scoped>
a
  color unset
>>> .ivu-badge-count
  top 1px
</style>
