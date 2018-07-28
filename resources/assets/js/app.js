require('./bootstrap');

window.Vue = require('vue');

import routes from './router'
import store from './store'
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
import './auth'

window.Vue.use(VueRouter)
window.$ = window.jQuery = require('jquery')

Vue.component('selectize-component', require('vue2-selectize'))
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

router.beforeEach((to, from, next) => {
	const loggedIn = store.state.user.loggedIn
	const is_admin = store.state.user.is_admin
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!loggedIn) {
        next({ path: '/'})
    }else if(to.matched.some(record => record.meta.is_admin)){
        if(!is_admin){
          next({ path: '/'})
        }else{
          next()
        }
    }else {
        next()
    }
  }else {
    next()
  }
})

const app = new Vue({
    router,
    store,
    data: {
	    Chartist: Chartist
	}
}).$mount('#app')
