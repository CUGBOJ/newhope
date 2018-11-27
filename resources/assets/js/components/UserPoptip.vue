<template>
    <Poptip v-if="user" trigger="hover" width="300" :transfer="true">
        <Avatar v-if="type==='avatar'" shape="square" :src="user.avatar" size="large" /> 
        <a v-else> {{user.username}} </a>
        <div slot="content">
            <Row>
                <Col span="6">
                <Avatar v-if="type!=='avatar'" shape="square" :src="user.avatar" size="large" /> 
                </Col>
                <Col span="18">
                    <Row>
                        <router-link :to="{name: 'user-show', params: {username: user.username}}">
                            {{user.username}}
                        </router-link>
                    </Row>
                    <Row>
                        {{user.nickname}}
                    </Row>
                    <Row>
                    <div>{{user.solved}} solved.</div>
                    </Row>
                </Col>
            </Row>
        </div>
    </Poptip>    
</template>
<script>
export default {
    props: ['user', 'type'],
    data() {
        return {}
    }
}
</script>