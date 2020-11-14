import VueRouter from 'vue-router'
// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'

// Routes
const routes = [{
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: true
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})

export default router