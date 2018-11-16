<template>
  <div>
    <ul class="users">
      <Row>
        <li v-for="(value, key) in users.data" :key="key">
          <Col span="11" :offset="key % 2 === 1 ? 1 : 0">
          <Card dis-hover>
            <div class="d-flex">
              <Avatar class="mx" size="large">{{value.username.substr(0, 1).toUpperCase()}}</Avatar>
              <div class="mx">
                <h3>
                  <router-link :to="'user/' + value.username">
                    {{ value.nickname }}
                  </router-link>
                </h3>
                <span>
                  {{value.submit}} submits {{value.solved}} solves
                </span>
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
    data() {
        return {
            users: {
                data: []
            }
        }
    },
    created() {
        axios.get('users').then(res => {
            this.users = res.data
        })
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
