<template>
  <div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" v-on:input="kirim_tempat_lain.nama_depan = $event.target.value" placeholder="Nama Depan" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <input type="text" v-on:input="kirim_tempat_lain.nama_belakang = $event.target.value" placeholder="Nama Belakang" class="form-control">
        </div>
      </div>
    </div>

    <div class="form-group">
      <input type="text" v-on:input="kirim_tempat_lain.company_name = $event.target.value" placeholder="Company Name" class="form-control">
    </div>
    <div class="form-group">
      <input type="text" v-on:input="kirim_tempat_lain.alamat = $event.target.value" placeholder="Alamat" class="form-control">
    </div>
    <div class="form-group">
      <selectize-component :settings="select_provinsi" ref="provinsi" v-on:input="pilihWilayah('kabupaten')">
        <option v-for="provinsi, index in provinsi" v-bind:value="provinsi.id">{{ provinsi.name }} </option> 
      </selectize-component>
    </div>
    <div class="form-group">
      <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kabupaten_lain"></md-progress-bar>
      <p class="waiting" v-if="this.$store.state.lokasi.load_kabupaten_lain">Mohon tunggu ...</p>
      <selectize-component :settings="select_kabupaten" ref="kabupaten" v-on:input="pilihWilayah('kecamatan')">
        <option v-for="kabupaten, index in kabupaten" v-bind:value="kabupaten.id">{{ kabupaten.name }} </option> 
      </selectize-component>
    </div>
    <div class="form-group">
      <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kecamatan_lain"></md-progress-bar>
      <p class="waiting" v-if="this.$store.state.lokasi.load_kecamatan_lain">Mohon tunggu ...</p>
      <selectize-component :settings="select_kecamatan" ref="kecamatan" v-on:input="pilihWilayah('kelurahan')">
        <option v-for="kecamatan, index in kecamatan" v-bind:value="kecamatan.id">{{ kecamatan.name }} </option> 
      </selectize-component>
    </div>
    <div class="form-group">
      <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kelurahan_lain"></md-progress-bar>
      <p class="waiting" v-if="this.$store.state.lokasi.load_kelurahan_lain">Mohon tunggu ...</p>
      <selectize-component :settings="select_kelurahan" ref="kelurahan" v-on:input="changeKelurahan()">
        <option v-for="kelurahan, index in kelurahan" v-bind:value="kelurahan.id">{{ kelurahan.name }} </option> 
      </selectize-component>
    </div>
  </div>
</template>

<script>
  
import { mapState } from 'vuex'
import { LOAD_DATA } from '../../store/lokasi/mutations'

export default {
  props : ['kirim_tempat_lain', 'select_provinsi', 'select_kabupaten' , 'select_kecamatan', 'select_kelurahan', 'provinsi'],
  data : () => ({
    load_kabupaten : false,
    load_kecamatan : false,
    load_kelurahan : false
  }),
  computed : mapState ({
    kabupaten () {
      return this.$store.state.lokasi.kabupaten_lain
    },
    kecamatan () {
      return this.$store.state.lokasi.kecamatan_lain
    },
    kelurahan () {
      return this.$store.state.lokasi.kelurahan_lain
    },
  }),
  mounted() {
    this.$refs.kabupaten.$el.selectize.disable()
    this.$refs.kelurahan.$el.selectize.disable()
    this.$refs.kecamatan.$el.selectize.disable()
  },
  methods : {
    changeKelurahan(){
      this.kirim_tempat_lain.kelurahan = this.$refs.kelurahan.$el.selectize.getValue()
    },
    pilihWilayah(type) {
      const app = this
      var selectize
      var id_wilayah 
      switch (type) {
        case "kabupaten":
          id_wilayah = app.$refs.provinsi.$el.selectize.getValue()
          if(id_wilayah){
            app.kirim_tempat_lain.provinsi = id_wilayah
            app.kirim_tempat_lain.kabupaten = null 
            app.kirim_tempat_lain.kecamatan = null
            app.kirim_tempat_lain.kelurahan = null
            selectize = app.$refs.kabupaten.$el.selectize
            app.$refs.kecamatan.$el.selectize.disable()
            app.$refs.kelurahan.$el.selectize.disable()
          }
        break;
        case "kecamatan":
          id_wilayah = app.$refs.kabupaten.$el.selectize.getValue()
          if(id_wilayah){
            app.kirim_tempat_lain.kabupaten = id_wilayah
            app.kirim_tempat_lain.kecamatan = null
            app.kirim_tempat_lain.kelurahan = null
            selectize = app.$refs.kecamatan.$el.selectize
            selectize.clearOptions()
            app.$refs.kelurahan.$el.selectize.clearOptions()
            app.$refs.kelurahan.$el.selectize.disable()
          }
        break;
        case "kelurahan":
          id_wilayah = app.$refs.kecamatan.$el.selectize.getValue()
          if(id_wilayah){
            app.kirim_tempat_lain.kecamatan = id_wilayah
            app.kirim_tempat_lain.kelurahan = null
            selectize = app.$refs.kelurahan.$el.selectize
            selectize.clearOptions()
          }
        break;
      }

      if(id_wilayah){
        app.$store.commit(`lokasi/${LOAD_DATA}`,{data : type, status : 2})
        app.$store.dispatch('lokasi/LOAD_WILAYAH',{
          type : type,
          id : id_wilayah,
          status : 2
        })
        selectize.enable()
        selectize.focus()
      }
    }
  }
}

</script>
