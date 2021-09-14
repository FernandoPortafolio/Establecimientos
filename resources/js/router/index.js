import Vue from 'vue'
import VueRouter from 'vue-router'
import VuePageTransition from 'vue-page-transition'

const routes = [
    {
        path: '/',
        component: () => import('../pages/InicioEstablecimientos.vue'),
    },
    {
        path: '/establecimiento/:id',
        name: 'establecimiento',
        component: () => import('../pages/Establecimiento.vue'),
    },
]

const router = new VueRouter({
    routes,
})

Vue.use(VueRouter)
Vue.use(VuePageTransition)

export default router
