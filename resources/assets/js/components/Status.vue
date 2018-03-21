<template>
  <div>
    <Input v-model="searchText" @keyup.enter.native="fetchData" placeholder="Search for ID, Problem or User" style="width: 300px;" icon="ios-search"></Input>
    <Table ref="table" :loading="loading" stripe :columns="columns" :data="data" :height="tableHeight" style="margin: 10px 0;"></Table>
    <div style="float: right;">
      <Page ref="page" :page-size="perPage" :total="total" :current="1" @on-change="fetchData"></Page>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
const CONSTANT = {
    RESULT: [
        'Accepted',
        'WA',
        'PE',
        'TLE',
        'RE',
        'MLE',
        'Output limit',
        'Unknown error',
        'CE',
        'Queuing and Judging',
        'hh'
    ],
    LANG: ['C', 'C++', 'JAVA', 'Python 2', 'Python 3', 'C#', 'Ruby', 'Pascal']
}
export default {
    mounted() {
        this.fetchData()
    },
    computed: {
        //Hack filter when page changed
        cloneColumns() {
            return this.$refs.table.cloneColumns
        },
        page() {
            return this.$refs.page.currentPage
        },
        tableHeight() {
            return window.innerHeight * 0.63
        }
    },
    methods: {
        fetchData() {
            this.loading = true
            let params = {
                page: this.page,
                perPage: this.perPage
            }

            if (this.searchText) {
                params.search = this.searchText
            }

            if (this.cloneColumns[3]._filterChecked.length) {
                params.lang = JSON.stringify(
                    this.cloneColumns[3]._filterChecked.map(v => v + 1)
                )
            }

            if (this.cloneColumns[4]._filterChecked.length) {
                params.res = JSON.stringify(
                    this.cloneColumns[4]._filterChecked.map(v => v + 1)
                )
            }

            axios
                .get('/api/status', {
                    params
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
            searchText: '',
            perPage: 10,
            loading: true,
            total: 0,
            columns: [
                {
                    title: 'ID',
                    key: 'id',
                    width: '8%'
                },
                {
                    title: 'Username',
                    key: 'username',
                    width: '18%'
                },
                {
                    title: 'Problem',
                    key: 'pid',
                    width: '8%',
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
                                                params.row.pid
                                            }`)
                                    }
                                },
                                params.row.pid
                            )
                        ])
                    }
                },
                {
                    title: 'Language',
                    key: 'l' +
                'ang',
                    width: '10%',
                    render: (h, params) => {
                        return h('div', CONSTANT.LANG[params.row.lang - 1])
                    },
                    filters: CONSTANT.LANG.map((val, index) => ({
                        label: val,
                        value: index
                    })),
                    filterRemote() {
                        this.fetchData()
                    }
                },
                {
                    title: 'Result',
                    key: 'result',
                    width: '13%',
                    render: (h, params) => {
                        return h('div', CONSTANT.RESULT[params.row.result - 1])
                    },
                    filters: CONSTANT.RESULT.map((val, index) => ({
                        label: val,
                        value: index
                    })),
                    filterRemote() {
                        this.fetchData()
                    }
                },
                {
                    title: 'Time',
                    key: 'time',
                    width: '8%'
                },
                {
                    title: 'Memory',
                    key: 'memory',
                    width: '8%'
                },
                {
                    title: 'Length',
                    key: 'length',
                    width: '8%'
                },
                {
                    title: 'Submit Time',
                    key: 'submit_time'
                }
            ],
            data: []
        }
    }
}
</script>