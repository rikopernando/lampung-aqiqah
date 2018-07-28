require('./bootstrap');

window.Vue = require('vue');

import routes from './router'
import VueRouter from 'vue-router'
import VueMaterial from 'vue-material'
import Sidebar from './components/dashboard/index'

// Plugins
import GlobalComponents from './globalComponents'
import GlobalDirectives from './globalDirectives'
import Notifications from './components/NotificationPlugin'

// MaterialDashboard plugin
import MaterialDashboard from './material-dashboard'

import Chartist from 'chartist'


import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css' // This line here

window.Vue.use(VueRouter)

Vue.use(VueMaterial)

Vue.use(MaterialDashboard)
Vue.use(GlobalComponents)
Vue.use(GlobalDirectives)
Vue.use(Notifications)

// global library setup
Object.defineProperty(Vue.prototype, '$Chartist', {
  get () {
    return this.$root.Chartist
  }
})

const router = new VueRouter({ routes, linkExactActiveClass: 'nav-item active' })

const app = new Vue({
    router,
    data: {
	    Chartist: Chartist
	}
}).$mount('#app')
