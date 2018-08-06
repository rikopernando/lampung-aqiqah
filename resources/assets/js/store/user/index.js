import { LOGIN, LOGOUT } from './mutations'

const state = {
  profile : {},
  loggedIn : false,
  is_admin : false
}

const getters = {
  
}

const mutations = {
  [LOGIN] (state, user) {
    if(user.role.role_id === 1){
     state.is_admin = true
    }
    state.loggedIn = true
    state.profile = {
      name : user.name,
      email : user.email,
      id : user.id
    }
  },
  [LOGOUT] (state) {
    state.is_admin = false
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

