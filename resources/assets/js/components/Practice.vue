<template>
    <div>
        <Row>
            <Col span="12">
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
            </Col>
            <Col span="12">
            <CodeEditor/>
            </Col>
        </Row>
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
            axios.get('/api/problem',  {search: this.problemSearchText})
                .then(res => {
                    this.problemSearchData = res.data.data
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
