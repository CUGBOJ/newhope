<template>
  <Row>
    <Col span="8" push="8">
    <Form ref="form" :model="form" :label-width="80" :rules="rule">
      <FormItem label="用户名">
        <Input name="username" v-model="form.username" clearable> </Input>
      </FormItem>
      <FormItem label="昵称">
        <Input name="nickname" v-model="form.nickname" clearable> </Input>
      </FormItem>
      <FormItem label="邮箱">
        <Input name="email" type="email" v-model="form.email" clearable> </Input>
      </FormItem>
      <FormItem label="密码">
        <Input name="password" type="password" v-model="form.password" clearable> </Input>
      </FormItem>
      <FormItem label="确认密码">
        <Input name="password_confirmation" type="password" v-model="form.password_confirmation" clearable></Input>
      </FormItem>
      <FormItem label="学校">
        <Input name="school" v-model="form.school" clearable></Input>
      </FormItem>
      <ButtonGroup style="float: right">
        <i-button type="primary" @click="handleSubmit">注册</i-button>
        <i-button type="warning" html-type="reset">重置</i-button>
      </ButtonGroup>
    </Form>
    </Col>
  </Row>
</template>

<script>
import axios from 'axios'
import {mapActions} from 'vuex'

export default {
    methods: {
        ...mapActions(['getProfile']),
        handleSubmit() {
            axios
                .post('/api/user', {
                    username: this.form.username,
                    password: this.form.password,
                    nickname: this.form.nickname,
                    email: this.form.email,
                    password_confirmation: this.form.password_confirmation,
                    school: this.form.school
                })
                .then(res => {
                    this.$Message.success(res.data.message)
                    window.history.length > 1
                        ? this.$router.go(-1)
                        : this.$router.push('/')
                    this.getProfile()
                })
                .catch(err => {
                    let detail = err.response.data.message + '\n'

                    if (err.response.data.errors) {
                        let errors = err.response.data.errors
                        if (errors) {
                            for (let error in errors) {
                                detail += `${error}:${errors[error]}`
                            }
                        }
                    }

                    this.$Notice.error({
                        title: 'Error',
                        desc: detail,
                        duration: 0
                    })
                })
        }
    },
    data() {
        return {
            form: {
                password: '',
                username: '',
                nickname: '',
                email: '',
                password_confirmation: '',
                school: ''
            },
            rule: {
                username: [
                    {
                        required: true,
                        message: 'Please fill in the username.',
                        trigger: 'blur'
                    }
                ],
                password: [
                    {
                        required: true,
                        message: 'Please fill in the password.',
                        trigger: 'blur'
                    },
                    {
                        type: 'string',
                        min: 4,
                        message:
                            'The password length cannot be less than 6 bits.',
                        trigger: 'blur'
                    }
                ]
            }
        }
    }
}
</script>
