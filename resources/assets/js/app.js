require('./bootstrap');

window.Vue = require('vue');

import routes from './router'
import VueRouter from 'vue-router'

window.Vue.use(VueRouter)

const router = new VueRouter({ routes })

const app = new Vue({
    router
}).$mount('#app')
