import { BERITA,BERITADETAIL } from './mutations'

const state = {
    daftarBerita : [],
    countBerita:0,
    loading: true,
}

const getters = {

}

const mutations = {
    BERITA : (state, data)=> {
      state.daftarBerita = data.data_berita;
      state.countBerita = data.count_berita;
      state.loading = false;
      console.log(data.data_berita)
      console.log(data.count_berita)
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
  LOAD_BERITA_LIST : ({commit},get) => {
    axios.get('berita/data')
    .then(resp => {
      commit('BERITA',resp.data)
    })
    .catch(err =>{
      console.log('Terjadi Kesalahan :', err);
    });
  },
  LOAD_BERITA_DETAIL : ({commit},get) => {
    axios.get('berita/detail/'+get.id)
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
