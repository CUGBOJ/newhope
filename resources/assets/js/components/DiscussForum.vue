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
                            <Poptip v-if="reply.user" trigger="hover" width="300" :transfer="true">
                                <a> {{reply.user.username}} </a>
                                <div slot="content">
                                    <Row>
                                        <Col span="6">
                                        <Avatar v-if="reply.user" shape="square" :src="reply.user.avatar" size="large" /> 
                                        </Col>
                                        <Col span="18">
                                            <Row>
                                                {{reply.user.username}} {{reply.user.nickname}}
                                            </Row>
                                            <Row>
                                            <div>{{reply.user.solved}} solved.</div>
                                            </Row>
                                        </Col>
                                    </Row>
                                </div>
                            </Poptip>
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
import axios from 'axios'
export default {
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
