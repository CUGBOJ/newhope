<template>
  <Spin size="large" fix v-if="loading"></Spin>
  <div v-else>
      <Row>
          <Button type="primary" @click="this.window.location.href = '/topics/create'">New topic</Button>
      </Row>
      <ul>
          <li v-for="discussion in discussions" :key="discussion.id">
              <a :href="'/topics/' + discussion.id"><div class="title">{{discussion.title}}</div></a>
              <div>
              {{`#${discussion.id} for problem #${discussion.pid} by ${discussion.username}`}}
              </div>
          </li>
      </ul>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    props: {
        problem: {
            type: Number,
            default: 0
        },
        contestId: {}
    },
    data() {
        return {
            loading: true,
            discussion: null
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            this.loading = true
            let params = {}

            if (this.problem) {
                params.prob = this.problem
            }

            axios
                .get('/api/topicsByContest/' + this.contestId, {
                    params
                })
                .then(res => {
                    this.discussions = res.data
                    this.loading = false
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
    border-top 1px solid #e1e4e8
    list-style-type none

    & .title
        font-size 1.6em

a
    color #24292e

    &:hover
        color #0366d6
</style>
