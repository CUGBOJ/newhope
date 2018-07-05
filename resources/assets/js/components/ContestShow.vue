<template>
<div>
<b-tabs>
  <b-tab title="Problem" >
      <contestproblems v-bind:contestid="id" />
  </b-tab>
  <b-tab title="Status">
      <conteststatus v-bind:contestid="id" />
  </b-tab>
    <b-tab title="Standing">

  </b-tab>
    <b-tab title="Topics">
      <contesttopics  v-bind:contestid="id" />
  </b-tab>
    <b-tab title="Clarify">

  </b-tab>
</b-tabs>
</div>
</template>

<script>
import conteststatus from './ContestStatus.vue'
import contesttopics from './ContestTopicsTable.vue'
import contestproblems from './ContestProblemsTable.vue'


export default {
    components: {
        'conteststatus': conteststatus,
        'contesttopics': contesttopics,
        'contestproblems':contestproblems

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
