import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import user from './user'
import lokasi from './lokasi'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    awesome: true
  },
  modules : {
    user,lokasi
  }
})

export default store

