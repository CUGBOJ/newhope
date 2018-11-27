<template>
  <div>
    <h3>
      我的通知
    </h3>
    <Button @click="readAll">阅读所有</Button>
    <div class="notification-list" v-if="notification && notification.length">
      <div v-for="(val, key) in notification" :key="key">
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
        <div v-else-if="val.type.endsWith('TeamApplyReplied')" :key="index" v-for="(data, index) in parseJsonData(val.data)">
            收到用户{{data.username}}加入
            <router-link :to="{name: 'team-edit', params: {id: data.team_id}}">
            {{data.team_id}}
            </router-link>
            队申请
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
        parseJsonData(data) {
            return {
                _: JSON.parse(data)
            }
        },
        readOne() {},
        readAll() {
            axios.post('/notifications').then(res => {
                this.$Notice.success({
                    title: 'Success',
                    desc: res.data.message
                })
                this.fetchData()
            })
        },
        fetchData() {
            axios.get('/notifications').then(res => {
                this.notification = res.data
            })
        }
    }
}
</script>
