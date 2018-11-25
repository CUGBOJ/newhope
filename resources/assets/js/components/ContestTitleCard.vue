<template>
  <div>
    <Card>
      <div style="text-align:center">
        <Time :time="start" type="datetime" style="float:left"></Time>
        <Time :time="end" type="datetime" style="float:right"></Time>
        <br>
        <br>
        <h1 style="margin-top:40px font-size:20px">{{title}}</h1>
        <contestTimer :start="start" :end="end"/>
        <Tag color="yellow" v-if="now < start">No Started</Tag>
        <Tag color="red" v-else-if="now > end">Ended</Tag>
        <Tag color="green" v-else>Running</Tag>
      </div>
    </Card>
  </div>
</template>
<script>
import contestTimer from './ContestTimer.vue'
export default {
    props: ['title','start','end'],
    components: {
        contestTimer: contestTimer
    },
    computed: {
        now() {
            return this.$store.state.time
        }
    } 
}
</script>
