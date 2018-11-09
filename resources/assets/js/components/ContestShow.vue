<template>
    <div>
        <div>
            <contestTitleCard v-if="contest" v-bind:title="contest.title" v-bind:start="contest.start_time" v-bind:end="contest.end_time"></contestTitleCard>
        </div>
        <Tabs active-key="problems" style="margin-top:20px">
            <Tab-pane label="Problem" key="problems">
                <contestProblems v-bind:contestId="id" />
            </Tab-pane>
            <Tab-pane label="Status" key="status">
                <contestStatus v-bind:contestId="id" />
            </Tab-pane>
            <Tab-pane label="Standing" key="standing">
                <contestStanding  v-bind:contestId="id" />
            </Tab-pane>
            <Tab-pane label="Topics" key="topics">
                <contestTopics  v-bind:contestId="id" />
            </Tab-pane>
            <Tab-pane label="Clarification" key="clarification">Clarification</Tab-pane>
        </Tabs>
    </div>
</template>

<script>
import contestStatus from './Status.vue'
import contestTopics from './ContestTopicsTable.vue'
import contestProblems from './ContestProblemsTable.vue'
import contestTitleCard from './ContestTitleCard.vue'
import contestStanding from './ContestStanding.vue'
import axios from 'axios'


export default {
    data() {
        return {
            id: location.href.split('/')[4], 
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
        contestProblems: contestProblems,
        contestTitleCard: contestTitleCard,
        contestStanding: contestStanding
    },
    methods: {
        fetchData() {
            this.loading = true
            let contest_id = this.$route.params.id
            if (contest_id) {
                axios
                    .get('/api/contest/' + contest_id)
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
    }

}
</script>
<style>
</style>
