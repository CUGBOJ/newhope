<template>
  <div>
    <header-nav/>
    <div style="min-height: 90vh; height: 90vh; padding: 64px 30px 0;">
      <router-view></router-view>
    </div>
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
