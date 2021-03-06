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

import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import quillEditor from 'vue-quill-editor'

window.Vue.use(VueRouter)
window.$ = window.jQuery = require('jquery')

import Paging from './components/paging/paging'

// Global Vue Components
Vue.component('pagination', require('laravel-vue-pagination'))
Vue.component('sidebar', Sidebar)
Vue.component('selectize-component', require('vue2-selectize'))
Vue.component('v-select', vSelect)
Vue.component('paging', Paging)
Vue.use(quillEditor)
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
