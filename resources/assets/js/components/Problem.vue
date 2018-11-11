<template>
    <div v-if="loading || !this.problemData">
        <Spin size="large" fix></Spin>
    </div>
    <div v-else>
        <div class="problem">
            <Row type="flex" justify="center" align="middle">
                <Col>
                    <h1>{{ this.problemData.title }}</h1>
                </Col>
                <Col span="1">
                    <Tag color="primary" size="large">
                        #{{this.problemData.id}}
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
                    {{this.problemData.time_limit}} ms
                </Col>
                <Col>
                    <Icon type="md-apps" />
                    {{this.problemData.memory_limit}} KB
                </Col>
            </Row>
            <Divider orientation="left">
                <h3>Description</h3>
            </Divider>
            <p>
                {{ this.problemData.description }}
            </p>
            <Divider orientation="left">
                <h3>Input</h3>
            </Divider>
            <p>
                {{ this.problemData.input }}
            </p>
            <Divider orientation="left">
                <h3>Output</h3>
            </Divider>
            <p>
                {{ this.problemData.output }}
            </p>
            <Divider orientation="left">
                <h3>Sample Input</h3>
            </Divider>
            <Row type="flex" justify="end">
                <Button type="dashed" shape="circle" icon="ios-copy" class="copy" id="copy-sample-input" :data-clipboard-text="this.problemData.sample_input"></Button>
            </Row>
            <pre>{{ this.problemData.sample_input }}</pre>
            <Divider orientation="left">
                <h3>Sample Output</h3>
            </Divider>
            <Row type="flex" justify="end">
                <Button type="dashed" shape="circle" icon="ios-copy" class="copy" id="copy-sample-output" :data-clipboard-text="this.problemData.sample_output"></Button>
            </Row>
            <pre>{{ this.problemData.sample_output }}</pre>
            <Divider orientation="left">
                <h3>Hint</h3>
            </Divider>
            <p>
                {{ this.problemData.hint }}
            </p>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
const Clipboard = require('clipboard')

export default {
    props: ['value'],
    data() {
        return {
            loading: false,
            problemData: this.value
        }
    },
    created() {
        // Initialize Clipboard
        this.outputCb = new Clipboard('#copy-sample-output')
        this.outputCb.on('success', () => {
            this.$Message.success('Copied')
        })
        this.outputCb.on('error', () => {
            this.$Message.error('Copy error')
        })

        this.inputCb = new Clipboard('#copy-sample-input')
        this.inputCb.on('success', () => {
            this.$Message.success('Copied')
        })
        this.inputCb.on('error', () => {
            this.$Message.error('Copy error')
        })
    },
    beforeDestroy() {
        this.inputCb.destroy()
        this.outputCb.destroy()
    },
    beforeRouteEnter(to, from, next) {
        axios
            .get(`/api/problem/${to.params.problemId}`)
            .then(res => {
                next(vm => {
                    vm.problemData = res.data
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
                this.problemData = res.data
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
            if (this.problemData.total_ac === 0) {
                return '0%'
            } else {
                return (this.problemData.total_ac / this.problemData.total_submit * 100).toFixed(2).toString() + '%'
            }
        }
    },
    watch: {
        value: function(val) {
            // Due to some external change may not be detected by JS
            this.problemData = val
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
