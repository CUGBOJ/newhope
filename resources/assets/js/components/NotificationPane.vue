<template>
  <div>
    <h3>
      我的通知
    </h3>
    <Button @click="readAll">阅读所有</Button>
    <div class="notification-list" v-if="notification && notification.length">
      <div v-for="(val, key) in notification" :key="key" v-if="val.read_at !== null">
        <div v-if="val.types === 'announcementReplied'">
          <div>
            Admin:
            <router-link :to="{name: 'announcement-show', params: {id: val.announcement_id}}">
              {{ val.announcement_title }}
            </router-link>
          </div>
          <span>
            {{ val.created_at }}
          </span>
          <Button @click="readOne">阅读该条</Button>
        </div>
        <div v-else-if="val.types === 'topicReplied'">
          <router-link :to="{name: 'user-show', params: { username: val.username }}">{{ val.username }}</router-link>
          在
          <router-link :to="{ name: 'topic-show', params: { id: val.topic_id }}">{{val.topic_title }}</router-link>
          评论了
          <div class="reply-content">
            {{ val.reply_content }}
          </div>
          <span>{{val.created_at}}</span>
          <Button @click="readOne">阅读该条</Button>
        </div>
      </div>
    </div>
    <div v-else>
      没有消息通知
    </div>
  </div>
</template>
<script>
import axios from 'axios'
export default {
    data() {
        return {
            notification: []
        }
    },
    created() {
        this.fetchData()
    },
    methods: {
        readOne() {},
        readAll() {
            axios.post('/api/notifications').then(res => {
                this.$Notice.success({
                    title: 'Success',
                    desc: res.data.message
                })
            })
        },
        fetchData() {
            axios.get('/api/notifications').then(res => {
                this.notification = res.data
            })
        }
    }
}
</script>
