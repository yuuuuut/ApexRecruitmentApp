import Vue       from 'vue'
import VueRouter from 'vue-router'

import PostIndex    from './pages/PostIndex.vue'
import PostDetail   from './pages/PostDetail.vue'
import UserDetail   from './pages/UserDetail.vue'
import Login        from './pages/Login.vue'
import SystemError  from './pages/errors/System.vue'

import store     from './store'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        component: PostIndex
    },
    {
        path: '/posts/:id',
        name: 'postDetail',
        component: PostDetail,
        props: true,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next({
                    name: 'Login'
                })
            }
        }
    },
    {
        path: '/users/:id',
        name: 'userDetail',
        component: UserDetail,
        props: true,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next()
            } else {
                next({
                    name: 'Login'
                })
            }
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next('/')
            } else {
                next()
            }
        }
    },
    {
        path: '/500',
        component: SystemError
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router