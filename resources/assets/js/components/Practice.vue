<template>
  <div>
        <Row>
            <Col span="12">
                <div style="height: 70vh; overflow: auto">
                    ID: <Input v-model="problemIdInput" style="width:80px" @keyup.enter.native="changeProblem"></Input>
                    <router-view></router-view>
                </div>
                <i-button type="primary" @click.native="submitCode">
                    提交
                </i-button>
            </Col>
            <Col span="12">
                <code-editor/>
            </Col>
        </Row>
  </div>
</template>

<script>
export default {
    data() {
        return {
            problemIdInput: this.$route.params.problemId
        }
    },
    methods: {
        submitCode() {
            window.bus.$emit('submit')
        },
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push('/')
        },
        changeProblem() {
            this.$router.push({
                name: 'problem',
                params: { problemId: this.problemIdInput }
            })
        }
    },
    computed: {
        problemId() {
            return this.$route.params.problemId
        }
    }
}
</script>
