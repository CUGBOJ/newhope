<template>
<div>
    <Table ref="standing" :loading="loading" :columns="columns" :data="data"></Table>
</div>
</template>
<script>
import axios from 'axios'
export default {
    props: {
        contestId: String,
        problemNum: {
            type: Number,
            default: 10
        }
    },
    data () {
        return {
            loading: false,
            data: [],
            columns: []
        }
    },
    mounted() {
        this.initColumns()
        this.fetchData()
    },
    methods: {
        fetchData() {
            this.loading = true
            axios.get('/api/standing/' + this.contestId)
                .then(res => {
                    this.data = res.data
                    for (let row of this.data) {
                        let cellClassName = {}
                        for (let i = 0; i < this.problemNum; i++) {
                            if (row.solPro.includes(i + 1)) {
                                cellClassName[String.fromCharCode(i + 'A'.charCodeAt(0))] = 'AC'
                            }
                        }
                        this.$set(row, 'cellClassName', cellClassName)
                    }
                    this.loading = false
                })
                .catch(err => {
                    this.$Notice.error({
                        title: '获取排名失败',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        } ,
        initColumns() {
            this.columns = [
                {
                    title: 'rank',
                    key: 'rank'
                },
                {
                    title: 'username',
                    key: 'username'
                },
                {
                    title: 'acSubmitNum',
                    key: 'acSubmitNum'
                },
                {
                    title: 'grade',
                    key: 'grade'
                }
            ]

            for (let i = 0; i < this.problemNum; i++) {
                this.columns.push({
                    title: String.fromCharCode(i + 'A'.charCodeAt(0)),
                    key: String.fromCharCode(i + 'A'.charCodeAt(0)) 
                    // render: (h, params) => {
                    //     return h('div', {}, params.row.solPro.includes(i + 1).toString())
                    // }
                })
            }
        }
    }
}
</script>
<style lang="stylus">
.ivu-table .AC
    background-color #2e7f79 
    color white
</style>
