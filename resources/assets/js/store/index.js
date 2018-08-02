import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import user from './user'
import lokasi from './lokasi'
import keranjangbelanja from './keranjangbelanja'
import axios from 'axios'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    awesome: true
  },
  modules : {
    user,lokasi,keranjangbelanja
  }
})

export default store
