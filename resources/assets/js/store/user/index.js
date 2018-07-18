import { LOGIN } from './mutations'

const state = {
    loggedIn : false
}

const getters = {
  
}

const mutations = {
    [LOGIN] (state) {
      state.loggedIn = true
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

