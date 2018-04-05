/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

Vue = window.Vue = require('vue')

/**
 * Use iView
 */
import iView from 'iview'

Vue.use(iView)

import 'iview/dist/styles/iview.css'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('main-layout', require('./components/MainLayout.vue'))

/*eslint-disable no-unused-vars*/
window.bus = new Vue()

/**
 * Use vue-router.
 */
import router from './router'

/**
 * Use vuex.
 */
import Vuex from 'vuex'
import store from './store'

const app = new Vue({
    router,
    store,
    el: '#app'
})

window.axios.interceptors.response.use(
    function(response) {
        // Do something with response data
        return response
    },
    function(error) {
        if (error.response && error.response.status === 401) {
            app.$Notice.warning({ title: '更新状态', desc: '用户状态已更新' })
            store.commit('setLoggedIn', false)
            store.commit('setUser')
        } else if (error.response && error.response.status === 403) {
            app.$Notice.warning({ title: '无权限', desc: '您没有此操作的权限' })
        } else if (error.response && error.response.status === 500) {
            app.$Notice.error({
                title: '服务器错误',
                desc: '发生了一些未知错误'
            })
        }
        return Promise.reject(error)
    }
)
