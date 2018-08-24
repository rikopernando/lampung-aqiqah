const state = {
  orderList: {}
}

const getters = {
  
}

const mutations = {
  updateOrderList (state, data) {
    state.orderList = data
    console.log(data)
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

