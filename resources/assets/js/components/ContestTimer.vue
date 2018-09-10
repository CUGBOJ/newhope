<template>
<div>
    <Slider :value="progress" :tip-format="progressTip"></Slider>
</div>
</template>
<script>
export default {
    data () {
        return {
            progress: 25
        }
    },
    methods: {
        progressTip (val) {
            return '进度' + val + '%'
        },
        hideFormat () {
            return ''
        }
    }
}
</script>
