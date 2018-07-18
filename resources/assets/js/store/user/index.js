import { LOGIN, LOGOUT } from './mutations'

const state = {
    profile : {},
    loggedIn : false
}

const getters = {
  
}

const mutations = {
    [LOGIN] (state) {
      state.loggedIn = true
    },
    [LOGOUT] (state) {
      state.loggedIn = false
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

