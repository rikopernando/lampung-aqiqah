require('./bootstrap');

window.Vue = require('vue');

import routes from './router'
import VueRouter from 'vue-router'
import { MdButton, MdContent, MdTabs, MdIcon, MdToolbar, MdTooltip, MdDrawer, MdList, MdBadge } from 'vue-material/dist/components'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css' // This line here

window.Vue.use(VueRouter)

Vue.use(MdButton)
Vue.use(MdContent)
Vue.use(MdTabs)
Vue.use(MdIcon)
Vue.use(MdToolbar)
Vue.use(MdTooltip)
Vue.use(MdDrawer)
Vue.use(MdList)
Vue.use(MdBadge)


const router = new VueRouter({ routes })

const app = new Vue({
    router
}).$mount('#app')
