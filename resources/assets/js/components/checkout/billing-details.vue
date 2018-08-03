<template>
  <div>
      <div class="form-group">
        <input type="text" class="form-control form-checkout" placeholder="Nama Pemesan" v-on:input="pesanan.nama_pemesan = $event.target.value">
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.alamat = $event.target.value" class="form-control form-checkout" placeholder="Alamat">
      </div>
      <div class="form-group">
        <selectize-component :settings="select_provinsi" ref="provinsi" v-on:input="pilihWilayah('kabupaten')">
          <option v-for="provinsi, index in provinsi" v-bind:value="provinsi.id">{{ provinsi.name }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kabupaten"></md-progress-bar>
        <p class="waiting" v-if="this.$store.state.lokasi.load_kabupaten">Mohon tunggu ...</p>
        <selectize-component :settings="select_kabupaten" ref="kabupaten" v-on:input="pilihWilayah('kecamatan')" v-if="showKabupaten">
          <option v-for="kabupaten, index in kabupaten" v-bind:value="kabupaten.id">{{ kabupaten.name }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kecamatan"></md-progress-bar>
        <p class="waiting" v-if="this.$store.state.lokasi.load_kecamatan">Mohon tunggu ...</p>
        <selectize-component :settings="select_kecamatan" ref="kecamatan" v-on:input="pilihWilayah('kelurahan')" v-if="showKecamatan">
          <option v-for="kecamatan, index in kecamatan" v-bind:value="kecamatan.id">{{ kecamatan.name }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kelurahan"></md-progress-bar>
        <p class="waiting" v-if="this.$store.state.lokasi.load_kelurahan">Mohon tunggu ...</p>
        <selectize-component :settings="select_kelurahan" ref="kelurahan" v-on:input="changeKelurahan()" v-if="showKelurahan">
          <option v-for="kelurahan, index in kelurahan" v-bind:value="kelurahan.id">{{ kelurahan.name }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.handphone = $event.target.value" class="form-control form-checkout" placeholder="Handphone">
      </div>
      <div class="form-group">
        <input type="email" v-on:input="pesanan.email = $event.target.value" class="form-control form-checkout" placeholder="Email">
      </div>
      <div class="form-group">
        <selectize-component :settings="selectsumberInformasi" v-on:input="changeSumberInformasi()" ref="sumber_informasi">
          <option v-for="sumberinformasi, index in sumber_informasi" v-bind:value="sumberinformasi">{{ sumberinformasi }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <textarea v-on:input="pesanan.notes = $event.target.value" class="form-control form-checkout" placeholder="Catatan"></textarea>
      </div>
    </div>
</template>

<script>

  import { LOAD_DATA } from '../../store/lokasi/mutations'
  import { mapState } from 'vuex'

  export default {
      props : ["pesanan" ,"select_provinsi" ,"select_kabupaten", "select_kecamatan" ,"select_kelurahan" ,"selectsumberInformasi", "sumber_informasi" ,"provinsi" ,"kabupaten" ,"kecamatan" ,"kelurahan"],
      data : () => ({
        showKabupaten : false,
        showKecamatan : false,
        showKelurahan : false
      }),
      watch : {
        kabupaten : function () {
          if(Object.keys(this.kabupaten).length){
            this.showKabupaten = true
          }
        },
        kecamatan : function () {
          if(Object.keys(this.kecamatan).length){
            this.showKecamatan = true
          }
        },
        kelurahan : function () {
          if(Object.keys(this.kelurahan).length){
            this.showKelurahan = true
          }
        }
      },
      methods: {
        changeKelurahan () {
            this.pesanan.kelurahan = this.$refs.kelurahan.$el.selectize.getValue()
        },
        changeSumberInformasi () {
            this.pesanan.sumber_informasi = this.$refs.sumber_informasi.$el.selectize.getValue()
        },
        pilihWilayah(type) {
          const app = this
          var selectize
          var id_wilayah 
            switch (type) {
                case "kabupaten":
                  id_wilayah = app.$refs.provinsi.$el.selectize.getValue()
                  if(id_wilayah){
                      app.pesanan.provinsi = id_wilayah
                      app.pesanan.kabupaten = null 
                      app.pesanan.kecamatan = null
                      app.pesanan.kelurahan = null
                      app.showKabupaten = false
                      app.showKecamatan = false
                      app.showKelurahan = false
                  }
                    break;
                case "kecamatan":
                  id_wilayah = app.$refs.kabupaten.$el.selectize.getValue()
                  if(id_wilayah){
                      app.pesanan.kabupaten = id_wilayah
                      app.pesanan.kecamatan = null
                      app.pesanan.kelurahan = null
                      app.showKecamatan = false
                      app.showKelurahan = false
                  }
                    break;
                case "kelurahan":
                  id_wilayah = app.$refs.kecamatan.$el.selectize.getValue()
                  if(id_wilayah){
                      app.pesanan.kecamatan = id_wilayah
                      app.pesanan.kelurahan = null
                      app.showKelurahan = false
                  }
                    break;
            }

          if(id_wilayah){
              app.$store.commit(`lokasi/${LOAD_DATA}`,{data : type, status : 1})
              app.$store.dispatch('lokasi/LOAD_WILAYAH',{
                type : type,
                id : id_wilayah,
                status : 1
              })
          }
        }
      }
  }

</script>

<style lang="scss" scoped>
  .waiting {
    font-style: italic;
  }
  .form-checkout {
    font-size: 14px;
  }
</style>
