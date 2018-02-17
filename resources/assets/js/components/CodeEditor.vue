<template>
  <div>
    <Row :gutter="16">
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
import { codemirror } from 'vue-codemirror'

import 'codemirror/addon/display/autorefresh.js'

import 'codemirror/keymap/emacs.js'
import 'codemirror/keymap/sublime.js'
import 'codemirror/keymap/vim.js'

import 'codemirror/mode/javascript/javascript.js'
import 'codemirror/mode/clike/clike.js'
import 'codemirror/mode/python/python.js'

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
}`
        },
        'text/x-c++src': {
            name: 'C++',
            code: `#include <iostream>
using namespace std;
int main(){
    return 0;
}`
        },
        'text/x-java': { name: 'Java' },
        'text/x-csharp': { name: 'C#' },
        'text/x-python': { name: 'Python' },
        'text/javascript': {
            name: 'JavaScript',
            code: 'let a = 1'
        }
    },
    THEME: {
        solarized: 'Solarized',
        'base16-dark': 'Base16 Dark',
        'base16-light': 'Base16 Light',
        monokai: 'Monokai',
        neat: 'Neat'
    },
    KEYMAP: {
        vim: 'Vim',
        emacs: 'Emacs',
        sublime: 'Sublime',
        default: 'Default'
    }
}

export default {
    components: {
        codemirror
    },
    data() {
        return {
            code: 'const a = 10',
            cmOptions: {
                tabSize: 4,
                indentUnit: 4,
                mode: 'text/javascript',
                theme: 'base16-dark',
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
        }
    },
    mounted() {},
    created() {
        this.CONSTANT = CONSTANT
    }
}
</script>

<style lang="stylus">
.CodeMirror
    font-size 18px
    height 70vh
</style>
