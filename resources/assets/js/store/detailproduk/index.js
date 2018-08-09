import { DATADETAILPRODUK } from './mutations'

const state = {
    detailProduk : {},
    loadingModal:true,
}

const getters = {
  
}

const mutations = {
    DATADETAILPRODUK : (state, data)=> {
      console.log(data);
      state.detailProduk = data;
      state.loadingModal = false;

    },
    
}

const actions = {      
  LOAD_DETAIL_PRODUK : ({commit},getdelete) => {
    axios.get('produk/lihat-detail/'+getdelete.id)
    .then(resp => {
      commit('DATADETAILPRODUK',resp.data)
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