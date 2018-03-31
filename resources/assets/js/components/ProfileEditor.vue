<template>
  <div v-if="user">
    <div class="form-group">
      <label for="" class="avatar-label">用户头像</label>
      <input type="file" name="avatar" id="avatar" />
      <br>
      <img :src="user.avatar" width="200" />
    </div>
    <div>
      <label for="nickname">昵称：</label>
      <Input type="text" v-model="user.nickname" />
    </div>
    <div>
      <label for="email">邮箱：</label>
      <Input type="text" v-model="user.email" />
    </div>
    <div>
      <label for="password">密码：</label>
      <Input type="password" name="password" />
    </div>
    <div>
      <label for="password_confirmation">确认密码：</label>
      <Input type="password" name="password_confirmation" />
    </div>
    <div>
      <label for="school">学校：</label>
      <Input type="text" name="school" v-model="user.school" />
    </div>
    <Button @click="submit">提交修改</Button>
  </div>
  <Spin size="large" fix v-else/>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
import axios from 'axios'

export default {
    data() {
        return {
            user: {
                nickname: '',
                avatar: '',
                email: '',
                school: '',
                password: '',
                password_confirmation: ''
            }
        }
    },
    computed: {
        ...mapGetters({
            storeUser: 'user'
        })
    },
    watch: {
        storeUser: function(value) {
            this.copyUser(value)
        }
    },
    created() {
        this.copyUser(this.storeUser)
    },
    methods: {
        ...mapActions(['getProfile']),
        copyUser(newUser) {
            if (!newUser) return
            for (let prop in this.user) {
                if (newUser[prop]) {
                    this.user[prop] = newUser[prop]
                }
            }
        },
        submit() {
            let data = new FormData()

            const props = ['nickname', 'email', 'school']
            for (let key of props) {
                data.append(key, this.user[key])
            }

            if (document.getElementById('avatar').files.length) {
                data.set('avatar', document.getElementById('avatar').files[0])
            }

            data.append('_method', 'PATCH')

            axios.post('/api/user/laravel', data).then(res => {
                this.$Notice.success({
                    title: '成功更新信息',
                    desc: res.data.message
                })
                this.getProfile()
            })
        }
    }
}
</script>

