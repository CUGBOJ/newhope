<template>
<Row>
    <Col span="8" push="8">
        <Form ref="form" :model="form" :label-width="80" :rules="rule">
            <FormItem label="用户名" prop="username">
            <Input name="username" type="text" v-model="form.username"> </Input>
            </FormItem>
            <FormItem label="密码" prop="password">
            <Input name="password" type="password" v-model="form.password" @keyup.enter.native="handleSubmit"> </Input>
            </FormItem>
            <FormItem>
            <Button type="primary" @click="handleSubmit">登录</Button>
            </FormItem>
        </Form>
    </Col>
</Row>
</template>

<script>
import axios from 'axios'
import {mapActions, mapState} from 'vuex'


export default {
    computed: {
        ...mapState(['loggedIn'])
    },
    methods: {
        ...mapActions(['getProfile']),
        handleSubmit() {
            axios
                .post('/api/login', {
                    username: this.form.username,
                    password: this.form.password
                })
                .then(res => {
                    this.$Message.success(res.data.message)
            
                    window.history.length > 0
                        ? this.$router.go(-1)
                        : this.$router.push('/')
                    
                    this.getProfile()
                })
                .catch(err => {
                    this.$Message.error(err.response.data.message)
                })
        }
    },
    created() {

        if ( this.loggedIn == true) {
            if (window.history.length > 0) {
                this.$router.go(-1)
            } else {            
                this.$router.push('/')
            }
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
