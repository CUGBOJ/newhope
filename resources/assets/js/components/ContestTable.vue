<template>
  <Spin size="large" fix v-if="loading"></Spin>
  <Card v-else>
    <Row>
      <Button :to="{name: 'contest-create'}" type="primary">New contest</Button>
    </Row>
    <CellGroup>
      <Cell v-for="contest in contests" 
      :key="contest.id" 
      :title="contest.title" 
      :to="{name: 'contest-show', params: {id: contest.id}}">
        <div slot="label">
            <Tag color="default">
                #{{contest.id}}
            </Tag>
            <Time :time="contest.start_time"></Time>
        </div>
      </Cell>
    </CellGroup>
  </Card>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            loading: true,
            contest: null
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
                .get('/contests', {
                    params
                })
                .then(res => {
                    this.contests = res.data
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
</style>
