import { createRouter, createWebHistory } from 'vue-router'
import store from '../store'

const Login = () => import('@/components/Login.vue')
const Register = () => import('@/components/Register.vue')
const DahboardLayout = () => import('@/components/layouts/Default.vue')
const NotFound = () => import('@/components/NotFound.vue')
const CountriesList = () => import('@/components/CountriesList.vue')
const Country = () => import('@/components/Country.vue')
const CreateCountry = () => import('@/components/CreateCountry.vue')

const routerHistory = createWebHistory()
const routes = [
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        path: "/",
        component: DahboardLayout,
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "countriesList",
                path: '/',
                component: CountriesList,
                meta: {
                    middleware: "auth",
                    title: `CountriesList`
                }
            },
            {
                name: "country",
                path: "/country/:id",
                component: Country,
                props: true,
                meta: {
                    middleware: "auth",
                    title: `Country`
                }
            },
            {
                name: "CreateCountry",
                path: "/create_country",
                component: CreateCountry,
                meta: {
                    middleware: "auth",
                    title: `CreateCountry`
                }
            },
        ]
    },

    {
        path: "/:catchAll(.*)",
        component: NotFound,
    },
]
const router = createRouter({
    history: routerHistory,
    routes,
})
router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "countriesList" })
        }
        next()
    } else {
        if (localStorage.getItem('token')) {
            next()
        } else {
            next({ name: "login" })
        }
    }
})
export default router

