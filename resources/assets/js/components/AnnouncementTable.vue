<template>
  <Spin size="large" fix v-if="loading"></Spin>
  <div v-else>
    <Row>
      <Button type="primary">New announcement</Button>
    </Row>
    <ul>
      <li v-for="announcement in announcements" :key="announcement.id">
        <a :href="'/announcements/' + announcement.id">
          <div class="title">{{announcement.title}}</div>
        </a>
        <div>
            <Tag color="default">
                {{`#${announcement.id}`}}
            </Tag>
            <Tag color="primary">
                <Time :time="announcement.updated_at"></Time>
            </Tag>
        </div>
      </li>
    </ul>
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
