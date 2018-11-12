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
                    <h2>Problems</h2>
                    <Row>
                        <InputNumber v-model="addProblemId"></InputNumber>
                        <Button @click="addProblem(addProblemId)">Add Problem</Button>
                    </Row>
                    <draggable v-model="data.problems" @end="onDragEnd">
                        <transition-group name="flip-list">
                            <Row v-for="(problem, index) in data.problems" 
                                :key="problem.id">
                                <ColorPicker v-model="problem.pivot.color" size="small" recommend/>
                                <Tag 
                                    :key="problem.id"
                                    type="border"
                                    @click.native="problemModal.open=true; problemModal.id=index;" 
                                    @on-close="data.problems.splice(index, 1)"
                                    closable>
                                    {{String.fromCharCode(problem.pivot.keychar + 64)}} - {{problem.title}}
                                </Tag>
                            </Row>
                        </transition-group>
                    </draggable>
                    <Modal v-model="problemModal.open" width="900">
                        <Problem :value="data.problems[problemModal.id]"/>
                        <div slot="footer"/>
                    </Modal>
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
                    <h3> Password </h3>
                    <Row type="flex" align="middle">
                        <Col span="4">
                            <i-switch v-model="updatePassword">
                                <Icon type="md-checkmark" slot="open"></Icon>
                                <Icon type="md-close" slot="close"></Icon>
                            </i-switch>
                        </Col>
                        <Col span="10">
                            <Input v-model="password" :disabled="!updatePassword" type="password" placeholder="Enter a new password" />
                        </Col>
                    </Row>
                    <h3> Time Range </h3>
                    <DatePicker type="datetimerange" v-model="timeRange" style="width: 300px"></DatePicker>
                    <h3> Lock Board Time </h3>
                    <DatePicker type="datetime" v-model="data.lock_board_time" style="width: 300px"></DatePicker>
                </Col>
            </Row>
            <Button type="primary" @click="submitData" :loading="submitLoading">Submit</Button>
            <Button type="error" @click="deleteContest" :loading="submitLoading">Delete</Button>
        </div>
  </div>
</template>
<script>
import axios from 'axios'
import draggable from 'vuedraggable'
import Problem from './Problem'

export default {
    components: {
        draggable,
        Problem
    },
    props: {
        isCreator: Boolean
    },
    data() {
        return {
            problemModal: {
                open: false,
                id: 0
            },
            addProblemId: null,
            loading: false,
            submitLoading: false,
            timeRange: [],
            password: '',
            updatePassword: false,
            data: {
                title: null,
                id: 0,
                description: null,
                end_time: new Date(),
                hide_other: 0,
                is_private: 0,
                lock_board_time: new Date(),
                start_time: new Date(),
                problems: []
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
            axios.get('/contest/' + this.contestId)
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
                'hide_other',
                'is_private'
            ]

            for (let key of props) {
                data.append(key, this.data[key])
            }

            data.append('start_time', this.timeRange[0].toISOString())
            data.append('end_time', this.timeRange[1].toISOString())
            data.append('lock_board_time', this.data.lock_board_time.toISOString())

            data.append('problems', JSON.stringify(this.problems))

            if (this.updatePassword) {
                data.append('password', this.password)
            }

            if (this.isCreator) {
                this.createPorblem(data)
            } else {
                this.modifyContest(data)
            }
        },
        createPorblem(data) {
            axios.post('/contest', data)
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
            axios.post('/contest/' + this.contestId, data)
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

            axios.post('/contest/' + this.contestId, data)
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
        },
        addProblem(id) {
            if (this.problems.includes(id)) {
                this.$Notice.error({
                    title: '题目与已有题目重复'
                })
                return
            }
            axios
                .get(`/problem/${id}`)
                .then(res => {
                    res.data.pivot = {
                        keychar: this.data.problems.length + 1,
                        color: 'white'
                    }
                    this.data.problems.push(res.data)
                })
                .catch(() => {
                    this.$Notice.error({
                        title: '无法获取题目'
                    })
                })
        },
        onDragEnd() {
            for (let i = 0; i < this.data.problems.length; i++) {
                this.data.problems[i].pivot.keychar = i + 1
            }
        }
    },
    computed: {
        contestId() {
            return this.$route.params.id
        },
        problems() {
            return this.data.problems.map(o => ({
                id: o.id,
                color: o.pivot.color
            }))
        }
    }
}
</script>
<style lang="stylus" scoped>
.flip-list-move {
  transition: transform 1s;
}
</style>
