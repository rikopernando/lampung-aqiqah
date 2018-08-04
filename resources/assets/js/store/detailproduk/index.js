import { DATADETAILPRODUK } from './mutations'

const state = {
    dataDetail : {},
}

const getters = {
  
}

const mutations = {
    DATADETAILPRODUK : (state, data)=> {
      console.log(data);
      state.dataDetail = data;
      
    },
    
}

const actions = {      
  LOAD_DETAIL_PRODUK : ({commit}) => {
    axios.get('produk/lihat-detail/'+id_produk)
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