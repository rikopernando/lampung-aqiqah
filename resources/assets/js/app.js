require('./bootstrap');

window.Vue = require('vue');

import routes from './router'
import store from './store'
import VueRouter from 'vue-router'
import VueMaterial from 'vue-material'
import Sidebar from './components/dashboard/index'

import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css' // This line here
import './auth'

window.Vue.use(VueRouter)
window.$ = window.jQuery = require('jquery')


// Global Vue Components
Vue.component('sidebar', Sidebar)
Vue.component('selectize-component', require('vue2-selectize'))


Vue.use(VueMaterial)

const router = new VueRouter({ routes })

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
    store
}).$mount('#app')
