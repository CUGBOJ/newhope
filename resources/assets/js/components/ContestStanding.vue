<template>
<div>
    <Table ref="standing" :loading="loading" :columns="columns" :data="data" height="570">
    </Table>
</div>
</template>
<script>
import axios from 'axios'
export default {
    props: {
        contestId: String,
        problems: Array
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
                        for (let i = 0; i < this.problems.length; i++) {
                            let problemId = this.problems[i].id
                            if (row.solPro.hasOwnProperty(problemId)) {
                                cellClassName[String.fromCharCode(i + 'A'.charCodeAt(0))] = 'AC '
                            } else if (row.allPro.hasOwnProperty(problemId)) {
                                cellClassName[String.fromCharCode(i + 'A'.charCodeAt(0))] = 'WA '
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
                    title: 'Rk',
                    key: 'rank',
                    fixed: 'left',
                    width: 50
                },
                {
                    title: 'Name',
                    key: 'username',
                    fixed: 'left',
                    width: 180
                },
                {
                    title: 'AC',
                    key: 'acSubmitNum',
                    width: 50
                },
                {
                    title: 'Penalty',
                    key: 'penalty',
                    width: 90
                }
            ]

            for (let i = 0; i < this.problems.length; i++) {
                let problemId = this.problems[i].id
                let problemLabel = String.fromCharCode(i + 'A'.charCodeAt(0))
                this.columns.push({
                    title: problemLabel,
                    key: problemLabel,
                    width: 84,
                    render: (h, params) => {
                        if (params.row.solPro.hasOwnProperty(problemId)) {
                            if (params.row.allPro[problemId] != 0) {
                                return h('div', {},  params.row.solPro[problemId] + '(-' + params.row.allPro[problemId] + ')')
                            } else {
                                return h('div', {},  params.row.solPro[problemId])

                            }
                        } else 
                            return h('div', {}, params.row.allPro.hasOwnProperty(problemId) ?  '(-' + params.row.allPro[problemId] + ')' : '')
                    }
                })
            }
        }
    }
}
</script>
<style lang="stylus">
.ivu-table .AC
    background-color #187 
    color white
.ivu-table .WA
    background-color #ff6600
    color white
.flip-list-move
  transition transform 1s
</style>
