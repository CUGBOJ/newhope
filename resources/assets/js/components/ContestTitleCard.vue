<template>
  <div>
    <Card style="width:80%px height:300px">
      <div style="text-align:center">
        <span style="float:left">Begin: {{start}} CST</span>
        <span style="float:right">End: {{end}} CST</span>
        <br>
        <br>
        <h1 style="margin-top:40px font-size:20px">{{title}}</h1>
        <contestTimer :start="new Date(start)" :end="new Date(end)"/>
        <Tag color="green" >Running</Tag>
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
    }
}
</script>
