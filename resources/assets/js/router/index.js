import VueRouter from 'vue-router'
import Vue from 'vue'

Vue.use(VueRouter)

const Problem = () => import('../components/Problem.vue')

export default new VueRouter({
    mode: 'history',
    saveScrollPosition: true,
    base: '/practice/',
    routes: [{ path: '/:problemId', component: Problem, name: 'problem' }]
})
