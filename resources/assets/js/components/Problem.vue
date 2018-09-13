<template>
    <div v-if="loading">
        <Spin size="large" fix></Spin>
    </div>
    <div v-else>
        <h1>{{ this.problem.data.title }}</h1>
        <div>
            <h3>Description</h3>
            {{ this.problem.data.description }}
        </div>
        <div>
            <h3>Input</h3>
            {{ this.problem.data.input }}
        </div>
        <div>
            <h3>Output</h3>
            {{ this.problem.data.output }}
        </div>
        <div>
            <h3>sample_input</h3>
            {{ this.problem.data.sample_input }}
        </div>
        <div>
            <h3>sample_output</h3>
            {{ this.problem.data.sample_output }}
        </div>
        <div>
            <h3>hint</h3>
            {{ this.problem.data.hint }}
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
