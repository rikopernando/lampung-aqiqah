import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import user from './user'
import lokasi from './lokasi'
import keranjangbelanja from './keranjangbelanja'
import detailproduk from './detailproduk'
import daftarproduk from './daftarproduk'
import testimoni from './testimoni'
import berita from './berita'
import setting_perusahaan from './setting-perusahaan'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    awesome: true
  },
  modules : {
    user,
    lokasi,
    keranjangbelanja,
    detailproduk,
    daftarproduk,
    testimoni,
    berita,
    setting_perusahaan
  }
})

export default store
