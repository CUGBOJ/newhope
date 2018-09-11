<template>
  <div>
    <Card style="width:80%px height:300px">
      <div style="text-align:center">
        <!-- <img src="../../images/logo.png" style="width:50%"> -->
        <!-- <span style="float:left">Begin: 2018-07-09 19:00 CST</span>
        <span style="float:right">End: 2018-07-09 22:00 CST</span> -->
        <span style="float:left">Begin: {{start}} CST</span>
        <span style="float:right">End: {{end}} CST</span>
        <br>
        <br>
        <h1 style="margin-top:40px font-size:20px">{{title}}</h1>
        <contesttimer/>
        <Tag color="green" >Running</Tag>
      </div>
    </Card>
  </div>
</template>
<script>
import contesttimer from './ContestTimer.vue'
export default {
    props: ['title','start','end'],
    components: {
        contesttimer: contesttimer
    }
}
</script>
