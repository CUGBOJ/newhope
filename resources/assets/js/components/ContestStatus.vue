<template>
  <div>
    <Input v-model="searchText" @keyup.enter.native="fetchData" placeholder="Search for ID, Problem or User" style="width: 300px;" icon="ios-search"></Input>
    <Table ref="table" :loading="loading" stripe :columns="columns" :data="data" :height="tableHeight" style="margin: 10px 0;"></Table>
    <div style="float: right;">
      <Page ref="page" :page-size="perPage" :total="total" :current="1" @on-change="fetchData"></Page>
    </div>
    <Modal v-model="codeModal.show" v-if="this.codeModal.data" :title="'Code for ' + this.codeModal.data.id" width="750" ok-text="Copy" @on-ok="copyCode">
      <pre v-html="codeModal.codeHTML"></pre>
      <button v-if="codeModal.data" id="copy-code" :data-clipboard-text="codeModal.data.code" hidden></button>
    </Modal>
    <Modal v-model="ceModal.show" v-if="this.ceModal.data" :title="'Compile Error Info for ' + this.ceModal.data.id">
      {{this.ceModal.data.ce_info || "Empty Info" }}
    </Modal>
  </div>
</template>
<script>
const CONSTANT = {
    RESULT: [
        'Accepted',
        'Wrong Answer',
        'Presentation Error',
        'Time Limit Exceed',
        'Runtime Error',
        'Memory Limit Exceed',
        'Output limit Exceed',
        'Unknown error',
        'Compile Error',
        'Restricted Function',
        'Judge Error',
        'Queuing and Judging'
    ],
    LANG: [
        'C',
        'C++',
        'JAVA',
        'C#',
        'Python 2',
        'Python 3',
        'Javascript',
        'Ruby',
        'Pascal'
    ],
    PRISM_LANG: [
        'c',
        'cpp',
        'java',
        'csharp',
        'python',
        'python',
        'javascript',
        'ruby',
        'pascal'
    ]
}

import axios from 'axios'
import Prism from 'prismjs'
const Clipboard = require('clipboard')

export default {
    props: ['contestid'],
    mounted() {
        this.fetchData()

        // Initialize Clipboard
        let Cb = new Clipboard('#copy-code')
        Cb.on('success', () => {
            this.$Message.success('Copied')
        })
        Cb.on('error', () => {
            this.$Message.error('Copy error')
        })
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
                .get('/api/statusByContest/'+this.contestid, {
                    params
                })
                .then(res => {
                    this.data = res.data.data
                    this.total = res.data.total
                    this.loading = false
                })
        },
        showCodeModal(data) {
            this.codeModal.data = data
            this.codeModal.show = true
            let prismLang = CONSTANT.PRISM_LANG[this.codeModal.data.lang - 1]
            this.codeModal.codeHTML = Prism.highlight(
                this.codeModal.data.code,
                Prism.languages[prismLang],
                prismLang
            )
        },
        copyCode() {
            document.getElementById('copy-code').click()
        }
    },
    data() {
        return {
            codeModal: {
                show: false,
                codeHTML: '',
                data: null
            },
            ceModal: {
                show: false,
                data: null
            },
            searchText: '',
            perPage: 10,
            loading: true,
            total: 0,
            columns: [
                {
                    title: 'ID',
                    key: 'id'
                },
                {
                    title: 'Username',
                    key: 'username'
                },
                {
                    title: 'Problem',
                    key: 'pid',
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
                    key: 'lang',
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
                    render: (h, params) => {
                        let res = CONSTANT.RESULT[params.row.result - 1]
                        let className =
                            'judge-result-' +
                            res
                                .toLowerCase()
                                .split(' ')
                                .join('-')
                        return h(
                            'div',
                            {
                                class: className + ' judge-result'
                            },
                            [
                                res === 'Compile Error'
                                    ? h(
                                        'a',
                                        {
                                            on: {
                                                click: () => {
                                                    this.ceModal.data =
                                                          params.row
                                                    this.ceModal.show = true
                                                }
                                            }
                                        },
                                        res
                                    )
                                    : res
                            ]
                        )
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
                    key: 'time'
                },
                {
                    title: 'Memory',
                    key: 'memory'
                },
                {
                    title: 'Length',
                    key: 'length',
                    render: (h, params) => {
                        return h(
                            'a',
                            {
                                on: {
                                    click: () => {
                                        this.showCodeModal(params.row)
                                    }
                                }
                            },
                            params.row.length
                        )
                    }
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
<style lang="stylus" scoped>
pre
    font-size 16px
    white-space pre-wrap
    word-wrap break-word

>>> .judge-result
    font-weight bold

// Use deep selectors for dynamic rendered child components
>>> .judge-result-
    &accepted
        color green

    &presentation-error, &compile-error, &output-limit-exceed
        color blue

    &memory-limit-exceed, &time-limit-exceed, &wrong-answer, &runtime-error
        color red

    &restricted-function, &unknown-error, &judge-error
        color darkblue
</style>