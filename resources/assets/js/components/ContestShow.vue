<template>
    <Spin v-if ="loading"></Spin>
    <div v-else>
        <div>
            <contestTitleCard v-if="contest" :title="contest.title" :start="new Date(contest.start_time)" :end="new Date(contest.end_time)">
            </contestTitleCard>
        </div>
        <Tabs style="margin-top:20px">
            <Button v-if="this.$store.state.user && this.$store.state.user.can.manage_contents" :to="{name: 'contest-edit', params: {id: contestId}}" type="warning" slot="extra">Update</Button>
            <Tab-pane label="Problem" key="problems" v-if="canSeeContest">
                <Card>
                     <CellGroup>
                         <Cell v-for="problem in contest.problems" 
                            :key="problem.id" 
                            :to="{name: 'contest-practice', params: {contestId, keychar: problem.pivot.keychar}}">
                            <Tag type="dot" :color="problem.pivot.color">{{String.fromCharCode(64 + problem.pivot.keychar)}}</Tag>
                            {{problem.title}}
                         </Cell>
                     </CellGroup>
                </Card>
            </Tab-pane>
            <Tab-pane label="Status" key="status" v-if="canSeeContest">
                <contestStatus :contestId="contestId" />
            </Tab-pane>
            <Tab-pane label="Standing" key="standing" v-if="canSeeContest">
                <contestStanding :contestId="contestId" :problems="contest.problems"/>
            </Tab-pane>
            <Tab-pane label="Topics" key="topics" v-if="canSeeContest">
                <contestTopics :contestId="contestId" />
            </Tab-pane>
            <Tab-pane label="Clarification" key="clarification">Clarification</Tab-pane>
            <Tab-pane label="Teams" key="team">
                <Button @click="createTeam">新建队伍</Button>
                <Card>
                     <CellGroup>
                         <Cell v-for="team in contest.teams" :key="team.id" @click.native="joinTeam(team.id)">
                            <div>
                                {{team.teamname}}
                            </div>
                            <Avatar v-for="user in team.users" :key="user.id" shape="square" :src="user.avatar"/>
                         </Cell>
                     </CellGroup>
                </Card>
            </Tab-pane>
        </Tabs>
    </div>
</template>

<script>
import contestStatus from './Status.vue'
import contestTopics from './ContestTopicsTable.vue'
import contestTitleCard from './ContestTitleCard.vue'
import contestStanding from './ContestStanding.vue'
import axios from 'axios'

export default {
    data() {
        return {
            lastCid: null,
            loading: true,
            contest: null
        }
    },
    created() {
        this.fetchData()
    },    
    components: {
        contestStatus: contestStatus,
        contestTopics: contestTopics,
        contestTitleCard: contestTitleCard,
        contestStanding: contestStanding
    },
    methods: {
        createTeam() {

        },
        joinTeam(id) {
            this.$Modal.confirm({
                content: '是否加入该队伍？',
                onOk: () => {
                    axios.post('' + id)
                }
            })
        },
        fetchData() {
            this.loading = true
            if (this.contestId) {
                axios
                    .get('/contest/' + this.contestId)
                    .then(res => {
                        this.contest = res.data
                        this.loading = false
                    })
                    .catch(() => {
                        this.$router.push('/404')
                    })
            }  else {
                this.$router.push('/404')
            }

            window.Echo.channel('contest.' + this.$route.params.id.toString())
                .listen('ContestMessageEvent', () => {
                })
            this.lastCid = this.$route.params.id.toString()

        }
    },
    computed: {
        contestId() {
            return this.$route.params.id.toString()
        },
        canSeeContest() {
            return (this.contest && this.contest.is_started) || (this.$store.state.user && this.$store.state.user.can.manage_contents)
        }
    },
    beforeDestroy() {
        if (this.lastCid != null) {
            window.Echo.leave('contest.' + this.lastCid)
        }
    }
}
</script>
<style>
</style>
