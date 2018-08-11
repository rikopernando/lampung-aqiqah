import { DAFTARPRODUK } from './mutations'

const state = {
    daftarProduk : [],
    loading: true,
}

const getters = {
  
}

const mutations = {
    DAFTARPRODUK : (state, data)=> {
      console.log(data);
      state.daftarProduk = data;
      state.loading = false;
    },
    
}

const actions = {      
  LOAD_DAFTAR_PRODUK : ({commit},get) => {
    axios.get('produk/view-produk/'+get.tampil_produk)
    .then(resp => {
      commit('DAFTARPRODUK',resp.data)
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