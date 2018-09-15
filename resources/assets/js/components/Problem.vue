<template>
    <div v-if="loading">
        <Spin size="large" fix></Spin>
    </div>
    <div v-else>
        <div class="problem">
            <Row type="flex" justify="center" align="middle">
                <Col>
                    <h1>{{ this.problem.data.title }}</h1>
                </Col>
                <Col span="1">
                    <Tag color="primary" size="large">
                        #{{this.problem.data.id}}
                    </Tag>
                </Col>
            </Row>
            <Row type="flex" justify="center" align="middle" :gutter="16">
                <Col>
                    <Icon type="md-done-all" />
                    {{this.acRatio}}
                </Col>
                <Col>
                    <Icon type="ios-time" />
                    {{this.problem.data.time_limit}} ms
                </Col>
                <Col>
                    <Icon type="md-apps" />
                    {{this.problem.data.memory_limit}} KB
                </Col>
            </Row>
            <Divider orientation="left">
                <h3>Description</h3>
            </Divider>
            <p>
                {{ this.problem.data.description }}
            </p>
            <Divider orientation="left">
                <h3>Input</h3>
            </Divider>
            <p>
                {{ this.problem.data.input }}
            </p>
            <Divider orientation="left">
                <h3>Output</h3>
            </Divider>
            <p>
                {{ this.problem.data.output }}
            </p>
            <Divider orientation="left">
                <h3>Sample Input</h3>
            </Divider>
            <Row type="flex" justify="end">
                <Button type="dashed" shape="circle" icon="ios-copy" class="copy" id="copy-sample-input" :data-clipboard-text="this.problem.data.sample_input"></Button>
            </Row>
            <pre>{{ this.problem.data.sample_input }}</pre>
            <Divider orientation="left">
                <h3>Sample Output</h3>
            </Divider>
            <Row type="flex" justify="end">
                <Button type="dashed" shape="circle" icon="ios-copy" class="copy" id="copy-sample-output" :data-clipboard-text="this.problem.data.sample_output"></Button>
            </Row>
            <pre>{{ this.problem.data.sample_output }}</pre>
            <Divider orientation="left">
                <h3>Hint</h3>
            </Divider>
            <p>
                {{ this.problem.data.hint }}
            </p>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
const Clipboard = require('clipboard')

export default {
    data() {
        return {
            loading: true,
            problem: {
                data: {}
            }
        }
    },
    created() {
        // Initialize Clipboard
        let Cb = new Clipboard('#copy-sample-output')
        Cb.on('success', () => {
            this.$Message.success('Copied')
        })
        Cb.on('error', () => {
            this.$Message.error('Copy error')
        })

        Cb = new Clipboard('#copy-sample-input')
        Cb.on('success', () => {
            this.$Message.success('Copied')
        })
        Cb.on('error', () => {
            this.$Message.error('Copy error')
        })
    },
    beforeRouteEnter(to, from, next) {
        axios
            .get(`/api/problem/${to.params.problemId}`)
            .then(res => {
                next(vm => {
                    vm.problem.data = res.data
                    vm.loading = false
                })
            })
            .catch(() => {
                next(false)
            })
    },
    beforeRouteUpdate(to, from, next) {
        this.loading = true
        axios
            .get(`/api/problem/${to.params.problemId}`)
            .then(res => {
                this.problem.data = res.data
                this.loading = false
                next()
            })
            .catch(() => {
                next(false)
                this.$Loading.error()
                this.$Notice.error({
                    title: '无法获取题目'
                })
                this.loading = false
            })
    },
    computed: {
        problemId() {
            return this.$route.params.problemId
        },
        acRatio() {
            if (this.problem.data.total_ac === 0) {
                return '0%'
            } else {
                return (this.problem.data.total_ac / this.problem.data.total_submit * 100).toFixed(2).toString() + '%'
            }
        }
    }
}
</script>
<style lang="stylus" scoped>
h3
    color #9c9da7

p
    font-size 1.3rem

pre
    font-size 1.2rem
    word-break break-all
    word-wrap break-word
    display block
    white-space pre-wrap
    margin 0

.copy
    margin-top -25px
    z-index 999

.problem
    background white 
    padding 5px 20px
    height 100%
    min-height 70vh
</style>
