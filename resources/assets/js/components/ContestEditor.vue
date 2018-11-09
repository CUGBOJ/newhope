<template>
    <div>
        <h1>
            比赛编辑器
            <Tag color="primary">
                {{`#${contestId}`}}
            </Tag>
        </h1>
        <div v-if="loading">
            <Spin size="large" fix></Spin>
        </div>
        <div v-else>
            <Row :gutter="32">
                <Col span="12">
                    <h2>Title</h2>
                    <Input v-model="data.title"/>
                    <h2>Description</h2>
                    <Input v-model="data.description" type="textarea"/>
                </Col>
                <Col span="12">
                    <h2>Meta Info</h2>
                    <Row>
                    <Checkbox size="large" v-model="data.hide_other" :true-value="1" :false-value="0"> 
                        hide_other
                    </Checkbox>
                    </Row>
                    <Row>
                    <Checkbox size="large" v-model="data.isprivate" :true-value="1" :false-value="0"> 
                        isprivate
                    </Checkbox>
                    </Row>
                    <h2>
                        Time Limit
                    </h2>

                </Col>
            </Row>
            <Button type="primary" @click="submitData" :loading="submitLoading">Submit</Button>
            <Button type="error" @click="deleteContest" :loading="submitLoading">Delete</Button>
        </div>
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
            submitLoading: false,
            data: {
                title: null,
                id: 0,
                description: null,
                end_time: new Date(),
                hide_other: 0,
                isprivate: 0,
                lock_board_time: new Date(),
                start_time: new Date()
            }
        }
    }, 
    mounted() {
        if (!this.isCreator) {
            this.fetchData()
        }
    },
    methods: {
        fetchData() {
            this.loading = true
            axios.get('/api/contest/' + this.contestId)
                .then(res => {
                    this.data = res.data
                    this.loading = false
                })
        },
        submitData() {
            this.submitLoading = true
            let data = new FormData()

            const props = [
                'title',
                'description',
                'start_time',
                'end_time',
                'lock_board_time',
                'hide_other',
                'isprivate'
            ]

            for (let key of props) {
                data.append(key, this.data[key])
            }

            if (this.isCreator) {
                this.createPorblem(data)
            } else {
                this.modifyContest(data)
            }
        },
        createPorblem(data) {
            axios.post('/api/contest', data)
                .then(res => {
                    this.submitLoading = false
                    this.$Notice.success({
                        title: '添加比赛成功',
                        desc: res.data.message
                    })
                    this.$router.push({
                        name: 'contest-edit',
                        params: {
                            id: res.data.id
                        }
                    })
                })
                .catch(err => {
                    this.submitLoading = false
                    this.$Notice.error({
                        title: '添加比赛失败',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        },
        modifyContest(data) {
            axios.post('/api/contest/' + this.contestId, data)
                .then(res => {
                    this.submitLoading = false
                    this.$Notice.success({
                        title: '更新比赛成功',
                        desc: res.data.message
                    })
                    this.fetchData()
                })
                .catch(err => {
                    this.submitLoading = false
                    this.$Notice.error({
                        title: '更新比赛失败',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        },
        deleteContest() {
            let data = new FormData()

            data.append('_method', 'DELETE')

            axios.post('/api/contest/' + this.contestId, data)
                .then(res => {
                    this.submitLoading = false
                    this.$Notice.success({
                        title: '删除比赛成功',
                        desc: res.data.message
                    })
                    this.$router.push({
                        name: 'contests'
                    })
                })
                .catch(err => {
                    this.submitLoading = false
                    this.$Notice.error({
                        title: '删除比赛失败',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        }
    },
    computed: {
        contestId() {
            return this.$route.params.id
        }
    }
}
</script>
