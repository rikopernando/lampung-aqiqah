import { TESTIMONI } from './mutations'

const state = {
    daftarTestimoni : [],
    loading: true,
}

const getters = {

}

const mutations = {
    TESTIMONI : (state, data)=> {
      state.daftarTestimoni = data;
      state.loading = false;
    },
}

const actions = {
  LOAD_TESTIMONI : ({commit},get) => {
    axios.get('testimoni/view')
    .then(resp => {
      commit('TESTIMONI',resp.data)
    })
    .catch(err =>{
      console.log('Terjadi Kesalahan :', err);
    });
  },

  LOAD_TESTIMONI_INDEX : ({commit},get) => {
    axios.get('testimoni/data')
    .then(resp => {
      commit('TESTIMONI',resp.data)
    })
    .catch(err =>{
      console.log('Terjadi Kesalahan :', err);
    });
  },

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
