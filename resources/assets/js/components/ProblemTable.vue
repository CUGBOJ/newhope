<template>
  <div>
    <Table :loading="loading" stripe :columns="columns" :data="data" :height="tableHeight"></Table>
    <Row v-if="this.$store.state.user && this.$store.state.user.can.manage_contents">
      <Button type="primary" :to="{name: 'problem-create'}">New Problem</Button>
    </Row>
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
        this.addActionColumn()
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
                .get('/problem', {
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
        },
        addActionColumn() {
            if (this.$store.state.user && this.$store.state.user.can.manage_contents) {
                this.columns.push(
                    {
                        title: 'Action',
                        key: 'action',
                        fixed: 'right',
                        width: 100,
                        render: (h, params) => {
                            return h('div', [
                                h(
                                    'router-link',
                                    {
                                        props: {
                                            to: {
                                                name: 'problem-edit',
                                                params: {
                                                    id: params.row.id
                                                }
                                            }
                                        }
                                    },
                                    'Edit'
                                )
                            ])
                        }
                    })
            }
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
                                            name: 'problem',
                                            params: {
                                                problemId: params.row.id
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
>>> .ivu-table-cell a 
    color unset
</style>
