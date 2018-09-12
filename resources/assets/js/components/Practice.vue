<template>
    <div>
        <Split v-model="splitRatio">
            <div slot="left" v-show="splitRatio > 0.1" class="split-pane">
                <div style="height: 70vh; overflow: auto">
                    ID: {{problemId}}
                    <AutoComplete 
                        icon="ios-search" 
                        @on-search="searchProblem"
                        @on-select="changeProblem"
                        v-model.lazy="problemSearchText" 
                        style="width: 180px; float: right"
                    >
                    <Option v-for="item in problemSearchData" :value="item.id" :key="item.id">{{ item.title }}</Option>
                    </AutoComplete>
                    <router-view></router-view>
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
            splitRatio: 0.5,
            problemSearchText: null,
            problemSearchData: []
        }
    },
    methods: {
        submitCode() {
            window.bus.$emit('submit')
        },
        changeProblem(problemId) {
            this.$router.push({
                name: 'problem',
                params: { problemId }
            })
        },
        searchProblem() {
            if (!this.problemSearchText || this.problemSearchText.lenght <= 0) {
                return
            }

            axios.get('/api/problem',  {params: {search: this.problemSearchText}})
                .then(res => {
                    this.problemSearchData = res.data
                })
                .catch(err => {
                    self.$Notice.error({
                        title: '搜索题目时出错',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        }
    },
    computed: {
        problemId() {
            return this.$route.params.problemId
        }
    },
    watch: {
        $route(to) {
            this.problemSearchText = to.params.problemId
        }
    }
}
</script>

<style lang="stylus">
.split-pane
    padding 10px
</style>

