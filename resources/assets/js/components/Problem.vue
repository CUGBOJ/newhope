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
                .get('/api/problem', {
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
                    key: 'Title',
                    render: (h, params) => {
                        return h('div', [
                            h(
                                'Button',
                                {
                                    props: {
                                        type: 'text',
                                        size: 'small'
                                    },
                                    on: {
                                        click: () =>
                                            (window.location.href = `/problems/${
                                                params.row.id
                                            }`)
                                    }
                                },
                                params.row.Title
                            )
                        ])
                    }
                },
                {
                    title: 'Author',
                    key: 'Author'
                },
                {
                    title: 'Submit Number',
                    key: 'Submit_number'
                },
                {
                    title: 'Action',
                    key: 'action',
                    fixed: 'right',
                    width: 120,
                    render: (h, params) => {
                        return h('div', [
                            h(
                                'Button',
                                {
                                    props: {
                                        type: 'text',
                                        size: 'small'
                                    },
                                    on: {
                                        click: () =>
                                            (window.location.href = `/problems/${
                                                params.row.id
                                            }/edit`)
                                    }
                                },
                                'Edit'
                            )
                        ])
                    }
                }
            ],
            data: []
        }
    }
}
</script>