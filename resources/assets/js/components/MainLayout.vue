<template>
  <div>
    <header-nav/>
    <div style="min-height: 90vh; height: 90vh; padding: 64px 30px 0;">
      <router-view style="margin: 10px 0; max-height: 80vh; overflow: scroll"></router-view>
    </div>
    <i-footer class="layout-footer-center">2019 &copy; OJ_NG</i-footer>
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
