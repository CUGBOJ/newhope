<template>
    <Spin v-if ="loading"></Spin>
    <div v-else>
        <div>
            <contestTitleCard v-if="contest" :title="contest.title" :start="new Date(contest.start_time)" :end="new Date(contest.end_time)">
            </contestTitleCard>
        </div>
        <Tabs style="margin-top:20px">
            <Button v-if="this.isAdmin" :to="{name: 'contest-edit', params: {id: contestId}}" type="warning" slot="extra">Update</Button>
            <Tab-pane label="Problem" key="problems" v-if="canSeeContest">
                <Card>
                     <CellGroup>
                         <Cell v-for="problem in contest.problems" 
                            :key="problem.id" 
                            :to="{name: 'contest-practice', params: {contestId, keychar: problem.pivot.keychar}}">
                            <Tag type="dot" :color="problem.pivot.color">{{String.fromCharCode(64 + problem.pivot.keychar)}}</Tag>
                            {{problem.title}}
                         </Cell>
                     </CellGroup>
                </Card>
            </Tab-pane>
            <Tab-pane label="Status" key="status" v-if="canSeeContest">
                <contestStatus :contestId="contestId" />
            </Tab-pane>
            <Tab-pane label="Standing" key="standing" v-if="canSeeContest">
                <contestStanding :contestId="contestId" :problems="contest.problems"/>
            </Tab-pane>
            <!-- <Tab-pane label="Topics" key="topics" v-if="canSeeContest">
                <contestTopics :contestId="contestId" />
            </Tab-pane> -->
            <Tab-pane label="Clarification" key="clarification">暂无公告</Tab-pane>
            <Tab-pane label="Teams" key="team">
                <Modal v-model="showEditModal" @on-ok="createNewTeam" :loading="this.submitLoading" draggable>
                    <Alert type="warning">请使用健康向上的队伍名，队伍名不可修改</Alert>
                    <Tag>队伍名</Tag>
                    <Input v-model="modalData.teamname"/>
                </Modal>
                <Button v-if="!myTeam" @click="showEditModal = true" type="primary">新建队伍</Button>
                <Button v-else @click="quitTeam" type="primary">退出队伍</Button>
                <Button v-if="myTeam && myTeam.captain == user.id" @click="manageTeam" type="primary">管理队伍</Button>
                <Card>
                     <CellGroup>
                         <Cell v-for="team in contest.teams" :selected="myTeam && myTeam.id == team.id" :key="team.id" @click.native="joinTeam(team.id)">
                            <div>
                                {{team.teamname}}
                            </div>
                            <Avatar v-for="user in team.users" :key="user.id" shape="square" :src="user.avatar"/>
                         </Cell>
                     </CellGroup>
                </Card>
            </Tab-pane>
        </Tabs>
    </div>
</template>

<script>
import contestStatus from './Status.vue'
import contestTopics from './ContestTopicsTable.vue'
import contestTitleCard from './ContestTitleCard.vue'
import contestStanding from './ContestStanding.vue'
import axios from 'axios'

export default {
    components: {
        contestStatus: contestStatus,
        contestTopics: contestTopics,
        contestTitleCard: contestTitleCard,
        contestStanding: contestStanding
    },
    data() {
        return {
            lastCid: null,
            loading: true,
            contest: null,
            myTeam: null,
            showEditModal: false,
            submitLoading: false,
            modalData: {
                teamname: ''
            }
        }
    },
    created() {
        this.fetchData()
    },    
    mounted() {
    },
    methods: {
        joinTeam(id) {
            if (this.myTeam) {
                this.$Notice.info({
                    title: '申请失败',
                    desc: this.myTeam.id == id ? '你已加入此队伍' : '你已有队伍，请先退出队伍'
                }) 
                return
            }

            this.$Modal.confirm({
                content: '是否申请加入该队伍？',
                onOk: () => {
                    axios.post('team/' + id)
                        .then(res => {
                            if (res.data.res == 'success')
                                this.$Notice.success({
                                    title: '申请成功',
                                    desc: res.data.message
                                })
                            else 
                                this.$Notice.error({
                                    title: '申请失败',
                                    desc: `${res.data.message}`,
                                    duration: 0
                                })
                        })
                }
            })
        },
        createNewTeam() {
            axios.post('teams', {
                teamname: this.modalData.teamname,
                contest_id: this.contest.id
            })
                .then(res => {
                    this.$Notice.success({
                        title: '新建队伍成功',
                        desc: res.data.message
                    })
                    this.fetchData()
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
                        title: '新建队伍失败',
                        desc: `${err.response.data.message}:\n ${detail}`,
                        duration: 0
                    })
                })
        },
        manageTeam() {
            this.$router.push({
                name: 'team-edit',
                params: {
                    id: this.myTeam.id
                }
            })
        },
        quitTeam() {
            this.$Modal.confirm({
                content: '你真的要退出队伍吗？',
                cancelText: '算了',
                okText: '退出',
                onOk: () => {
                    axios.post('removeMember/' + this.myTeam.id, {
                        user_id: this.user.id
                    })
                        .then(res => {
                            this.$Notice.success({
                                title: '退出队伍成功',
                                desc: res.data.message
                            }) 
                            this.fetchData()
                        })
                }
            }) 
        },
        fetchData() {
            this.loading = true
            if (this.contestId) {
                axios
                    .get('/contest/' + this.contestId)
                    .then(res => {
                        if (!res.data) {
                            this.askMembership()
                            return
                        }
                        this.contest = res.data
                        this.fetchUserTeamData()
                        this.loading = false
                    })
                    .catch(() => {
                        this.$router.push('/404')
                    })
            }  else {
                this.$router.push('/404')
            }

            window.Echo.channel('contest.' + this.$route.params.id.toString())
                .listen('ContestMessageEvent', () => {
                })
            this.lastCid = this.$route.params.id.toString()
        },
        fetchUserTeamData() {
            axios.get(`teamByContest/${this.contest.id}`)
                .then(res => {
                    this.myTeam = res.data ? res.data : null
                })
        },
        askMembership() {
            this.$Modal.confirm({
                content: '是否加入比赛？',
                onOk: () => {
                    axios.post('addContestUser/' + this.contestId)
                        .then(res => {
                            this.$Notice.success({
                                title: '加入成功',
                                desc: res.data.message
                            })
                            this.fetchData()
                        })
                        .catch(err => {
                            this.$Notice.error({
                                title: '加入失败',
                                desc: `${err.response.data.message}`,
                                duration: 0
                            })
                        })
                }
            }) 
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        contestId() {
            return this.$route.params.id.toString()
        },
        canSeeContest() {
            return (this.contest && this.contest.is_started) || this.isAdmin
        },
        isAdmin() {
            return this.user && this.user.can.manage_contents
        }
    },
    beforeDestroy() {
        if (this.lastCid != null) {
            window.Echo.leave('contest.' + this.lastCid)
        }
    }
}
</script>
<style>
</style>
