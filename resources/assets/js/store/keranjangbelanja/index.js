import { COUNTKERANJANG,SUBTOTALKERANJANG,DELETEKERANJANG,TAMBAHJUMLAHKERANJANG,CREATEKERANJANG } from './mutations'

const state = {
    datakeranjang : {},
    loading:true,
    subtotal:0,
    total_akhir:0,
    status:null,
    countKeranjang:0
}

const getters = {
  
}

const mutations = {
    COUNTKERANJANG : (state, data)=> {
      state.loading = false
      state.datakeranjang = data
      state.countKeranjang = data.count_keranjang;
    },
    SUBTOTALKERANJANG : (state, data)=> {
      state.loading = false
      state.subtotal = parseInt(data.subtotal)
      state.total_akhir = parseInt(data.subtotal)
    },
    DELETEKERANJANG : (state,data)=> {
          var subtotal = parseInt(state.subtotal) - parseInt(data.subtotal)
          state.subtotal = subtotal;
          state.total_akhir = subtotal;
          state.countKeranjang -= parseInt(1);

        function cekTbs(tbs) { 
          return tbs.id_keranjang_belanja === data.id
        }

        var index = state.datakeranjang.data_keranjang.findIndex(cekTbs)
        state.datakeranjang.data_keranjang.splice(index,1)

    },
    TAMBAHJUMLAHKERANJANG : (state,data)=> {
        var subtotalupdate = parseInt(state.subtotal) + parseInt(data.harga_produk)
        state.subtotal = subtotalupdate;
        state.total_akhir = subtotalupdate;

        function cekTbs(tbs) { 
          return tbs.id_keranjang_belanja === data.id_keranjang_belanja
        }

        var index = state.datakeranjang.data_keranjang.findIndex(cekTbs)
        state.datakeranjang.data_keranjang[index].jumlah_produk += parseInt(1)
        state.datakeranjang.data_keranjang[index].subtotal += parseInt(data.harga_produk)
    },
    KURANGJUMLAHKERANJANG : (state,{respdata,data})=> {
        if (respdata.status == 0){
           state.status = respdata.status;
        }else{
          var subtotalupdate = parseInt(state.subtotal) - parseInt(data.harga_produk)
          state.subtotal = subtotalupdate;
          state.total_akhir = subtotalupdate;

          function cekTbs(tbs) { 
            return tbs.id_keranjang_belanja === data.id_keranjang_belanja
          }

          var index = state.datakeranjang.data_keranjang.findIndex(cekTbs)
          state.datakeranjang.data_keranjang[index].jumlah_produk -= parseInt(1)
          state.datakeranjang.data_keranjang[index].subtotal -= parseInt(data.harga_produk)
          state.status = respdata.status;
        }
    },
    CREATEKERANJANG : (state,{respdata,data})=> {
      if (respdata == 1) {
           state.countKeranjang += parseInt(1);
        }
    },
    CLEARKERANJANG : (state) => {
        state.datakeranjang = {};
        state.loading = true;
        state.subtotal = 0;
        state.total_akhir = 0;
        state.status = null;
        state.countKeranjang = 0;
    }
}

const actions = {      
  LOAD_KERANJANG_LIST : ({commit}) => {
    axios.get('keranjang-belanja/view')
    .then(resp => {
      commit('COUNTKERANJANG',resp.data)
    })
    .catch(err =>{
      console.log('Terjadi Kesalahan :', err);
    });
  },
  LOAD_SUBTOTAL_LIST : ({commit}) => {
      axios.get('keranjang-belanja/subtotal-keranjang-belanja')
        .then(resp => {
            commit('SUBTOTALKERANJANG',resp.data)
         })
        .catch(err => {
          console.log('Terjadi Kesalahan :',err);
    });
  },
  LOAD_DELETE_LIST : ({commit},getdelete) => {
      axios.delete('keranjang-belanja/'+getdelete.id)
        .then(resp => {
          commit('DELETEKERANJANG',getdelete)
        })
        .catch(err => {
          console.log('Terjadi Kesalahan Konfirmasi Delete :', err);
        })
  },
  LOAD_TAMBAH_JUMLAH_LIST : ({commit},get) => {
        axios.post('keranjang-belanja/edit-jumlah-keranjang/'+get.id_keranjang_belanja+'/'+get.operator)
        .then(resp => {
          commit('TAMBAHJUMLAHKERANJANG',get)
        })
        .catch(err => {
          console.log('Terjadi Kesalahan :', err);
        })
  },
  LOAD_KURANG_JUMLAH_LIST : ({commit},get) => {
        axios.post('keranjang-belanja/edit-jumlah-keranjang/'+get.id_keranjang_belanja+'/'+get.operator)
        .then(resp => {
          commit('KURANGJUMLAHKERANJANG',{respdata:resp.data,data:get})
        })
        .catch(err => {
          console.log('Terjadi Kesalahan :', err);
        })
  },
  LOAD_CREATE_LIST : ({commit},get) => {
        axios.post('keranjang-belanja/create/'+get.id+'/'+get.jumlah_produk)
        .then(resp => {
          commit('CREATEKERANJANG',{respdata:resp.data,data:get})
        })
        .catch(err => {
          console.log('Terjadi Kesalahan :', err);
        })
  }

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
