<template>
<div>
    <Slider :value="progress" :tip-format="progressTip"></Slider>
</div>
</template>
<script>
export default {
    props: {
        start: Date,
        end: Date
    },
    methods: {
        progressTip (val) {
            return '进度' + val + '%'
        }
    },
    computed: {
        progress() {
            if (this.now > this.end) {
                return 100
            } else if (this.now < this.start) {
                return 0
            } else {
                return (this.now - this.start) / (this.end - this.start) * 100
            }
        },
        now() {
            return this.$store.state.time
        }
    }
}
</script>
