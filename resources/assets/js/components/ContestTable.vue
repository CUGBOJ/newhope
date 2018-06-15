<template>
  <Spin size="large" fix v-if="loading"></Spin>
  <div v-else>
    <ul>
      <li v-for="announcement in announcements" :key="announcement.id">
        <a :href="'/contests/' + contest.id">
          <div class="title">{{announcement.title}}</div>
        </a>
        <div>
          {{`#${announcement.id} updated at ${announcement.updated_at}`}}
        </div>
      </li>
    </ul>
    <Row>
      <Button type="primary">New announcement</Button>
    </Row>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            loading: true,
            announcement: null
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            this.loading = true
            let params = {}

            axios
                .get('/api/announcements', {
                    params
                })
                .then(res => {
                    this.announcements = res.data
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
    border-bottom 1px solid #e1e4e8
    list-style-type none

    & .title
        font-size 1.6em

a
    color #24292e

    &:hover
        color #0366d6
</style>
