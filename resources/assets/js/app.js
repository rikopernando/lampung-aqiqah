require('./bootstrap');

window.Vue = require('vue');

import routes from './router'
import store from './store'
import VueRouter from 'vue-router'
import VueMaterial from 'vue-material'
import vSelect from 'vue-select'
import Sidebar from './components/sidebar/index'
import axios from 'axios'
import { LOGIN } from './store/user/mutations'

import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css' // This line here

window.Vue.use(VueRouter)
window.$ = window.jQuery = require('jquery')


// Global Vue Components
Vue.component('sidebar', Sidebar)
Vue.component('selectize-component', require('vue2-selectize'))
Vue.component('v-select',vSelect)
Vue.use(VueMaterial)


const router = new VueRouter({ routes })
const url = window.location.origin + window.location.pathname 

router.beforeEach((to, from, next) => {

    axios.get(url+'auth')
    .then((resp) => {
       store.dispatch('keranjangbelanja/LOAD_KERANJANG_LIST')
       resp.data && store.commit(`user/${LOGIN}`,resp.data)
       resp.data ? beforeRoute(true,resp.data.role.role_id) : beforeRoute(false,0) 
    })
    .catch((err) => {
      console.log(err)
    })

    var beforeRoute = (loggedIn, is_admin) => {
      if (to.matched.some(record => record.meta.requiresAuth)) {
      
            if (!loggedIn) {
                next({ path: '/'})
            }else if(to.matched.some(record => record.meta.is_admin)){

                if(is_admin == "1"){
                  next()
                }else{
                  next({ path: '/'})
                }

            }else {
                next()
            }

      }else {
        next()
      }

    }

})

const app = new Vue({
    router,
    store
}).$mount('#app')
