import Vue from 'vue'
import Vuex from 'vuex'
import user from './user'
import keranjangbelanja from './keranjangbelanja'
import axios from 'axios'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    awesome: true
  },
  modules : {
    user,keranjangbelanja
  }
})

export default store
