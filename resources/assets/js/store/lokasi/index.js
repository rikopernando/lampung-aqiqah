import { LOAD_DATA, GET_PROVINSI, GET_KABUPATEN, GET_KECAMATAN, GET_KELURAHAN } from './mutations'

const state = {
    load_kabupaten : false,
    load_kecamatan : false,
    load_kelurahan : false,
    provinsi : [],
    kabupaten : [],
    kecamatan : [],
    kelurahan : []
}

const getters = {
  
}

const mutations = {
    [GET_PROVINSI] (state, provinsi) {
      state.provinsi = provinsi
    },

    [GET_KABUPATEN] (state, kabupaten) {
      state.load_kabupaten = false
      state.kabupaten = kabupaten
    },

    [GET_KECAMATAN] (state, kecamatan) {
      state.load_kecamatan = false
      state.kecamatan = kecamatan
    },

    [GET_KELURAHAN] (state, kelurahan) {
      state.load_kelurahan = false
      state.kelurahan = kelurahan
    },

    [LOAD_DATA] (state,wilayah) {
				switch (wilayah) {
						case "kabupaten":
                state.load_kabupaten = true
								break;
						case "kecamatan":
                state.load_kecamatan = true
								break;
						case "kelurahan":
                state.load_kelurahan = true
								break;
				}
    }
}

const actions = {
    LOAD_PROVINSI : ({commit}) => {
      axios.get('pesanan/provinsi')
      .then((resp) => {
        commit(LOAD_DATA)
        commit(GET_PROVINSI, resp.data)
      })
      .catch((err) => {
        console.log(err)
      })
    },

    LOAD_WILAYAH : ({commit},wilayah) => {
      
      axios.get(`pesanan/pilih-wilayah/${wilayah.id}/${wilayah.type}`)
      .then((resp) => {

				switch (wilayah.type) {
						case "kabupaten":
                commit(GET_KABUPATEN, resp.data)
								break;
						case "kecamatan":
                commit(GET_KECAMATAN, resp.data)
								break;
						case "kelurahan":
                commit(GET_KELURAHAN, resp.data)
								break;
				}

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

