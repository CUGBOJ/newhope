<template>
    <div>
        <h1>

        </h1>
        <Split v-model="splitRatio">
            <div slot="left" v-show="splitRatio > 0.1" class="split-pane">
                <div style="height: 70vh; overflow: auto">
                    ID: {{keychar}}
                     <h1>{{ this.problem.title }}</h1>
        <div>
            <h3>Description</h3>
            {{ this.problem.description }}
        </div>
        <div>
            <h3>Input</h3>
            {{ this.problem.input }}
        </div>
        <div>
            <h3>Output</h3>
            {{ this.problem.output }}
        </div>
        <div>
            <h3>sample_input</h3>
            {{ this.problem.sample_input }}
        </div>
        <div>
            <h3>sample_output</h3>
            {{ this.problem.sample_output }}
        </div>
        <div>
            <h3>hint</h3>
            {{ this.problem.hint }}
        </div>
                </div>
                <i-button type="primary" @click.native="submitCode">
                    提交
                </i-button> 
            </div>
            <div slot="right" class="split-pane">
                <CodeEditor/>
            </div>
        </Split>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    components: {
        CodeEditor: () => import('./CodeEditor.vue')
    },
    data() {
        return {
            contest_id: this.$route.params.id,
            keychar: this.$route.params.char,
            problem_id: null,
            problem: {},
            splitRatio: 0.5
        }
    },
    created() {
        this.fetchData()
    },   
    methods: {
        submitCode() {
            window.bus.$emit('submit')
        },
        fetchData() {
            axios
                .get('/api/getProblemId',{params: {cid: this.contest_id,keychar: this.keychar}})
                .then(res=>{
                    this.problem_id = res.data
                    if (this.problem_id != null) {
                        axios
                            .get('/api/problem/' + this.problem_id)
                            .then(res => {
                                this.problem = res.data
                            })
                            .catch(() => {
                                this.$router.push('/404')
                            })
                    }  else {
                        this.$router.push('/404')
                    }
                })
        }
    }
}
</script>

<style lang="stylus">
.split-pane
    padding 10px
</style>

