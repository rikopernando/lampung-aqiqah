import { BERITA,BERITADETAIL } from './mutations'

const state = {
    daftarBerita : [],
    loading: true,
}

const getters = {

}

const mutations = {
    BERITA : (state, data)=> {
      state.daftarBerita = data;
      state.loading = false;
    },
    BERITADETAIL : (state, data)=> {
      state.daftarBerita = data;
      state.loading = false;
    },
}

const actions = {
  LOAD_BERITA : ({commit},get) => {
    axios.get('berita/view')
    .then(resp => {
      commit('BERITA',resp.data)
    })
    .catch(err =>{
      console.log('Terjadi Kesalahan :', err);
    });
  },
  LOAD_BERITA_DETAIL : ({commit},get) => {
    axios.get('berita/'+get.id)
    .then(resp => {
      commit('BERITADETAIL',resp.data)
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
