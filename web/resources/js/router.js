import Vue       from 'vue'
import VueRouter from 'vue-router'

import PostIndex from './pages/PostIndex.vue'
import Login     from './pages/Login.vue'

import store     from './store'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: PostIndex
    },
    {
        path: '/login',
        component: Login,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next('/')
            } else {
                next()
            }
        }
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router