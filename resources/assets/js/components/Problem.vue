<template>
    <div v-if="loading">
        <Spin size="large" fix></Spin>
    </div>
    <div v-else>
        <Row type="flex" align="middle" :gutter="16">
            <Col span="9">
                <h1>{{ this.problem.data.title }}</h1>
            </Col>
            <Col span="3">
                <Tag color="primary" size="large">
                    #{{this.problem.data.id}}
                </Tag>
            </Col>
        </Row>
        <div style="background: white; padding: 5px 20px;">
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
            <p>
                {{ this.problem.data.sample_input }}
            </p>
            <Divider orientation="left">
                <h3>Sample Output</h3>
            </Divider>
            <p>
                {{ this.problem.data.sample_output }}
            </p>
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

export default {
    data() {
        return {
            loading: true,
            problem: {
                data: {}
            }
        }
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
        }
    }
}
</script>
<style lang="stylus" scoped>
h3
    color #9c9da7

p
    font-size 16px
</style>
