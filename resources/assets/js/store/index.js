import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import user from './user'
import lokasi from './lokasi'
import keranjangbelanja from './keranjangbelanja'
import detailproduk from './detailproduk'
import daftarproduk from './daftarproduk'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    awesome: true
  },
  modules : {
    user,lokasi,keranjangbelanja,detailproduk,daftarproduk
  }
})

export default store
