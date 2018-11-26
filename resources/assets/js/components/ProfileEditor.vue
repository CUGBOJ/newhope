<template>
  <div v-if="user">
    <Row type="flex" justify="space-around" :gutter="16">
    <Col span="8">
        <img :src="user.avatar" width="180" />
        <Upload action="/api/uploadFile" :on-success="uploadFileSuccess" :on-preview="changeAvatarToFile" :paste="true" type="drag" :with-credentials="true" :headers="{'X-CSRF-TOKEN': csrfToken}">
        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
        <p>上传头像</p>
        </Upload>
        <Checkbox v-model="user.regenerate_avatar">重新生成头像</Checkbox>
    </Col>
    <Col span="8">
        <div>
        <label for="nickname">昵称：</label>
        <Input type="text" v-model="user.nickname" />
        </div>
        <div>
        <label for="email">邮箱：</label>
        <Input type="email" v-model="user.email" />
        </div>
        <div>
        <label for="password">新密码：</label>
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
    <Col span="8">
        <Checkbox v-model="register">注册参加比赛</Checkbox>
        <div v-if="register">
            <Alert type="error">请正确填写以下信息以保证参加比赛的有效性</Alert>
            <div>
            <label for="old_oj_account">OJ账号：</label>
                <Input type="text" name="old_oj_account" v-model="user.old_oj_account" />
            </div> 
            <Alert type="info">请填写acm.cugb.edu.cn网站上的注册用户名</Alert>
            <div>
            <label for="student_id">学号：</label>
                <Input type="text" name="student_id" v-model="user.student_id" />
            </div>
            <div>
            <label for="major">专业：</label>
                <Input type="text" name="major" v-model="user.major" />
            </div>
            <Alert type="info">请按照学校信息门户上的正确名称填写，如计算机科学与技术</Alert>
            <div>
            <label for="gender">性别：</label>
                <RadioGroup v-model="user.gender">
                <Radio label="Male"></Radio>
                <Radio label="Female"></Radio>
                <Radio label="Secret"></Radio>
                </RadioGroup>
            <Alert type="info">本条与女生队认定相关</Alert>
            </div>
            <div>
            <label for="info">个人简介：</label>
                <Input type="textarea" name="info" v-model="user.info" />
            </div>
            <Alert type="info">此条与ACM队招新相关，请尽量详述参加比赛的动机，不少于30个字符</Alert>
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
            register: true,
            user: {
                nickname: '',
                avatar: '',
                email: '',
                school: '',
                password: '',
                password_confirmation: '',
                old_oj_account: '',
                major: '',
                student_id: '',
                info: '',
                gender: '',
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
                'avatar',
                'old_oj_account',
                'student_id',
                'gender',
                'major',
                'info'
            ]
            for (let key of props) {
                data.append(key, this.user[key])
            }

            if (this.register) data.append('register', true)

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

