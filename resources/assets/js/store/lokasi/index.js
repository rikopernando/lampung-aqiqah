import { LOAD_DATA, GET_PROVINSI } from './mutations'

const state = {
    load_data : false,
    provinsi : [],
    kabupaten : [],
    kecamatan : [],
    kelurahan : []
}

const getters = {
  
}

const mutations = {
    [GET_PROVINSI] (state, provinsi) {
      state.load_data = false
      state.provinsi = provinsi
    },

    [LOAD_DATA] (state, provinsi) {
      state.load_data = true
    }
}

const actions = {
    LOAD_PROVINSI : ({commit}) => {
      axios.get('pesanan/provinsi')
      .then((resp) => {
        commit(GET_PROVINSI, resp.data)
      })
      .catch((err) => {
        console.log(err)
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

