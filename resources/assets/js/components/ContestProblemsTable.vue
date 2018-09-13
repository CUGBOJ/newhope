<template>
  <div>
    <Table :loading="loading" stripe :columns="columns" :data="data" :height="tableHeight" style="margin: 10px 0;"></Table>
    <div style="float: right;">
      <Page :page-size="perPage" :total="total" :current="1" @on-change="changePage"></Page>
    </div>
  </div>
</template>
<script>
import axios from 'axios'

export default {
    props: ['contestid'],
    mounted() {
        this.changePage()
    },
    computed: {
        tableHeight() {
            return window.innerHeight * 0.65
        }
    },
    methods: {
        changePage(p = 1) {
            this.loading = true
            axios
                .get('/api/problemsByContest/' + this.contestid, {
                    params: {
                        page: p,
                        perPage: this.perPage
                    }
                })
                .then(res => {
                    this.data = res.data.data
                    this.total = res.data.total
                    this.loading = false
                })
        }
    },
    data() {
        return {
            perPage: 10,
            loading: true,
            total: 0,
            columns: [
                {
                    title: 'Title',
                    key: 'title',
                    render: (h, params) => {
                        return h('div', [
                            h(
                                'router-link',
                                {
                                    props: {
                                        to: {
                                            name: 'contest-practice',
                                            params: {
                                                id: this.contestid,
                                                char: params.row.pivot.keychar
                                            }
                                        }
                                    }
                                },
                                params.row.title
                            )
                        ])
                    }
                },
                {
                    title: 'Author',
                    key: 'author'
                },
                {
                    title: 'Submited Users',
                    key: 'total_submit_user',
                    width: 100
                },
                {
                    title: 'Accepted Users',
                    key: 'total_ac_user',
                    width: 100
                }
            ],
            data: []
        }
    }
}
</script>
<style lang="stylus" scoped>
>>> a
    color unset
</style>
