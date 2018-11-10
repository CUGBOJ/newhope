<template>
    <Spin v-if ="loading"></Spin>
    <div v-else>
        <div>
            <contestTitleCard v-if="contest" :title="contest.title" :start="new Date(contest.start_time)" :end="new Date(contest.end_time)">
            </contestTitleCard>
        </div>
        <Tabs active-key="problems" style="margin-top:20px">
            <Tab-pane label="Problem" key="problems">
                <Card>
                     <CellGroup>
                         <Cell v-for="problem in contest.problems" 
                            :key="problem.id" 
                            :to="{name: 'contest-practice', params: {contestId, keychar: problem.pivot.keychar}}">
                            {{problem.title}}
                         </Cell>
                     </CellGroup>
                </Card>
            </Tab-pane>
            <Tab-pane label="Status" key="status">
                <contestStatus :contestId="contestId" />
            </Tab-pane>
            <Tab-pane label="Standing" key="standing">
                <contestStanding :contestId="contestId" :problems="contest.problems"/>
            </Tab-pane>
            <Tab-pane label="Topics" key="topics">
                <contestTopics :contestId="contestId" />
            </Tab-pane>
            <Tab-pane label="Clarification" key="clarification">Clarification</Tab-pane>
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
        fetchData() {
            this.loading = true
            if (this.contestId) {
                axios
                    .get('/api/contest/' + this.contestId)
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
        }
    },
    computed: {
        contestId() {
            return this.$route.params.id.toString()
        }
    }
}
</script>
<style>
</style>
