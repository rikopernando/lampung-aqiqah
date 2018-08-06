<template>
  <div>
      <div class="form-group">
        <input type="text" class="form-control form-checkout" placeholder="Nama Pemesan" v-on:input="pesanan.nama_pemesan = $event.target.value" id="nama_pemesan">
        <span v-if="errors.nama_pemesan" class="error-message"> {{ errors.nama_pemesan[0] }} </span>
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.alamat = $event.target.value" class="form-control form-checkout" placeholder="Alamat" id="alamat">
        <span v-if="errors.alamat" class="error-message"> {{ errors.alamat[0] }} </span>
      </div>
      <div class="form-group">
        <selectize-component :settings="select_provinsi" ref="provinsi" v-on:input="pilihWilayah('kabupaten')" v-model="selected_provinsi">
          <option v-for="provinsi, index in provinsi" v-bind:value="provinsi.id">{{ provinsi.name }} </option> 
        </selectize-component>
        <span v-if="errors.provinsi" class="error-message"> {{ errors.provinsi[0] }} </span>
      </div>
      <div class="form-group">
        <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kabupaten"></md-progress-bar>
        <p class="waiting" v-if="this.$store.state.lokasi.load_kabupaten">Mohon tunggu ...</p>
        <selectize-component :settings="select_kabupaten" ref="kabupaten" v-on:input="pilihWilayah('kecamatan')" v-model="selected_kabupaten" v-if="showKabupaten">
          <option v-for="kabupaten, index in kabupaten" v-bind:value="kabupaten.id">{{ kabupaten.name }} </option> 
        </selectize-component>
        <span v-if="errors.kabupaten" class="error-message"> {{ errors.kabupaten[0] }} </span>
      </div>
      <div class="form-group">
        <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kecamatan"></md-progress-bar>
        <p class="waiting" v-if="this.$store.state.lokasi.load_kecamatan">Mohon tunggu ...</p>
        <selectize-component :settings="select_kecamatan" ref="kecamatan" v-on:input="pilihWilayah('kelurahan')" v-model="selected_kecamatan" v-if="showKecamatan">
          <option v-for="kecamatan, index in kecamatan" v-bind:value="kecamatan.id">{{ kecamatan.name }} </option> 
        </selectize-component>
        <span v-if="errors.kecamatan" class="error-message"> {{ errors.kecamatan[0] }} </span>
      </div>
      <div class="form-group">
        <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kelurahan"></md-progress-bar>
        <p class="waiting" v-if="this.$store.state.lokasi.load_kelurahan">Mohon tunggu ...</p>
        <selectize-component :settings="select_kelurahan" ref="kelurahan" v-on:input="changeKelurahan()" v-model="selected_kelurahan" v-if="showKelurahan">
          <option v-for="kelurahan, index in kelurahan" v-bind:value="kelurahan.id">{{ kelurahan.name }} </option> 
        </selectize-component>
        <span v-if="errors.kelurahan" class="error-message"> {{ errors.kelurahan[0] }} </span>
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.handphone = $event.target.value" class="form-control form-checkout" placeholder="Handphone" id="handphone">
        <span v-if="errors.handphone" class="error-message"> {{ errors.handphone[0] }} </span>
      </div>
      <div class="form-group">
        <input type="email" v-on:input="pesanan.email = $event.target.value" class="form-control form-checkout" placeholder="Email" id="email">
        <span v-if="errors.email" class="error-message"> {{ errors.email[0] }} </span>
      </div>
      <div class="form-group">
        <selectize-component :settings="selectsumberInformasi" v-on:input="changeSumberInformasi()" ref="sumber_informasi">
          <option v-for="sumberinformasi, index in sumber_informasi" v-bind:value="sumberinformasi">{{ sumberinformasi }} </option> 
        </selectize-component>
        <span v-if="errors.sumber_informasi" class="error-message"> {{ errors.sumber_informasi[0] }} </span>
      </div>
      <div class="form-group">
        <textarea v-on:input="pesanan.catatan = $event.target.value" class="form-control form-checkout" placeholder="Catatan" id="catatan"></textarea>
        <span v-if="errors.catatan" class="error-message"> {{ errors.catatan[0] }} </span>
      </div>
    </div>
    <div class="form-group">
      <input type="text" v-on:input="pesanan.alamat = $event.target.value" class="form-control" placeholder="Alamat">
    </div>
    <div class="form-group">
      <selectize-component :settings="select_provinsi" ref="provinsi" v-on:input="pilihWilayah('kabupaten')">
        <option v-for="provinsi, index in provinsi" v-bind:value="provinsi.id">{{ provinsi.name }} </option> 
      </selectize-component>
    </div>
    <div class="form-group">
      <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kabupaten"></md-progress-bar>
      <p class="waiting" v-if="this.$store.state.lokasi.load_kabupaten">Mohon tunggu ...</p>
      <selectize-component :settings="select_kabupaten" ref="kabupaten" v-on:input="pilihWilayah('kecamatan')">
        <option v-for="kabupaten, index in kabupaten" v-bind:value="kabupaten.id">{{ kabupaten.name }} </option> 
      </selectize-component>
    </div>
    <div class="form-group">
      <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kecamatan"></md-progress-bar>
      <p class="waiting" v-if="this.$store.state.lokasi.load_kecamatan">Mohon tunggu ...</p>
      <selectize-component :settings="select_kecamatan" ref="kecamatan" v-on:input="pilihWilayah('kelurahan')">
        <option v-for="kecamatan, index in kecamatan" v-bind:value="kecamatan.id">{{ kecamatan.name }} </option> 
      </selectize-component>
    </div>
    <div class="form-group">
      <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kelurahan"></md-progress-bar>
      <p class="waiting" v-if="this.$store.state.lokasi.load_kelurahan">Mohon tunggu ...</p>
      <selectize-component :settings="select_kelurahan" ref="kelurahan" v-on:input="changeKelurahan()">
        <option v-for="kelurahan, index in kelurahan" v-bind:value="kelurahan.id">{{ kelurahan.name }} </option> 
      </selectize-component>
    </div>
    <div class="form-group">
      <input type="text" v-on:input="pesanan.handphone = $event.target.value" class="form-control" placeholder="Handphone">
    </div>
    <div class="form-group">
      <input type="email" v-on:input="pesanan.email = $event.target.value" class="form-control" placeholder="Email">
    </div>
    <div class="form-group">
      <selectize-component :settings="selectsumberInformasi" v-on:input="changeSumberInformasi()" ref="sumber_informasi">
        <option v-for="sumberinformasi, index in sumber_informasi" v-bind:value="sumberinformasi">{{ sumberinformasi }} </option> 
      </selectize-component>
    </div>
    <div class="form-group">
      <textarea v-on:input="pesanan.notes = $event.target.value" class="form-control" placeholder="Catatan"></textarea>
    </div>
  </div>
</template>

<script>
import { LOAD_DATA } from '../../store/lokasi/mutations'

  import { LOAD_DATA } from '../../store/lokasi/mutations'
  import { mapState } from 'vuex'

  export default {
      props : ["pesanan" ,"select_provinsi" ,"select_kabupaten", "select_kecamatan" ,"select_kelurahan" ,"selectsumberInformasi", "sumber_informasi" ,"provinsi" ,"kabupaten" ,"kecamatan" ,"kelurahan","errors"],
      mounted () {
        this.setProfile()
      },
      data : () => ({
        showKabupaten : false,
        showKecamatan : false,
        showKelurahan : false,
        selected_provinsi : '',
        selected_kabupaten : '',
        selected_kecamatan : '',
        selected_kelurahan : '',
      }),
      computed : mapState ({
        profile () {
           return this.$store.state.user.profile
        },
      }),
      watch : {
        kabupaten : function () {
          if(Object.keys(this.kabupaten).length){
            this.showKabupaten = true
            this.selected_kabupaten && this.setWilayah('kecamatan',this.selected_kabupaten) 
          }
        },
        kecamatan : function () {
          if(Object.keys(this.kecamatan).length){
            this.showKecamatan = true
            this.selected_kecamatan && this.setWilayah('kelurahan',this.selected_kecamatan) 
          }
        },
        kelurahan : function () {
          if(Object.keys(this.kelurahan).length){
            this.showKelurahan = true
          }
        },
        profile : function () {
           this.setProfile()
        }
      },
      methods: {
        setProfile() {
          const app = this
          if(Object.keys(app.profile).length){
              app.pesanan.nama_pemesan = app.profile.name
              app.pesanan.alamat = app.profile.alamat
              app.pesanan.provinsi = app.profile.provinsi
              app.pesanan.kabupaten = app.profile.kabupaten
              app.pesanan.kecamatan = app.profile.kecamatan
              app.pesanan.kelurahan = app.profile.kelurahan
              app.pesanan.handphone = app.profile.no_telp
              app.pesanan.email = app.profile.email
              app.selected_provinsi = app.profile.provinsi
              app.selected_kabupaten = app.profile.kabupaten
              app.selected_kecamatan = app.profile.kecamatan
              app.selected_kelurahan = app.profile.kelurahan
              $("#nama_pemesan").val(app.profile.name)
              $("#alamat").val(app.profile.alamat)
              $("#handphone").val(app.profile.no_telp)
              $("#email").val(app.profile.email)
              $("#provinsi").val(app.profile.provinsi)
              app.setWilayah('kabupaten',app.selected_provinsi)
          }
        },
        changeKelurahan () {
            this.pesanan.kelurahan = this.$refs.kelurahan.$el.selectize.getValue()
        },
        changeSumberInformasi () {
            this.pesanan.sumber_informasi = this.$refs.sumber_informasi.$el.selectize.getValue()
        },
        pilihWilayah(type) {
          const app = this
          var id_wilayah 
            switch (type) {
                case "kabupaten":
                  id_wilayah = app.selected_provinsi
                  app.pesanan.provinsi = id_wilayah
                  if(id_wilayah){
                      app.pesanan.kabupaten = null 
                      app.pesanan.kecamatan = null
                      app.pesanan.kelurahan = null
                      app.selected_kabupaten = null 
                      app.selected_kecamatan = null
                      app.selected_kelurahan = null
                      app.showKabupaten = false
                      app.showKecamatan = false
                      app.showKelurahan = false
                  }
                    break;
                case "kecamatan":
                  id_wilayah = app.selected_kabupaten
                  app.pesanan.kabupaten = id_wilayah
                  if(id_wilayah){
                      app.pesanan.kecamatan = null
                      app.pesanan.kelurahan = null
                      app.selected_kecamatan = null
                      app.selected_kelurahan = null
                      app.showKecamatan = false
                      app.showKelurahan = false
                  }
                    break;
                case "kelurahan":
                  id_wilayah = app.selected_kecamatan
                  app.pesanan.kecamatan = id_wilayah
                  if(id_wilayah){
                      app.pesanan.kelurahan = null
                      app.selected_kelurahan = null
                      app.showKelurahan = false
                  }
                    break;
            }

          if(id_wilayah){
              app.setWilayah(type,id_wilayah)
          }
        },
        setWilayah(type,id_wilayah) {
          const app = this
          if(id_wilayah){
              app.$store.commit(`lokasi/${LOAD_DATA}`,{data : type, status : 1})
              app.$store.dispatch('lokasi/LOAD_WILAYAH',{
                type : type,
                id : id_wilayah,
                status : 1
              })
          }
        break;
        case "kecamatan":
          id_wilayah = app.$refs.kabupaten.$el.selectize.getValue()
          if(id_wilayah){
            app.pesanan.kabupaten = id_wilayah
            app.pesanan.kecamatan = null
            app.pesanan.kelurahan = null
            selectize = app.$refs.kecamatan.$el.selectize
            selectize.clearOptions()
            app.$refs.kelurahan.$el.selectize.clearOptions()
            app.$refs.kelurahan.$el.selectize.disable()
          }
        break;
        case "kelurahan":
          id_wilayah = app.$refs.kecamatan.$el.selectize.getValue()
          if(id_wilayah){
            app.pesanan.kecamatan = id_wilayah
            app.pesanan.kelurahan = null
            selectize = app.$refs.kelurahan.$el.selectize
            selectize.clearOptions()
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
        selectize.enable()
        selectize.focus()
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
  .error-message {
    background-color:  #ff4d4d;
    border-radius: 2px;
    font-weight: bold;
    color: white;
    padding : 4px;
  }
</style>
