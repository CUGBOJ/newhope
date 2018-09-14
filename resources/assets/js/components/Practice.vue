<template>
    <div style="height: 100%;">
        <Split v-model="splitRatio">
            <div slot="left" v-show="splitRatio > 0.1" class="split-pane">
                <div style="max-height: 70vh; overflow: auto">
                    <AutoComplete 
                        v-if="!inContest"
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
            </div>
            <div slot="right" class="split-pane">
                <CodeEditor/>
            </div>
        </Split>
        <i-button type="primary" @click.native="editProblem" style="float: right">
            修改题目
        </i-button>
        <i-button type="primary" @click.native="submitCode" style="float: right">
            提交
        </i-button>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    components: {
        CodeEditor: () => import('./CodeEditor.vue')
    },
    props: {
        inContest: Boolean
    },
    data() {
        return {
            splitRatio: 0.5,
            problemSearchText: null,
            problemSearchData: [],
            lastSearchTime: 0
        }
    },
    mounted() {
        if (this.inContest) {
            this.fetchProblemId()
        }     
    },
    methods: {
        submitCode() {
            window.bus.$emit('submit')
        },
        editProblem() {
            this.$router.push({
                name: 'problem-edit',
                params: {
                    id: this.problemId
                }
            })
        },
        changeProblem(problemId = this.problemId) {
            this.$router.push({
                name: this.inContest ? 'contest-problem' : 'problem',
                params: {
                    problemId
                }
            })
        },
        searchProblem() {
            if (this.problemSearchText == null || Date.now() - this.lastSearchTime < 1500) {
                return
            }

            this.lastSearchTime = Date.now()

            axios.get('/api/problem',  {
                params: {
                    search: this.problemSearchText.toString().trim()
                }
            })
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
        },
        fetchProblemId() {
            axios
                .get('/api/getProblemId',{
                    params: {
                        cid: this.contestId,
                        keychar: this.keychar
                    }
                })
                .then(res => {
                    this.changeProblem(res.data)
                })
        }
    },
    computed: {
        problemId() {
            return this.$route.params.problemId
        },
        contestId() {
            return this.inContest ? this.$route.params.contestId : null
        },
        keychar() {
            return this.inContest ? this.$route.params.keychar : null
        }
    }
}
</script>

<style lang="stylus" scoped>
.split-pane
    padding 3px
    
>>> .ivu-split-trigger
    border none
    background none
</style>

