import './bootstrap';
import '../sass/app.scss'
import Router from './components/router/index.js'
import { createApp } from 'vue/dist/vue.esm-bundler'
import store from './components/store'

const app = createApp({})

app.use(Router)
app.use(store)

app.mount('#app')

