<template>
  <div v-if="user">
    <Row type="flex" justify="space-around">
    <Col span="8">
      <img :src="user.avatar" width="180" />
      <Upload action="/api/uploadFile" :on-success="uploadFileSuccess" :on-preview="changeAvatarToFile" :paste="true" type="drag" :with-credentials="true" :headers="{'X-CSRF-TOKEN': csrfToken}">
        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
        <p>上传头像</p>
      </Upload>
      <Checkbox v-model="user.regenerate_avatar">重新生成头像</Checkbox>
    </Col>
    <Col span="10">
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
    </Col>
    </Row>
    <Button @click="submit" style="float: right">提交修改</Button>
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
                password_confirmation: '',
                regenerate_avatar: false
            }
        }
    },
    computed: {
        ...mapGetters({
            storeUser: 'user'
        }),
        csrfToken() {
            return window.token.content
        }
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
        changeAvatar(response) {
            this.user.avatar = response.path
        },
        uploadFileSuccess(response) {
            this.changeAvatar(response)
        },
        changeAvatarToFile(file) {
            this.changeAvatar(file.response)
        },
        submit() {
            let data = new FormData()

            const props = [
                'nickname',
                'email',
                'school',
                'password',
                'password_confirmation',
                'regenerate_avatar',
                'avatar'
            ]
            for (let key of props) {
                data.append(key, this.user[key])
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

