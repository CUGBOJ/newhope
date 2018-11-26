<template>
  <div>
    <ul class="users">
      <Row>
        <span>已经加入成员</span>
        <li v-for="(value, key) in users" :key="key">
          <Col span="11" :offset="key % 2 === 1 ? 1 : 0">
          <Card dis-hover>
            <div class="d-flex">
              <Avatar class="mx" shape="square" size="large" :src="value.avatar"></Avatar>
              <div class="mx">
                <h3>
                  <router-link :to="{name: 'user-show', params: {username: value.username}}">
                    {{ value.nickname }}
                  </router-link>
                </h3>
              </div>
            </div>
            <span class="rk">#{{key + 1}}</span>
          </Card>
          </Col>
        </li>
      </Row>
    </ul>
    <ul class="apply">
        <Row>
        <span>申请列表</span>
        <li v-for="(value, key) in applyUser" :key="key">
          <Col span="11" :offset="key % 2 === 1 ? 1 : 0">
          <Card dis-hover>
            <div class="d-flex">
              <Avatar class="mx" shape="square" size="large" :src="value.avatar"></Avatar>
              <div class="mx">
                <h3>
                  <router-link :to="'user/' + value.username">
                    {{ value.nickname }}
                  </router-link>
                  <Button @click="agree(value.id)">同意</Button>
                  <Button @click="refuse(value.id)">拒绝</Button>
                </h3>
              </div>
            </div>
            <span class="rk">#{{key + 1}}</span>
          </Card>
          </Col>
        </li>
      </Row>
    </ul>
  </div>
</template>
<script>
import axios from 'axios'

export default {
    props: {
        isCreator: Boolean
    },
    data() {
        return {
            loading: false,
            users: {},
            applyUser: {}
        }
    },
    mounted() {
        if (this.isCreator) {
            // TODO
        } else {
            this.fetchData()
        }
    },
    methods: {
        fetchData() {
            this.loading = true
            axios.get('/team/' + this.teamId)
                .then(res => {
                    this.data = res.data
                    this.loading = false
                    this.users = res.data.base.users
                })
            
            axios.get('applyList/' + this.teamId)
                .then(res => {
                    this.applyUser = res.data
                })
        },
        agree(userId) {
            let postdata = {
                res: true,
                user: userId
            }
            axios.post('dealApply/' + this.teamId,postdata)
            // .then(res => {
            //     console.log(res.data)
            // })
                
        },
        refuse(userId) {
            let postdata = {
                res: false,
                user: userId
            }
            axios.get('dealApply/' + this.teamId,postdata)
        }
    },
    computed: {
        teamId() {
            return this.$route.params.id
        }
    }
}
</script>
<style lang="stylus" scoped>
.users
    list-style none

span
    display block

.d-flex
    display flex

.mx
    margin 0 8px

>>> .ivu-card
    margin-bottom 27px

>>> .ivu-card-body
    justify-content space-between
    display flex
</style>
