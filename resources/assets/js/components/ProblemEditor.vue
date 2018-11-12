<template>
    <div>
        <h1>
            题目编辑器
            <Tag color="primary">
                {{`#${problemId}`}}
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
                    <h2>Author</h2>
                    <Input v-model="data.author"/>
                    <h2>Description</h2>
                    <Input v-model="data.description" type="textarea"/>
                    <h2>Input</h2>
                    <Input v-model="data.input" type="textarea"/>
                    <h2>Output</h2>
                    <Input v-model="data.output" type="textarea"/>
                    <h2>Sample Input</h2>
                    <Input v-model="data.sample_input" type="textarea"/>
                    <h2>Sample Output</h2>
                    <Input v-model="data.sample_output" type="textarea"/>
                    <h2>Hint</h2>
                    <Input v-model="data.hint" type="textarea"/>
                </Col>
                <Col span="12">
                    <h2>Meta Info</h2>
                    <Row>
                    <Checkbox size="large" v-model="data.hide" :true-value="1" :false-value="0"> 
                        Show this problem
                    </Checkbox>
                    </Row>
                    <Row>
                    <Checkbox size="large" v-model="data.special_judge" :true-value="1" :false-value="0"> 
                        Special Judge
                    </Checkbox>
                    </Row>
                    <h2>
                        Time Limit
                    </h2>
                    <InputNumber 
                        :max="20000" 
                        :min="100" 
                        :step="100" 
                        v-model="data.time_limit"
                        :formatter="value => `${value}ms`"
                        :parser="value => value.substr(0, value.length - 2)"
                    >
                    </InputNumber>
                    <h2>
                        Case time Limit
                    </h2>
                    <InputNumber 
                        :max="20000" 
                        :min="100" 
                        :step="100" 
                        v-model="data.case_time_limit"
                        :formatter="value => `${value}ms`"
                        :parser="value => value.substr(0, value.length - 2)"
                    >
                    </InputNumber>
                    <h2>
                        Memory Limit
                    </h2>
                    <InputNumber 
                        :max="120000" 
                        :min="1000" 
                        :step="1000" 
                        v-model="data.memory_limit"
                        :formatter="value => `${value}kB`"
                        :parser="value => value.substr(0, value.length - 2)"
                    >
                    </InputNumber>
                    <Row>
                    <h2>
                        Judger
                    </h2>
                    <Input v-model="data.v_name" type="text"/>
                    </Row>
                    <Row>
                    <h2>
                        Source
                    </h2>
                    <Input v-model="data.source" type="text"/>
                    </Row>
                </Col>
            </Row>
            <Button type="primary" @click="submitData" :loading="submitLoading">Submit</Button>
            <Button type="error" @click="deleteProblem" :loading="submitLoading">Delete</Button>
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
                author: null,
                description: null,
                input: null,
                output: null,
                sample_input: null,
                sample_output: null,
                hint: null,
                hide: 0,
                special_judge: 0,
                time_limit: null,
                case_time_limit: null,
                memory_limit: null,
                v_name: 'CUGB',
                source: 'CUGB' 
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
            axios.get('/problem/' + this.problemId)
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
                'author',
                'description',
                'input',
                'output',
                'sample_input',
                'sample_output',
                'hint',
                'hide',
                'special_judge',
                'time_limit',
                'case_time_limit',
                'memory_limit',
                'v_name',
                'source'
            ]

            for (let key of props) {
                data.append(key, this.data[key])
            }

            if (this.isCreator) {
                this.createPorblem(data)
            } else {
                this.modifyProblem(data)
            }
        },
        createPorblem(data) {
            axios.post('/problem', data)
                .then(res => {
                    this.submitLoading = false
                    this.$Notice.success({
                        title: '添加题目成功',
                        desc: res.data.message
                    })
                    this.$router.push({
                        name: 'problem-edit',
                        params: {
                            id: res.data.id
                        }
                    })
                })
                .catch(err => {
                    this.submitLoading = false
                    this.$Notice.error({
                        title: '添加题目失败',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        },
        modifyProblem(data) {
            axios.post('/problem/' + this.problemId, data)
                .then(res => {
                    this.submitLoading = false
                    this.$Notice.success({
                        title: '更新题目成功',
                        desc: res.data.message
                    })
                    this.fetchData()
                })
                .catch(err => {
                    this.submitLoading = false
                    this.$Notice.error({
                        title: '更新题目失败',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        },
        deleteProblem() {
            let data = new FormData()

            data.append('_method', 'DELETE')

            axios.post('/problem/' + this.problemId, data)
                .then(res => {
                    this.submitLoading = false
                    this.$Notice.success({
                        title: '删除题目成功',
                        desc: res.data.message
                    })
                    this.$router.push({
                        name: 'problems'
                    })
                })
                .catch(err => {
                    this.submitLoading = false
                    this.$Notice.error({
                        title: '删除题目失败',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        }
    },
    computed: {
        problemId() {
            return this.$route.params.id
        }
    }
}
</script>
