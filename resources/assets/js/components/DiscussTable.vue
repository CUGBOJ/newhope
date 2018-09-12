<template>
  <Spin size="large" fix v-if="loading"></Spin>
  <div v-else>
      <Row>
          <Button type="primary" @click="this.window.location.href = '/topics/create'">New topic</Button>
      </Row>
      <ul>
          <li v-for="discussion in discussions" :key="discussion.id">
                <router-link :to="{name: 'discuss-show', params: { id: discussion.id}}">
                    <div class="title">{{discussion.title}}</div>
                </router-link>
                <div>
                {{`#${discussion.id} for problem #${discussion.problem_id} by ${discussion.username}`}}
                <Time :time="discussion.created_at"></Time>
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
        }
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
                .get('/api/topics', {
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
