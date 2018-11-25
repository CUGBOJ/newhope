<template>
    <Poptip v-if="user" trigger="hover" width="300" :transfer="true">
        <a> {{user.username}} </a>
        <div slot="content">
            <Row>
                <Col span="6">
                <Avatar v-if="user" shape="square" :src="user.avatar" size="large" /> 
                </Col>
                <Col span="18">
                    <Row>
                        {{user.username}} {{user.nickname}}
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
    props: ['user'],
    data() {
        return {}
    }
}
</script>