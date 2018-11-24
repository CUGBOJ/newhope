<template>
    <div style="height: 100%;">
        <Row type="flex" style="height: 78vh">
        <Split v-model="splitRatio">
            <div slot="left" v-show="splitRatio > 0.1" class="split-pane">
                <div :style="{'max-height': leftPaneHeight + 'px', overflow: 'auto'}">
                    <Row type="flex">
                        <Col span="6">
                            <AutoComplete 
                                v-if="!inContest"
                                icon="ios-search" 
                                @on-search="debouncedSearchProblem"
                                @on-select="changeProblem"
                                v-model.lazy="problemSearchText"
                                :transfer="true"
                            >
                                <Option v-for="item in problemSearchData" :value="item.id" :key="item.id">{{ item.title }}</Option>
                            </AutoComplete>
                        </Col>
                    </Row>
                    <router-view></router-view>
                </div>
            </div>
            <div slot="right" class="split-pane" v-show="splitRatio < 0.9">
                <CodeEditor/>
            </div>
        </Split>
        </Row>
        <Row type="flex" justify="end">
            <Col span="2" v-if="this.$store.state.user && this.$store.state.user.can.manage_contents">
                <i-button type="info" @click.native="editProblem">
                    编辑题目
                </i-button>
            </Col>
            <Col span="2">
                <i-button type="success" @click.native="submitCode">
                    提交
                </i-button>
            </Col>
        </Row>
    </div>
</template>

<script>
import axios from 'axios'

//TODO: Replace lodash with es module to enable tree-shaking
import _ from 'lodash'

export default {
    components: {
        CodeEditor: () => import('./CodeEditor.vue')
    },
    props: {
        inContest: Boolean
    },
    data() {
        return {
            lastCid: null,
            leftPaneHeight: 0,
            splitRatio: 0.5,
            problemSearchText: null,
            problemSearchData: [],
            lastSearchTime: 0
        }
    },
    created() {
        this.debouncedSearchProblem = _.debounce(this.searchProblem, 2000)
    },
    mounted() {
        if (this.inContest) {
            this.fetchProblemId()
            Echo.channel('contest.' + this.contestId)
                .listen('ContestMessageEvent', () => {
                })

            this.lastCid = this.contestId
        }

        this.getLeftPaneHeight()
        window.addEventListener('resize', this.getLeftPaneHeight)
    },
    methods: {
        getLeftPaneHeight() {
            let h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)

            // 32px is the height of the search button
            this.leftPaneHeight = 0.7 * h + 32
        },
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
        changeProblem(problemId = this.problemId, replace = false) {
            let dest = {
                name: this.inContest ? 'contest-problem' : 'problem',
                params: {
                    problemId
                }
            }
            
            if (replace) {
                this.$router.replace(dest)
            } else {
                this.$router.push(dest)
            }
        },
        searchProblem() {
            let search = this.problemSearchText.toString().trim()

            if (this.problemSearchText == null || search === '') {
                return
            }

            axios.get('/problem',  {
                params: {
                    search 
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
                .get('/getProblemId',{
                    params: {
                        cid: this.contestId,
                        keychar: this.keychar
                    }
                })
                .then(res => {
                    this.changeProblem(res.data, true)
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
    },
    beforeDestroy() {
        Echo.leave('contest.' + this.lastCid)
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

