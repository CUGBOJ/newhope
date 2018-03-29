<template>
  <div>
    <h1>所有Announcement</h1>
    <a>创建Announcement</a>
    <ul class="announcements">
        <li v-for="(value, key) in announcements" :key="key">
            <router-link :to="value.src">
                {{ value.title }} {{value.body}} {{value.updated_at}}
            </router-link>
        </li>
    </ul>
</div>
</template>
<script>
export default {
    data() {
        return {
            announcements: []
        }
    }
}
</script>
