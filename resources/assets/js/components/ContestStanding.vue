<template>
<div>
    <Table ref="standing" :loading="loading" :columns="columns" :data="data"></Table>
</div>
</template>
<script>
import axios from 'axios'
export default {
    props: {
        contestId: String
    },
    data () {
        return {
            loading: false,
            data: [],
            columns: [
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
                    title: 'solPro',
                    key: 'solPro'
                },
                {
                    title: 'grade',
                    key: 'grade'
                }
            ]
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            this.loading = true
            axios.get('/api/standing/' + this.contestId)
                .then(res => {
                    this.data = res.data
                    this.loading = false
                })
                .catch(err => {
                    this.$Notice.error({
                        title: '获取排名失败',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        } 
    }
}
</script>
