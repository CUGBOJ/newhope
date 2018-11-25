<template>
  <Spin size="large" fix v-if="loading"></Spin>
  <div v-else>
    <Row v-if="this.$store.state.user && this.$store.state.user.can.manage_contents">
      <Button type="primary" @click="showCreatorModal">New announcement</Button>
    </Row>
    <ul>
      <li v-for="(item, index) in announcements" :key="index">
        <a @click="viewItem(index)">
          <div class="title">{{item.title}}</div>
        </a>
        <div>
            <Tag color="default">
                {{`#${item.id}`}}
            </Tag>
            <Time :time="item.updated_at"></Time>
        </div>
      </li>
    </ul>
    <Modal v-model="showModal" v-if="modalData" :title="modalData.title">
        <p>{{modalData.body}}</p>
        <div slot="footer">
            <Button @click="showEditModal=isEditor=true" type="warning" v-if="this.$store.state.user && this.$store.state.user.can.manage_contents">Update</Button>
        </div>
    </Modal>
    <Modal v-model="showEditModal" @on-ok="submitUpdate" :loading="this.submitLoading" title="Announcement Editor" draggable>
        <Tag>Title</Tag>
        <Input v-model="modalData.title"/>
        <Tag>Content</Tag>
        <Input v-model="modalData.body" type="textarea"/>
    </Modal>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            loading: true,
            announcement: null,
            showModal: false,
            showEditModal: false,
            modalData: {},
            isEditor: false,
            submitLoading: false
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        submitUpdate() {
            if (this.isEditor) {
                this.submitLoading = true
                axios.post('/announcement/' + this.modalData.id, this.modalData)
                    .then(res => {
                        this.submitLoading = false
                        this.$Notice.success({
                            title: '更新公告成功',
                            desc: res.data
                        })
                        this.fetchData()
                    })
                    .catch(err => {
                        this.submitLoading = false
                        this.$Notice.error({
                            title: '更新公告失败',
                            desc: err.response.data.message,
                            duration: 0
                        })
                    })
            } else {
                this.submitLoading = true
                axios.post('/announcement/', this.modalData)
                    .then(res => {
                        this.submitLoading = false
                        this.$Notice.success({
                            title: '添加公告成功',
                            desc: res.data
                        })
                        this.fetchData()
                    })
                    .catch(err => {
                        this.submitLoading = false
                        this.$Notice.error({
                            title: '添加公告失败',
                            desc: err.response.data.message,
                            duration: 0
                        })
                    })
            }
        },
        showCreatorModal() {
            this.showEditModal = true 
            this.isEditor = false
            this.modalData = {}
        },
        viewItem(id) {
            this.showModal = true
            this.modalData = this.announcements[id]
        },
        fetchData() {
            this.loading = true
            let params = {}

            axios
                .get('/announcements', {
                    params
                })
                .then(res => {
                    this.announcements = res.data
                    this.loading = false
                })
                .catch(err => {
                    this.$Message.error(err.response.data.message)
                })
        }
    }
}
</script>
<style lang="stylus" scoped>
li
    border-bottom 1px solid #e1e4e8
    list-style-type none

    & .title
        font-size 1.6em

li > a
    color #24292e

    &:hover
        color #0366d6
</style>
