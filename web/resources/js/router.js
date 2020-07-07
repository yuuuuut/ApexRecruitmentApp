import Vue from 'vue'
import VueRouter from 'vue-router'

import PostIndex from './pages/PostIndex.vue'
import Login     from './pages/Login.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: PostIndex
    },
    {
        path: '/login',
        component: Login
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router