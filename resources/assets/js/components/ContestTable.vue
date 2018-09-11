<template>
  <Spin size="large" fix v-if="loading"></Spin>
  <div v-else>
    <ul>
      <li v-for="contest in contests" :key="contest.id">
        <a :href="'/contest/' + contest.id">
          <div class="title">{{contest.title}}</div>
        </a>
        <div>
          {{`#${contest.id} updated at ${contest.updated_at}`}}
        </div>
      </li>
    </ul>
    <Row>
      <Button type="primary">New contest</Button>
    </Row>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            contest: null
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            let params = {}
            axios
                .get('/api/contests', {
                    params
                })
                .then(res => {
                    this.contests = res.data
                })
                .catch(err => {
                    this.$Message.error(err.response.data.message)
                })
        }
    }
}
</script>
<style lang="stylus" scoped>
li
    border-bottom 1px solid #e1e4e8
    list-style-type none

    & .title
        font-size 1.6em

a
    color #24292e

    &:hover
        color #0366d6
</style>
