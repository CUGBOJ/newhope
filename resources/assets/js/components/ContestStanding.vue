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
                    // console.log(res.data)
                    for (let row of this.data) {
                        let cellClassName = {}
                        for (let i = 0; i < this.problemNum; i++) {
                            if (row.solPro.hasOwnProperty(i + 1)) {
                                cellClassName[String.fromCharCode(i + 'A'.charCodeAt(0))] = 'AC '
                            } else if (row.allPro.hasOwnProperty(i + 1)) {
                                cellClassName[String.fromCharCode(i + 'A'.charCodeAt(0))] = 'WA '
                            }
                        }
                        // console.log(cellClassName)
                        this.$set(row, 'cellClassName', cellClassName)
                        // this.$set(row,)
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
                    title: 'penalty',
                    key: 'penalty'
                }
            ]

            for (let i = 0; i < this.problemNum; i++) {
                let problemLabel = String.fromCharCode(i + 'A'.charCodeAt(0))
                this.columns.push({
                    title: problemLabel,
                    key: problemLabel,
                    render: (h, params) => {
                        if (params.row.solPro.hasOwnProperty(i + 1)) {
                            if (params.row.allPro[i + 1] != 0) {
                                return h('div', {},  params.row.solPro[i + 1] + '(-' + params.row.allPro[i + 1] + ')')
                            } else {
                                return h('div', {},  params.row.solPro[i + 1])

                            }
                        } else 
                            return h('div', {}, params.row.allPro.hasOwnProperty(i + 1) ?  '(-' + params.row.allPro[i + 1] + ')' : '')
                    }
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
.ivu-table .WA
    background-color #FF4500
    color white
</style>
