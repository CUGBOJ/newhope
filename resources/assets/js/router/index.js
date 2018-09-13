import VueRouter from 'vue-router'
import Vue from 'vue'
import iView from 'iview'

Vue.use(VueRouter)

const LoginPane = () => import('../components/Login.vue')
const SigninPane = () => import('../components/Signin.vue')
const NotFoundPage = () => import('../components/NotFoundPage.vue')

const ProblemTable = () => import('../components/ProblemTable.vue')
const UsersTable = () => import('../components/UsersTable.vue')
const StatusTable = () => import('../components/Status.vue')
const DiscussTable = () => import('../components/DiscussTable.vue')
const DiscussForum = () => import('../components/DiscussForum.vue')
const AnnouncementTable = () => import('../components/AnnouncementTable.vue')
const NotificationPane = () => import('../components/NotificationPane.vue')
const ContestTable = () => import('../components/ContestTable.vue')
const ContestShow = () => import('../components/ContestShow.vue')
const ContestPractice = () => import('../components/ContestPractice.vue')

const Profile = () => import('../components/Profile.vue')
const ProfileEditor = () => import('../components/ProfileEditor.vue')

const Practice = () => import('../components/Practice.vue')
const Problem = () => import('../components/Problem.vue')
const ProblemEditor = () => import('../components/ProblemEditor.vue')

const router = new VueRouter({
    mode: 'history',
    saveScrollPosition: true,
    base: '/',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Profile
        },
        {
            path: '/login',
            name: 'login',
            component: LoginPane
        },
        {
            path: '/signin',
            name: 'signin',
            component: SigninPane
        },
        {
            path: '/problems',
            name: 'problems',
            component: ProblemTable
        },
        {
            path: '/problem/:id/edit',
            name: 'problem-edit',
            component: ProblemEditor
        },
        {
            path: '/users',
            name: 'users',
            component: UsersTable
        },
        {
            path: '/user/:username',
            name: 'user-show',
            component: Profile
        },
        {
            path: '/user/:username/edit',
            name: 'edit-profile',
            component: ProfileEditor
        },
        {
            path: '/statuses',
            name: 'statuses',
            component: StatusTable
        },
        {
            path: '/discusses',
            name: 'discusses',
            component: DiscussTable
        },
        {
            path: '/discuss/:id',
            name: 'discuss-show',
            component: DiscussForum
        },
        {
            path: '/announcements',
            name: 'announcements',
            component: AnnouncementTable
        },
        {
            path: '/announcement/:id',
            name: 'announcement-show',
            component: AnnouncementTable
        },
        {
            path: '/contests',
            name: 'contests',
            component: ContestTable
        },
        {
            path: '/contest/:id',
            name: 'contest-show',
            component: ContestShow
        },
        {
            path: '/contest/:id/practice/:char',
            component: ContestPractice,
            name: 'contest-practice'
        },

        {
            path: '/notice',
            name: 'notice',
            component: NotificationPane
        },
        {
            path: '/practice',
            name: 'practice',
            component: Practice,
            children: [
                {
                    path: ':problemId',
                    component: Problem,
                    name: 'problem',
                    children: [
                        {
                            path: 'topic'
                        }
                    ]
                }
            ]
        },
        {
            path: '*',
            component: NotFoundPage
        }
    ]
})

iView.LoadingBar.config({
    color: '#2dde98',
    failedColor: '#d20962',
    height: 3
})

router.beforeEach((to, from, next) => {
    iView.LoadingBar.start()
    next()
})

router.afterEach(() => {
    iView.LoadingBar.finish()
})

export default router
