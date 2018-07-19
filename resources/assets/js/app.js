require('./bootstrap');

window.Vue = require('vue');

import routes from './router'
import store from './store'
import VueRouter from 'vue-router'
import VueMaterial from 'vue-material'

import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css' // This line here
import './auth'

window.Vue.use(VueRouter)

Vue.use(VueMaterial)


const router = new VueRouter({ routes })

router.beforeEach((to, from, next) => {
	const loggedIn = store.state.user.loggedIn
  console.log(loggedIn)
  if (to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
    next({ path: '/'})
  } else {
    next()
  }
})

const app = new Vue({
    router,store
}).$mount('#app')
