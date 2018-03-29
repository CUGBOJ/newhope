<template>
  <Spin size="large" fix v-if="loading"></Spin>
  <div v-else-if="user">
      <Row type="flex" justify="center">
      <Col span="5">
        <img :src="user.avatar" width="200px" height="200px" class="rounded"></img>
        <h1>{{user.nickname}}</h1>
        <h2>{{user.username}}</h2>
        <p>
            <Icon type="ios-people"></Icon>
            {{'@' + user.school}}
        </p>
        <p>
            <Icon type="email"></Icon>
            <a :href="'mailto:' + user.email">{{user.email}}</a>
        </p>
      </Col>
      <Col span="12" offset="2" class="cards">
        <Card :bordered="false"> 
            <p slot="title">Contests</p>
        </Card>
        <Card :bordered="false"> 
            <p slot="title">Problems</p>
            <p>Total submit: {{user.submit}}</p>
            <p>Total solve: {{user.solved}}</p>
        </Card>
        <Card :bordered="false"> 
            <p slot="title">Discussions</p>
            <Collapse v-if="user.topics.length">
                <Panel v-for="topic in user.topics" :key="topic.id">
                    {{topic.title}}
                        <a :href="'/topics/' + topic.id" style="float: right; margin-right: 20px"> 
                            <Icon type="link"></Icon>
                        </a>
                    <p slot="content">{{topic.body}}</p>
                </Panel>
            </Collapse>
            <p v-else>
                Not any topics.
            </p>
        </Card>
        <Card :bordered="false"> 
            <p slot="title">Activities</p>
            <p>Last login time: {{user.last_login_time}}</p>
        </Card>
      </Col>
      </Row>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            loading: true,
            user: null
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            this.loading = true
            let username = this.$route.params.username || ''
            axios
                .get(`/api/user/${username}`)
                .then(res => {
                    this.user = res.data
                    this.loading = false
                })
                .catch(() => {
                    this.$router.push('/404')
                })
        }
    }
}
</script>
<style lang="stylus" scoped>
.cards>.ivu-card
    margin-bottom 10px
</style>
