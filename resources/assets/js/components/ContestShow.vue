<template>

    <div>
        <div>   
            <contesttitlecard></contesttitlecard>
        </div>
        <Tabs active-key="key1" style="margin-top:20px">
            <Tab-pane label="Problem" key="key1">
                <contestproblems v-bind:contestid="id" />
            </Tab-pane>
            <Tab-pane label="Status" key="key2">
                <conteststatus v-bind:contestid="id" />
            </Tab-pane>
            <Tab-pane label="Standing" key="key3">Standing</Tab-pane>
            <Tab-pane label="Topics" key="key4">
                <contesttopics  v-bind:contestid="id" />
            </Tab-pane>
            <Tab-pane label="Clarify" key="key5">Clarify</Tab-pane>
        </Tabs>
        
    </div>
    
</template>

<script>
import conteststatus from './ContestStatus.vue'
import contesttopics from './ContestTopicsTable.vue'
import contestproblems from './ContestProblemsTable.vue'
import contesttitlecard from './ContestTitleCard.vue'


export default {
    components: {
        'conteststatus': conteststatus,
        'contesttopics': contesttopics,
        'contestproblems':contestproblems,
        'contesttitlecard':contesttitlecard

    },
    data(){
        return{
            id:location.href.split('/')[4]
        }
    }

}
</script>
<style>
</style>
