import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import user from './user'
import lokasi from './lokasi'
import keranjangbelanja from './keranjangbelanja'
import detailproduk from './detailproduk'
import daftarproduk from './daftarproduk'
import testimoni from './testimoni'
import laporanorder from './laporanorder'
import berita from './berita'

Vue.use(Vuex)

console.log('index store:', laporanorder)

const store = new Vuex.Store({
  state: {
    awesome: true
  },
  modules : {
    user, lokasi, keranjangbelanja, detailproduk, daftarproduk, testimoni, laporanorder,berita
  }
})

export default store
