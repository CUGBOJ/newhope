<template>
  <div>
    <h1>所有User</h1>
    <a>创建User</a>
    <ul class="users">
        <li v-for="(value, key) in users" :key="key">
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
            users: []
        }
    }
}
</script>
