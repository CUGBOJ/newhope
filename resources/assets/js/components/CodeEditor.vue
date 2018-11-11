<template>
  <div>
    <Row :gutter="16" style="height:32px">
      <Col span="8">
      <Dropdown @on-click="onLmClick" trigger="click">
        <Button type="text">
          {{CONSTANT.LANG[cmOptions.mode].name}}
          <Icon type="arrow-down-b"></Icon>
        </Button>
        <DropdownMenu slot="list">
          <DropdownItem v-for="(val, key) in CONSTANT.LANG" :key="key" :name="key" :disabled="key===cmOptions.mode">
            {{val.name}}
          </DropdownItem>
        </DropdownMenu>
      </Dropdown>
      </Col>
      <Col span="8">
      <Dropdown @on-click="onTmClick" trigger="click">
        <Button type="text">
          {{CONSTANT.THEME[cmOptions.theme]}}
          <Icon type="arrow-down-b"></Icon>
        </Button>
        <DropdownMenu slot="list">
          <DropdownItem v-for="(val, key) in CONSTANT.THEME" :key="key" :name="key" :disabled="key===cmOptions.theme">
            {{val}}
          </DropdownItem>
        </DropdownMenu>
      </Dropdown>
      </Col>
      <Col span="8">
      <Dropdown @on-click="onKmClick" trigger="click">
        <Button type="text">
          {{CONSTANT.KEYMAP[cmOptions.keyMap]}}
          <Icon type="arrow-down-b"></Icon>
        </Button>
        <DropdownMenu slot="list">
          <DropdownItem v-for="(val, key) in CONSTANT.KEYMAP" :key="key" :name="key" :disabled="key===cmOptions.keyMap">
            {{val}}
          </DropdownItem>
        </DropdownMenu>
      </Dropdown>
      </Col>
    </Row>
    <codemirror ref="pCm" :value="code" :options="cmOptions" @ready="onCmReady" @focus="onCmFocus" @input="onCmCodeChange">
    </codemirror>
  </div>
</template>
 
<script>
import {codemirror} from 'vue-codemirror'

import 'codemirror/addon/display/autorefresh.js'

import 'codemirror/keymap/emacs.js'
import 'codemirror/keymap/sublime.js'
import 'codemirror/keymap/vim.js'

import 'codemirror/mode/javascript/javascript.js'
import 'codemirror/mode/clike/clike.js'
import 'codemirror/mode/python/python.js'
import 'codemirror/mode/pascal/pascal.js'
import 'codemirror/mode/ruby/ruby.js'

import 'codemirror/lib/codemirror.css'

import 'codemirror/theme/solarized.css'
import 'codemirror/theme/base16-dark.css'
import 'codemirror/theme/base16-light.css'
import 'codemirror/theme/monokai.css'
import 'codemirror/theme/neat.css'

const CONSTANT = {
    LANG: {
        'text/x-csrc': {
            name: 'C',
            code: `#include <stdio.h>
int main()
{
    return 0;
}`,
            index: 1
        },
        'text/x-c++src': {
            name: 'C++',
            code: `#include <iostream>
using namespace std;
int main(){
    return 0;
}`,
            index: 2
        },
        'text/x-java': {
            name: 'Java',
            index: 3
        },
        'text/x-csharp': {
            name: 'C#',
            index: 4
        },
        'text/x-python2': {
            name: 'Python2',
            index: 5
        },
        'text/x-python': {
            name: 'Python3',
            index: 6
        },
        'text/javascript': {
            name: 'JavaScript',
            code: 'let a = 1',
            index: 7
        },
        'text/x-ruby': {
            name: 'Ruby',
            index: 8
        },
        'text/x-pascal': {
            name: 'Pascal',
            index: 9
        }
    },
    THEME: {
        'solarized': 'Solarized',
        'base16-dark': 'Base16 Dark',
        'base16-light': 'Base16 Light',
        'monokai': 'Monokai',
        'neat': 'Neat'
    },
    KEYMAP: {
        vim: 'Vim',
        emacs: 'Emacs',
        sublime: 'Sublime',
        default: 'Default'
    }
}

import axios from 'axios'

export default {
    components: {
        codemirror
    },
    data() {
        return {
            code: '',
            cmOptions: {
                tabSize: 4,
                indentUnit: 4,
                mode: 'text/x-c++src',
                theme: 'solarized',
                keyMap: 'default',
                lineNumbers: true,
                line: true,
                autoRefresh: {
                    delay: 500
                }
            }
        }
    },
    methods: {
        onCmReady() {},
        onCmFocus() {},
        onCmCodeChange(newCode) {
            this.code = newCode
        },
        onTmClick(name) {
            this.cmOptions.theme = name
        },
        onKmClick(name) {
            this.cmOptions.keyMap = name
        },
        onLmClick(name) {
            this.cmOptions.mode = name
            let code = this.CONSTANT.LANG[name].code
            this.code = code ? code : ''
        }
    },
    computed: {
        codemirror() {
            return this.$refs.pCm.codemirror
        },
        getLang() {
            return this.CONSTANT.LANG[this.cmOptions.mode].index
        }
    },
    mounted() {
        // Load user's editor config from localStorage
        let option = window.localStorage.getItem('cmOptions')
        if (option) {
            this.cmOptions = JSON.parse(option)
        }

        // Load sample code
        this.onLmClick(this.cmOptions.mode)
    },
    watch: {
        cmOptions: { 
            handler (val) {
                window.localStorage.setItem('cmOptions', JSON.stringify(val))
            },
            deep: true
        }
    },
    created() {
        this.CONSTANT = CONSTANT
        let self = this
        window.bus.$on('submit', function() {
            self.$Message.success('已向服务器提交')
            axios
                .post('/api/codeSubmit', {
                    // cid: self.$route.params.problemId,
                    cid: self.$route.params.contestId,
                    pid: self.$route.params.problemId,
                    code: self.code,
                    lang: self.getLang
                })
                .then(res => {
                    self.$Notice.success({
                        title: '提交成功',
                        desc: res.data.message
                    })
                })
                .catch(err => {
                    self.$Notice.error({
                        title: '提交时出错',
                        desc: err.response.data.message,
                        duration: 0
                    })
                })
        })
    },
    beforeDestroy() {
        window.bus.$off('submit')
    }
}
</script>

<style lang="stylus">
.CodeMirror
    font-size 18px
    height 70vh
</style>
