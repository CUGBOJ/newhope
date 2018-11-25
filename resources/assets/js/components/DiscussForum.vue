<template>
    <Spin size="large" fix v-if="loading"></Spin>
    <div v-else>
        <div v-for="reply in replies" :key="reply.id" class="reply-block">
            <Row>
                <Col span="2">
                    <Avatar v-if="reply.user" shape="square" :src="reply.user.avatar" size="large" />
                </Col>
                <Col span="22">
                    <Card dis-hover>
                        <div> 
                            <UserPoptip :user="reply.user"/>
                            for problem 
                            <router-link :to="{name: 'problem', params: {problemId}}"> {{ '#' + problemId }} </router-link>
                            <div style="float: right">
                            {{'#' + reply.id}}
                            </div>
                            <Time :time="reply.updated_at"></Time>
                        </div>
                        <div>{{reply.content}}</div>
                    </Card>
                </Col>
            </Row>
        </div>
  </div>
</template>
<script>
import UserPoptip from './UserPoptip.vue'
import axios from 'axios'

export default {
    components: {
        UserPoptip: UserPoptip
    },
    data() {
        return {
            loading: true,
            problemId: null,
            contestId: null,
            replies: []
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            this.loading = true

            axios
                .get('/topic/' + this.topicId)
                .then(res => {
                    let data = res.data
                    this.replies = data['replies']
                    this.problemId = data['problem_id']
                    this.contestId = data['contest_id']

                    // TODO: refactor backend to avoid fetch all userdata for each users
                    this.replies.forEach(r => {
                        axios.get('/user/' + r['username']).then(res => Vue.set(r, 'user', res.data))
                    })

                    this.loading = false
                })
                .catch(err => {
                    this.$Message.error(err.response.data.message)
                })
        }
    },
    computed: {
        topicId() {
            return this.$route.params.id
        }
    }
}
</script>
<style lang="stylus" scoped>

</style>
