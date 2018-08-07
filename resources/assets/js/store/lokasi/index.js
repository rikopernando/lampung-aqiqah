import { 
  LOAD_DATA, 
  GET_PROVINSI, 
  GET_KABUPATEN, 
  GET_KECAMATAN, 
  GET_KELURAHAN 
} from './mutations'

const state = {
  load_kabupaten : false,
  load_kecamatan : false,
  load_kelurahan : false,
  load_kabupaten_lain : false,
  load_kecamatan_lain : false,
  load_kelurahan_lain : false,
  provinsi : [],
  kabupaten : [],
  kecamatan : [],
  kelurahan : [],
  kabupaten_lain : [],
  kecamatan_lain : [],
  kelurahan_lain : []
}

const getters = {
}

const mutations = {
  [GET_PROVINSI] (state, provinsi) {
    state.provinsi = provinsi
  },

  [GET_KABUPATEN] (state, kabupaten) {
    if(kabupaten.status == 1) {
      state.kabupaten = kabupaten.data 
      state.load_kabupaten = false
    } else { 
      state.kabupaten_lain = kabupaten.data
      state.load_kabupaten_lain = false
    }
  },

  [GET_KECAMATAN] (state, kecamatan) {
    if(kecamatan.status == 1){ 
      state.kecamatan = kecamatan.data 
      state.load_kecamatan = false
    } else { 
      state.kecamatan_lain = kecamatan.data
      state.load_kecamatan_lain = false
    }
  },

  [GET_KELURAHAN] (state, kelurahan) {
    if(kelurahan.status == 1){
      state.kelurahan = kelurahan.data 
      state.load_kelurahan = false
    } else { 
      state.kelurahan_lain = kelurahan.data
      state.load_kelurahan_lain = false
    }
  },

  [LOAD_DATA] (state, wilayah) {
    const status = wilayah.status
		switch (wilayah.data) {
			case "kabupaten":
        status == 1 ? state.load_kabupaten = true : state.load_kabupaten_lain = true
			break;
			case "kecamatan":
        status == 1 ? state.load_kecamatan = true : state.load_kecamatan_lain = true
			break;
			case "kelurahan":
        status == 1 ? state.load_kelurahan = true : state.load_kelurahan_lain = true
			break;
		}
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
  },

  LOAD_WILAYAH : ({commit}, wilayah) => {
    axios.get(`pesanan/pilih-wilayah/${wilayah.id}/${wilayah.type}`)
    .then((resp) => {
      const payload = { data : resp.data, status : wilayah.status }
			switch (wilayah.type) {
				case "kabupaten":
          commit(GET_KABUPATEN, payload)
				break;
        case "kecamatan":
          commit(GET_KECAMATAN, payload)
				break;
				case "kelurahan":
          commit(GET_KELURAHAN, payload)
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
