<template>
  <div>
    <header-nav/>
    <card style="height: 80vh; margin: 80px 30px 0; overflow: auto;" dis-hover>
      <router-view></router-view>
    </card>
    <i-footer class="layout-footer-center">2018 &copy; OJ_NG</i-footer>
  </div>
</template>

<script>
import HeaderNav from './HeaderNav.vue'

export default {
    components: {
        'header-nav': HeaderNav
    }
}
</script>
