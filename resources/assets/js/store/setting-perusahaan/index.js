import { GET_SETTING_PERUSAHAAN } from './mutations'

const state = {
    data : {},
    loading : true
}

const getters = {
}

const mutations = {
    [GET_SETTING_PERUSAHAAN] (state, data) {
      state.data = data
      state.loading = false
    },
}

const actions = {
    LOAD_SETTING_PERUSAHAAN : ({commit}) => {
      axios.get('setting-perusahaan/data')
      .then((resp) => {
        commit(GET_SETTING_PERUSAHAAN, resp.data)
      })
      .catch((err) => {
        console.log(err)
      })
    },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}

