<template>
  <div v-if="user">
    <div>
      <label for="" class="avatar-label">用户头像</label>
      <img :src="user.avatar" width="200" />
      <input type="file" name="avatar" id="avatar" />
    </div>
    <div>
      <label for="nickname">昵称：</label>
      <Input type="text" v-model="user.nickname" />
    </div>
    <div>
      <label for="email">邮箱：</label>
      <Input type="email" v-model="user.email" />
    </div>
    <div>
      <label for="password">密码：</label>
      <Input type="password" v-model="user.password" />
    </div>
    <div>
      <label for="password_confirmation">确认密码：</label>
      <Input type="password" v-model="user.password_confirmation" />
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
import {mapGetters, mapActions} from 'vuex'
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

            const props = [
                'nickname',
                'email',
                'school',
                'password',
                'password_confirmation'
            ]
            for (let key of props) {
                data.append(key, this.user[key])
            }

            if (document.getElementById('avatar').files.length) {
                data.set('avatar', document.getElementById('avatar').files[0])
            }

            data.append('_method', 'PATCH')

            axios
                .post('/user/' + this.storeUser.username, data)
                .then(res => {
                    this.$Notice.success({
                        title: '更新信息成功',
                        desc: res.data.message
                    })
                    this.getProfile()
                })
                .catch(err => {
                    let detail = ''
                    let errors = err.response.data.errors
                    if (errors) {
                        for (let error in errors) {
                            detail += `${error}:${errors[error]}`
                        }
                    }

                    this.$Notice.error({
                        title: '更新信息失败',
                        desc: `${err.response.data.message}:\n ${detail}`,
                        duration: 0
                    })
                })
        }
    }
}
</script>

