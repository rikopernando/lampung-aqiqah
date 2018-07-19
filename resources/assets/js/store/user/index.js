import { LOGIN, LOGOUT } from './mutations'

const state = {
    profile : {},
    loggedIn : false
}

const getters = {
  
}

const mutations = {
    [LOGIN] (state, user) {
      state.loggedIn = true,
      state.profile = {
        name : user.name,
        email : user.email,
        id : user.id
      }
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

