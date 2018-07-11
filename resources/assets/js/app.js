require('./bootstrap');

window.Vue = require('vue');

import routes from './router'
import VueRouter from 'vue-router'
import VueMaterial from 'vue-material' 
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css' // This line here

window.Vue.use(VueRouter)
Vue.use(VueMaterial) 



const router = new VueRouter({ routes })

const app = new Vue({
    router
}).$mount('#app')
