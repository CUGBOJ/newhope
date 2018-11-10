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
                    <Checkbox size="large" v-model="data.is_private" :true-value="1" :false-value="0"> 
                        is_private
                    </Checkbox>
                    </Row>
                    <h2>
                        Time Setting
                    </h2>
                    <h3>
                        Time Range
                    </h3>
                    <DatePicker type="datetimerange" v-model="timeRange" style="width: 300px"></DatePicker>
                    <h3>
                        Lock Board Time
                    </h3>
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
            timeRange: [],
            data: {
                title: null,
                id: 0,
                description: null,
                end_time: new Date(),
                hide_other: 0,
                is_private: 0,
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
                    this.timeRange = [new Date(res.data.start_time), new Date(res.data.end_time)]
                    this.loading = false
                })
        },
        submitData() {
            this.submitLoading = true
            let data = new FormData()

            const props = [
                'title',
                'description',
                'lock_board_time',
                'hide_other',
                'is_private'
            ]

            for (let key of props) {
                data.append(key, this.data[key])
            }

            data.append('start_time', this.timeRange[0].toISOString())
            data.append('end_time', this.timeRange[1].toISOString())

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
