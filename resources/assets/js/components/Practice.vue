<template>
    <div>
        <Row>
            <Col span="12">
            <div style="height: 70vh; overflow: auto">
                ID: {{problemId}}
                <AutoComplete 
                    icon="ios-search" 
                    :data="problemSearchData" 
                    v-model.lazy="problemSearchText" 
                    style="width:80px"
                >
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
        changeProblem() {
            this.$router.push({
                name: 'problem',
                params: { problemId: this.problemSearchText }
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
