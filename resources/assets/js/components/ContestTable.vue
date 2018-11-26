<template>
  <Spin size="large" fix v-if="loading"></Spin>
  <Card v-else>
    <Row v-if="this.$store.state.user && this.$store.state.user.can.manage_contents">
      <Button :to="{name: 'contest-create'}" type="primary">New contest</Button>
    </Row>
    <CellGroup>
      <Cell v-for="(contest, index) in contests" 
      :key="contest.id" 
      :title="contest.title" 
      @click.native="checkRegister(index)">
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
            contests: null
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
        },
        checkRegister(index) {
            if (this.contests[index].register_required && !(this.isAdmin || this.user.registered)) {
                this.$Modal.confirm({
                    content: '本场比赛只允许注册用户参加!',
                    cancelText: '放弃',
                    okText: '完善信息',
                    onOk: () => {
                        this.$router.push({
                            name: 'edit-profile',
                            params: {
                                username: this.user.username
                            }
                        })
                    }
                }) 
            } else {
                this.$router.push({
                    name: 'contest-show',
                    params: {
                        id: this.contests[index].id
                    }
                })
            }
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        }, 
        isAdmin() {
            return this.user && this.user.can.manage_contents
        }    
    }
}
</script>
<style lang="stylus" scoped>
</style>
