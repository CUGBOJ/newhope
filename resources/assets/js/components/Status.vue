<template>
  <div>
    <Table :loading="loading" stripe :columns="columns" :data="data" height="480"></Table>
    <div style="float: right;">
      <Page :page-size="perPage" :total="total" :current="1" @on-change="changePage"></Page>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
const CONSTANT = {
    RESULT: [
        '',
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
    LANG: [
        '',
        'C',
        'C++',
        'JAVA',
        'Python 2',
        'Python 3',
        'C#',
        'Ruby',
        'Pascal'
    ]
}
export default {
    mounted() {
        this.changePage()
    },
    methods: {
        changePage(p = 1) {
            this.loading = true
            axios
                .get('/api/status', {
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
                    title: 'ID',
                    key: 'id',
                    width: '8%'
                },
                {
                    title: 'Username',
                    key: 'Username',
                    width: '18%'
                },
                {
                    title: 'Problem',
                    key: 'Problem_id',
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
                                                params.row.Problem_id
                                            }`)
                                    }
                                },
                                params.row.Problem_id
                            )
                        ])
                    }
                },
                {
                    title: 'Language',
                    key: 'Lang',
                    width: '10%',
                    render: (h, params) => {
                        return h('div', CONSTANT.LANG[params.row.Lang])
                    }
                },
                {
                    title: 'Result',
                    key: 'Result',
                    width: '13%',
                    render: (h, params) => {
                        return h('div', CONSTANT.RESULT[params.row.Result])
                    }
                },
                {
                    title: 'Time',
                    key: 'Time',
                    width: '8%'
                },
                {
                    title: 'Memory',
                    key: 'Memory',
                    width: '8%'
                },
                {
                    title: 'Length',
                    key: 'Length',
                    width: '8%'
                },
                {
                    title: 'Submit Time',
                    key: 'Submit_time'
                }
            ],
            data: []
        }
    }
}
</script>