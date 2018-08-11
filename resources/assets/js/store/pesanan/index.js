import { PESANAN_TERBARU } from './mutations'

const state = {
    pesanan : {},
    detail_pesanan : {},
}

const getters = {
  
}

const mutations = {
    [PESANAN_TERBARU] (state, data) {
      state.pesanan = data.pesanan 
      state.pesanan = data.detail_pesanan 
    }
}

const actions = {

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}

