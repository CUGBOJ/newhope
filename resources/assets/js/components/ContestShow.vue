<template>

    <div>
        <div>   
            <contestTitleCard></contestTitleCard>
        </div>
        <Tabs active-key="key1" style="margin-top:20px">
            <Tab-pane label="Problem" key="key1">
                <contestProblems v-bind:contestid="id" />
            </Tab-pane>
            <Tab-pane label="Status" key="key2">
                <contestStatus v-bind:contestid="id" />
            </Tab-pane>
            <Tab-pane label="Standing" key="key3">Standing</Tab-pane>
            <Tab-pane label="Topics" key="key4">
                <contestTopics  v-bind:contestid="id" />
            </Tab-pane>
            <Tab-pane label="Clarify" key="key5">Clarify</Tab-pane>
        </Tabs>
        
    </div>
    
</template>

<script>
import contestStatus from './Status.vue'
import contestTopics from './ContestTopicsTable.vue'
import contestProblems from './ContestProblemsTable.vue'
import contestTitleCard from './ContestTitleCard.vue'


export default {
    components: {
        contestStatus: contestStatus,
        contestTopics: contestTopics,
        contestProblems: contestProblems,
        contestTitleCard: contestTitleCard

    },
    data() {
        return {
            id: location.href.split('/')[4]
        }
    }

}
</script>
<style>
</style>
