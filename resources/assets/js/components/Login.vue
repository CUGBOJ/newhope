<template>
  <Form ref="form" :model="form" :label-width="80" :rules="rule">
    <FormItem label="用户名" prop="username">
      <Input name="username" type="text" v-model="form.username"> </Input>
    </FormItem>
    <FormItem label="密码" prop="password">
      <Input name="password" type="password" v-model="form.password" @keyup.enter.native="handleSubmit('form')"> </Input>
    </FormItem>
    <FormItem>
      <Button type="primary" @click="handleSubmit()">Signin</Button>
    </FormItem>
  </Form>
</template>

<script>
import axios from 'axios'

export default {
    methods: {
        handleSubmit() {
            axios
                .post('/api/login', {
                    username: this.form.username,
                    password: this.form.password
                })
                .then(res => {
                    this.$Message.success(res.data.message)
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000)
                })
                .catch(err => {
                    this.$Message.error(err.response.data.message)
                })
        }
    },
    data() {
        return {
            form: {
                password: '',
                username: ''
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
