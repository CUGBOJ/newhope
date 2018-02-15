<template>
  <Table stripe :columns="columns" :data="data" height="480"></Table>
</template>
<script>
import axios from 'axios'

export default {
    data() {
        return {
            columns: [
                {
                    title: 'Title',
                    key: 'Title'
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
                                            (window.location.href = `http://127.0.0.1:8000/problems/${
                                                params.row.id
                                            }`)
                                    }
                                },
                                'View'
                            ),
                            h(
                                'Button',
                                {
                                    props: {
                                        type: 'text',
                                        size: 'small'
                                    },
                                    on: {
                                        click: () =>
                                            (window.location.href = `http://127.0.0.1:8000/problems/${
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
    },
    mounted() {
        axios.get('/api/problem').then(res => {
            console.log(res.data)
            this.data = res.data
        })
    }
}
</script>