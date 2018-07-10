<template>
<div>
    <Slider :value="value9" :tip-format="format"></Slider>
    <!-- <Slider :value="value10" :tip-format="hideFormat"></Slider> -->
    </div>
</template>
<script>
export default {
    data () {
        return {
            value9: 25,
            // value10: 25
        }
    },
    methods: {
        format (val) {
            return '进度' + val + '%'
        },
        hideFormat () {
            return ''
        }
    }
}
</script>
