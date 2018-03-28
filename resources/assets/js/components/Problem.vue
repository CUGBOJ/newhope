<template>
  <div v-if="loading">
      <Spin size="large"></Spin>
  </div>
  <div v-else>
        <div>
            <h3>Description</h3>
            {{ this.problem.allData.description }}
        </div>
        <div>
            <h3>Input</h3>
            {{ this.problem.allData.input }}
        </div>
        <div>
            <h3>Output</h3>
            {{ this.problem.allData.output }}
        </div>
        <div>
            <h3>sample_input</h3>
            {{ this.problem.allData.sample_input }}
        </div>
        <div>
            <h3>sample_output</h3>
            {{ this.problem.allData.sample_output }}
        </div>
        <div>
            <h3>hint</h3>
            {{ this.problem.allData.hint }}
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
                allData: {}
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        axios
            .get(`/api/problem/${to.params.problemId}`)
            .then(res => {
                next(vm => {
                    vm.problem.allData = res.data
                    vm.loading = false
                })
            })
            .catch(() => {})
    },
    beforeRouteUpdate(to, from, next) {
        this.problem.allData = null
        this.loading = true
        axios
            .get(`/api/problem/${to.params.problemId}`)
            .then(res => {
                this.problem.allData = res.data
                this.loading = false
                next()
            })
            .catch(() => {})
    },
    computed: {
        problemId() {
            return this.$route.params.problemId
        }
    }
}
</script>
